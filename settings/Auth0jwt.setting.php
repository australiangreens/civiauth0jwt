<?php

use CRM_Auth0jwt_ExtensionUtil as E;
/*
 * Settings metadata file
 */

// Note: we can't use au.org.greens.auth0jwt:signing_key, since settings can
// have neither ':' not '.' characters
return [
  'auth0jwt_auth0_domain' => [
    'name' => 'auth0jwt_auth0_domain',
    'filter' => 'auth0jwt',
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
    'settings_pages' => ['auth0jwt' => ['weight' => 10]],
    // This won't work as is, because after we fetch new values for id and pem,
    // will be overritten. We can't use a CRM_Admin_Form_Generic
    // 'on_change' => ['CRM_Auth0jwt_Utils::settingsOnChangeAuth0Domain'],

  ],

  // auth0jwt_public_signing_key_id and auth0jwt_public_signing_key_pem
  // are set automatically, fetched from the auth0jwt_auth0_domain

  'auth0jwt_public_signing_key_id' => [
    'name' => 'auth0jwt_public_signing_key_id',
    'filter' => 'auth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('The id of the signing key from auth0 tenant. (keys[0].kid from <tenantdomain>/.well-known/jwks.json)'),
    'title' => E::ts('Signing key id'),
    'default' => '',
    'html_type' => 'text',
    // 'html_attributes' => [
    //   'size' => 60,
    //   'spellcheck' => 'false', // It is enumerated, not boolean,
    //   'readonly' => true,
    //   // 'disabled' => true,
    // ],
    'settings_pages' => ['auth0jwt' => ['weight' => 10]],
  ],
  'auth0jwt_public_signing_key_pem' => [
    'name' => 'auth0jwt_public_signing_key_pem',
    'filter' => 'auth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Signing key certificate from Auth0 tenant in PEM format. (contents of <tenantdomain>/pem or keys[0].x5c from jwks.json)'),
    'title' => E::ts('Signing key pem'),
    'default' => '',
    'html_type' => 'textarea',
    'html_attributes' => [
      // 'cols' => 80,
      // 'rows' => 20,
      // 'spellcheck' => 'false', // It is enumerated, not boolean
      // 'readonly' => true,
      // 'disabled' => true,
    ],
    'settings_pages' => ['auth0jwt' => ['weight' => 10]],
  ],
];
