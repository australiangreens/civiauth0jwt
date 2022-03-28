<?php

namespace Civi\CiviAuth0Jwt;

use Civi\CiviAuth0Jwt\Exception;

/**
 * Listen - class with listener definitions
 *
 */
class Listen {
  public static function jwtClaimsCheck(\Civi\Authx\JwtClaimsCheckEvent $event) {
    $claims = $event->claims;

    // TODO: Temporary
    // For now, we just accept the scope, whether or not it contains 'authx',
    // this might not be necessary later
    $event->acceptScope();

    if (!empty($claims['sub'])) {
      $forceUserId = \Civi::settings()->get('civiauth0jwt_force_user_id');
      if (empty($forceUserId)) {
        list($userId, $rejectionMsg) = self::getCmsUserId($claims['sub']);
        if ($userId) {
          $event->acceptSub(['userId' => $userId]);
        } else {
          // TODO: Here we are explicitly rejecting. Could instead do nothing and let authx process as normal
          $event->rejectSub($rejectionMsg);
        }
      } else {
        \Civi::log()->debug("jwtClaimsCheck() called. Unparsed sub = $claims[sub]. Mapped to userId = $forceUserId [set by civiauth0jwt_force_cid]");
        $event->acceptSub(['userId' => $forceUserId]);
      }
    } else {
      \Civi::log()->debug("jwtClaimsCheck() called. Rejected because sub claim missing");
      $event->rejectSub('Missing sub claim');
    }
  }

  private static function getCmsUserId($subClaim) {
    $userId = null;
    try {
      $auth0User = new Auth0User($subClaim);
      $userId = $auth0User->getCmsUserId();
      \Civi::log()->debug("jwtClaimsCheck() called. Parsed auth0Id = " . $auth0User->auth0Id . ". Mapped to userId = $userId");
    } catch (Exception\SubClaimParseException $e) {
      $rejectionMsg = "jwtClaimsCheck() called. Rejected because sub claim couldn't be parsed: " . $e->getMessage();
      $rejectionMsg = 'Failed to parse sub claim';
    } catch (Exception\UserMatchNotFoundException $e) {
      \Civi::log()->debug("jwtClaimsCheck() called. Rejected because user match not found: " . $e->getMessage());
      $rejectionMsg = 'Unable to match to valid user';
    }

    return [$userId, $rejectionMsg];
  }
}
