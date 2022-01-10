<?php

/**
 * Utils - class with generic functions
 *
 */
class CRM_Auth0jwt_Utils {


  /**
   * Function used to monitor changes to auth0jwt_auth0_domain setting.
   *
   * Attempts to look up the web key set and update the values of the
   * auth0jwt_public_signing_key_id and auth0jwt_public_signing_key_cert
   * settings.
   *
   * ! Using this won't work with CRM_Admin_Form_Generic since those values will
   * ! be immediately overritten
   *
   * @link
   * https://auth0.com/docs/security/tokens/json-web-tokens/json-web-key-sets
   *
   * @param string $oldValue, string $newValue, array $metadata
   * @return null
   * @access public
   * @static
   */
  // public static function settingsOnChangeAuth0Domain($oldValue, $newValue, $metadata) {
  //   // TODO: Should we catch exception, or just let everything die so we know?
  //   list($kid, $pem) = self::fetchNewSigningKey($newValue);

  //   // Update the settings
  //   \Civi::settings()->set('auth0jwt_public_signing_key_id', $pem);
  //   \Civi::settings()->set('auth0jwt_public_signing_key_pem', $kid);

  //   $msg = "auth0jwt_auth0_domain setting set to $newValue => updated id and pem using $newValue\n";
  //   $msg .= '  auth0jwt_public_signing_key_id = ' . \Civi::settings()->get('auth0jwt_public_signing_key_id') . "\n";
  //   $msg .= '  auth0jwt_public_signing_key_pem = ' . \Civi::settings()->get('auth0jwt_public_signing_key_pem' . "\n");
  //   \Civi::log()->info($msg);
  // }


  /**
   * Try to fetch (and format as appropriate) the latest key id and cert from
   * provided auth0 domain.
   *
   * @param   string  $domain  Auth0 domain
   *
   * @return  boolean          [kid, pem]
   *
   */
  public static function fetchNewSigningKey($domain) {
    $jwksUri = "https://$domain/.well-known/jwks.json";

    // TODO: This is where we'd make a call
    // Can either hit the https://$newValue/.well-known/jwks.json and retrieve key[0].kid and
    // key[0].x5c (adding begin certificate etc to x5c to match requiresment)
    $x5c = 'fakeretrieved x5c';
    $pem = "-----BEGIN CERTIFICATE-----\n" . $x5c . "\n-----END CERTIFICATE-----";
    $kid = 'fakeid';
    // Or we can can the pem from https://$newValue/pem (or /rawpem if that
    // causes some encoding issues)
    //
    // ...The jwks approach is cleaner since it only requires a single request

    return [$kid, $pem];
  }
}
