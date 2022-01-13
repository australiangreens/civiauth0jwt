<?php

/**
 * Listen - class with listener definitions
 *
 */
class CRM_Auth0jwt_Listen {

  public static function decodedJwtClaimsCheck(\Civi\Authx\DecodedJwtClaimsCheckEvent $e) {
    $claims = $e->claims;
    \Civi::log()->debug('decodedJwtClaimsCheck() called');
    \Civi::log()->debug(json_encode($claims));

    // For now, we just accept the scope, whether or not it contains 'authx'.
    $e->acceptScope();

    // Parse auth0's
    if (!empty($claims['sub']) && substr($claims['sub'], 0, 6) === 'auth0|') {
      $auth0Id = substr($claims['sub'], 6);
      \Civi::log()->debug("auth0id = $auth0Id");

      // This is where we'd do a lookup
      // For now just pretend.
      $e->acceptSub(202);
    } else {
      // Lets say we instead didn't find it. We have the choice over either
      // calling rejectSub, or do nothing, which will allow authx to process as
      // normal
      $e->rejectSub('Sub claim is missing auth0 id');
    }
  }
}
