<?php

namespace Civi\CiviAuth0Jwt;

/**
 * Listen - class with listener definitions
 *
 */
class Listen {
  public static function jwtClaimsCheck(\Civi\Authx\JwtClaimsCheckEvent $e) {
    $claims = $e->claims;

    // TODO: Temporary
    // For now, we just accept the scope, whether or not it contains 'authx',
    // this might not be necessary later
    $e->acceptScope();

    // Parse auth0's
    if (!empty($claims['sub']) && substr($claims['sub'], 0, 6) === 'auth0|') {
      $auth0Id = substr($claims['sub'], 6);

      // This is where we'd do a lookup
      // For now just pretend.
      $forceUserId = \Civi::settings()->get('civiauth0jwt_force_user_id');
      if (empty($forceUserId)) {
        $NOTIMPLEMENTED = true;
      } else {
        $userId = $forceUserId;
      }

      if ($userId) {
        \Civi::log()->debug("jwtClaimsCheck() called. Parsed auth0id = $auth0Id. Mapped to userId = $userId" . (empty($forceUserId) ? '' : ' [set by civiauth0jwt_force_cid]'));
        $e->acceptSub(['userId' => $userId]);
      } else {
        if ($NOTIMPLEMENTED) {
          \Civi::log()->debug("jwtClaimsCheck() called. Parsed auth0id = $auth0Id, but non-forced user_id not implemented yet");
          $e->rejectSub("Non-forced cid not implemented yet");
        } else {
          \Civi::log()->debug("jwtClaimsCheck() called. Parsed auth0id = $auth0Id, but unable to map to a userId");
          $e->rejectSub("Parsed auth0id = $auth0Id, but unable to map to a userId");
        }
      }
    } else {
      // Lets say we instead didn't find it. We have the choice over either
      // calling rejectSub, or do nothing, which will allow authx to process as
      // normal
      \Civi::log()->debug("jwtClaimsCheck() called. Rejected because sub claim missing auth0 id");
      $e->rejectSub('Sub claim is missing auth0 id');
    }
  }
}
