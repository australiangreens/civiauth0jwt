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

      // Pick randomly between one which has an associated user and one which does not
      if (rand(0, 1) == 0) {
        // TODO!
        $contactId = null; // has an uid
      } else {
        $contactId = null; // no matching uid
      }
      $e->rejectSub("Not implemented");


      if ($contactId) {
        \Civi::log()->debug("jwtClaimsCheck() called. Parsed auth0id = $auth0Id. Mapped to contactId = $contactId");
        $e->acceptSub($contactId);
      } else {
        $e->rejectSub("Parsed auth0id = $auth0Id, but unable to map to a contactId");
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
