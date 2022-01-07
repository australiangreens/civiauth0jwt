<?php

use CRM_Auth0jwt_ExtensionUtil as E;
/*
 * Settings metadata file
 */

// Note: we can't use au.org.greens.auth0jwt:signing_key, since settings can
// have neither ':' not '.' characters
return [
  'auth0jwt_signing_key' => [
    'name' => 'auth0jwt_signing_key',
    'filter' => 'auth0jwt',
    'type' => 'String',
    'add' => '5.31',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Signing key from Auth0 tenant (PEM format)'),
    'title' => E::ts('Auth0 signing key'),
    'default' => '',
    'html_type' => 'textarea',
    'html_attributes' => [
      'cols' => 80,
      'rows' => 20,
    ],
    'settings_pages' => ['auth0jwt' => ['weight' => 10]],
  ],
];
