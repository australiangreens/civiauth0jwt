<?php

namespace Civi\CiviAuth0Jwt;

use Civi\Crypto\Exception\CryptoException;
use Civi\Authx\CheckCredentialEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckAuth0JwtCredential implements EventSubscriberInterface {

  /**
   * Listener priority for handling credential format of 'Basic' with
   * 'username:password'.
   */
  const PRIORITY_BEARER_AUTH0_JWT = 200;

  /**
   * @inheritdoc
   *
   * Set up single subscriber to handle different the expected credential format
   * of 'Bearer', with a type of 'jwt', specifically whatever the listener for
   * authx's equivalent does not handle. However we have a higher priority here
   * so it will be processed anyway, so it is only relevant in the situation
   * where it is not an auth0 jwt.
   */
  public static function getSubscribedEvents(): array {
    $events = [];
    $events['civi.authx.checkCredential'][] = ['bearerAuth0Jwt', self::PRIORITY_BEARER_AUTH0_JWT];
    return $events;
  }

  /**
   * Interpret the HTTP `Bearer` credential as an Auth0-style JSON Web Token.
   *
   * Authx has an equivalent subscriber that will return without processing if
   * the scope does not contain 'authx'.
   *
   * @param Civi\Authx\CheckCredentialEvent $checkEvent
   */
  public function bearerAuth0Jwt(CheckCredentialEvent $checkEvent): void {
    if ($checkEvent->credFormat === 'Bearer') {
      try {
        $claims = \Civi::service('crypto.jwt')->decode($checkEvent->credValue, 'SIGN_AUTH0');

        // TODO: Is there a specific scope we can check for, similar to how authx now checks?
        $scopes = isset($claims['scope']) ? explode(' ', $claims['scope']) : [];
        if (!in_array('openid', $scopes)) {
          // The openid scope is a minimum. We might be dealing with a non-auth0
          // token so proceed to check any other token sources.
          return;
        }

        if (empty($claims['sub'])) {
          // TODO: What about the sub being in wrong format?
          // || substr($claims['sub'], 0, 5) !== 'auth0|'
          // TODO: Or if we aren't checking scope, should it it just return, not reject?
          Logger::debug("REJECTED, malformed JWT, missing sub.");
          $checkEvent->reject('Malformed JWT. Missing sub');
          return;
        }

        $userId = \Civi::settings()->get('civiauth0jwt_force_user_id');
        if (!empty($userId)) {
          Logger::debug("ACCEPTED, sub = $claims[sub] mapped to userId = $userId [set by civiauth0jwt_force_cid]");
          $checkEvent->accept(['userId' => $userId, 'credType' => 'jwt', 'jwt' => $claims]);
          return;
        }

        list($userId, $rejectionMsg) = self::getCmsUserId($claims['sub']);

        if ($userId) {
          Logger::debug("ACCEPTED, sub = $claims[sub] mapped to userId = $userId");
          $checkEvent->accept(['userId' => $userId, 'credType' => 'jwt', 'jwt' => $claims]);
          return;
        }
        else {
          // TODO: Here we are explicitly rejecting. Could instead do nothing and let authx process as normal?
          $checkEvent->reject($rejectionMsg);
        }
      }
      catch (CryptoException $e) {
        // Not a valid AuthX JWT. Proceed to check any other token sources.
        Logger::debug("IGNORED, decode failed (CryptoException): " . $e->getMessage());
      }
      catch (\Exception $e) {
        Logger::debug("IGNORED, decode failed (Exception): " . $e->getMessage());
      }
    }
  }

  private static function getCmsUserId($subClaim) {
    $userId = NULL;
    $rejectionMsg = NULL;
    try {
      $auth0User = new Auth0User($subClaim);
      $userId = $auth0User->getCmsUserId();
    }
    catch (Exception\SubClaimParseException $e) {
      Logger::debug("REJECTED, unable to parse sub claim " . $e->getMessage());
      $rejectionMsg = "CiviAuth0Jwt. Rejected because sub claim couldn't be parsed: " . $e->getMessage();
    }
    catch (Exception\UserMatchNotFoundException $e) {
      Logger::debug("REJECTED, user match not found: " . $e->getMessage());
      $rejectionMsg = 'CiviAuth0Jwt. Unable to match to valid user';
    }

    return [$userId, $rejectionMsg];
  }

}
