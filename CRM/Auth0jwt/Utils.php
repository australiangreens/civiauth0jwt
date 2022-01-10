<?php

/**
 * Utils - class with generic functions
 *
 */
class CRM_Auth0jwt_Utils {

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

    $client = new GuzzleHttp\Client();

    $res = $client->get($jwksUri);

    if ($res->getStatusCode() == 200) {
      $jwks = json_decode($res->getBody(), true);

      // The current key will be the first in the array
      $key = $jwks['keys'][0];

      // Key id (kid) is simple
      $kid = $key['kid'];

      // The contents of the pem will be in x5c, we just need to add the first
      // and last line to each certificate in the chain, as well as make each
      // line 64 characters long. (This last bit isn't strictly needed for AuthX
      // to work, but it makes it match rfc7468 as expect.
      // TODO: If there are multiple should we actually only be using the first?
      $certs = array_map(function ($x) {
        return "-----BEGIN CERTIFICATE-----\n" . wordwrap($x, 64, "\n", true) . "\n-----END CERTIFICATE-----";
      }, $key['x5c']);

      $pem = implode("\n", $certs);

      return [$kid, $pem];
    }

    throw new \Exception("Unable to retrieve data from $jwksUri");
  }
}
