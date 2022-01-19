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
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Your auth0 domain. E.g. "somedevtenant.auth0.com", "auth.yoursite.com" etc. (Do not include https://)'),
    'title' => E::ts('Auth0 domain'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false', // This must be the string literal 'false', not a boolean
      'required' => 'true',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  'civiauth0jwt_user_lookup_table_name' => [
    'name' => 'civiauth0jwt_user_lookup_table',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Database table to use to match auth0 ids to CMS user ids'),
    'title' => E::ts('User lookup table name'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  'civiauth0jwt_user_lookup_table_auth0_col' => [
    'name' => 'civiauth0jwt_user_lookup_table_auth0_col',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Name column in the table containing the auth0 id'),
    'title' => E::ts('User lookup table auth0 id column'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  'civiauth0jwt_user_lookup_table_cms_col' => [
    'name' => 'civiauth0jwt_user_lookup_table_cms_col',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Name of column in the table containing the CMS id'),
    'title' => E::ts('User lookup table CMS id column'),
    'default' => '',
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  'civiauth0jwt_user_lookup_table_auth0_col_contains_prefix' => [
    'name' => 'civiauth0jwt_user_lookup_table_auth0_col_contains_prefix',
    'filter' => 'civiauth0jwt',
    'type' => 'Boolean',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Should be checked if the auth0 id column contains values like "auth0|1234". Uncheck if already stripped out to be "1234".'),
    'title' => E::ts('Auth0 column contains "Auth0|" prefix'),
    'default' => true,
    'html_type' => 'checkbox',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],

  // civiauth0jwt_public_signing_key_id and civiauth0jwt_public_signing_key_pem
  // are set automatically, fetched from the civiauth0jwt_auth0_domain
  'civiauth0jwt_public_signing_key_id' => [
    'name' => 'civiauth0jwt_public_signing_key_id',
    'filter' => 'civiauth0jwt',
    'type' => 'String',
    'add' => '5.43.2',
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
    'type' => 'String',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Signing key certificate from Auth0 tenant in PEM format. (contents of <tenantdomain>/pem or keys[0].x5c from jwks.json)'),
    'title' => E::ts('Signing key pem'),
    'default' => '',
    'html_type' => 'text',
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],


  'civiauth0jwt_force_user_id' => [
    'name' => 'civiauth0jwt_force_user_id',
    'filter' => 'civiauth0jwt',
    'type' => 'Integer',
    'add' => '5.43.2',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('(For debugging) If set, will be used instead of searching the table for a matching auth0 id.'),
    'title' => E::ts('Force user id'),
    'default' => null,
    'html_type' => 'text',
    'html_attributes' => [
      'size' => 60,
      'spellcheck' => 'false',
    ],
    'settings_pages' => ['civiauth0jwt' => ['weight' => 10]],
  ],
];
