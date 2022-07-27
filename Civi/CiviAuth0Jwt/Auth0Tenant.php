<?php

namespace Civi\CiviAuth0Jwt;

use GuzzleHttp\Client;

/**
 * Auth0Tenant
 *
 */
class Auth0Tenant {

  /**
   * @var string
   * The domain (not including https:// E.g. "sometenant.auth0.com")
   */
  protected $domain;

  /**
   * Auth0Tenant constructor.
   */
  public function __construct(string $domain) {
    $this->domain = $domain;
  }

  /**
   * Try to fetch (and format as appropriate) the latest key id and cert from
   * the domain provided at contruction time.
   *
   * @return array [kid, pem]
   */
  public function fetchNewSigningKey(): array {
    $jwksUri = "https://" . $this->domain . "/.well-known/jwks.json";

    $client = new Client();

    $res = $client->get($jwksUri);

    if ($res->getStatusCode() == 200) {
      $jwks = json_decode($res->getBody(), TRUE);

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
        return "-----BEGIN CERTIFICATE-----\n" . wordwrap($x, 64, "\n", TRUE) . "\n-----END CERTIFICATE-----";
      }, $key['x5c']);

      $pem = implode("\n", $certs);

      return [$kid, $pem];
    }

    throw new \Exception("Unable to retrieve data from $jwksUri");
  }

}
