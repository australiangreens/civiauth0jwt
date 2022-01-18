<?php

use CRM_CiviAuth0Jwt_ExtensionUtil as E;
/*
 * Settings metadata file
 */

return [
  'civiauth0jwt_auth0_domain' => [
    'name' => 'civiauth0jwt_auth0_domain',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Your auth0 domain. E.g. "somedevtenant.auth0.com", "auth.yoursite.com" etc. (Do not include https://)'),
    'title' => E::ts('Auth0 domain'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false', // It is enumerated, not boolean
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  // civiauth0jwt_public_signing_key_id and civiauth0jwt_public_signing_key_pem
  // are set automatically, fetched from the civiauth0jwt_auth0_domain
  'civiauth0jwt_public_signing_key_id' => [
    'name' => 'civiauth0jwt_public_signing_key_id',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('The id of the signing key from auth0 tenant. (keys[0].kid from <tenantdomain>/.well-known/jwks.json)'),
    'title' => E::ts('Signing key id'),
    'default' => '',
    'html_type' => 'text',
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],
  'civiauth0jwt_public_signing_key_pem' => [
    'name' => 'civiauth0jwt_public_signing_key_pem',
    'filter' => 'civiauth0jwt',
    'type' => 'Integer',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Signing key certificate from Auth0 tenant in PEM format. (contents of <tenantdomain>/pem or keys[0].x5c from jwks.json)'),
    'title' => E::ts('Signing key pem'),
    'default' => '',
    'html_type' => 'text',
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  'civiauth0jwt_force_cid' => [
    'name' => 'civiauth0jwt_force_cid',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('(FOR DEBUGGING) If set, this will be used as the resolved contactId of every request, regardless of the auth0 id'),
    'title' => E::ts('Force contact id'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false', // It is enumerated, not boolean
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],
];
