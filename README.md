# CiviAuth0Jwt

![Screenshot](/images/screenshot.png)

This extension allows the use of JWT tokens signed by an Auth0 tenant for
authentication of requests by:

1. Retrieving and add the signing key of a specified Auth0 tenant to the
   registry used to validate JWTs in core AuthX extension.

2. Listens for the `civi.authx.jwtclaimscheck` symphony event, using it to
   override the processing of the `sub` claim in the JWT, replacing it with
   matching an auth0 id against CMS user ids linked to contact ids.

## Motivation

This gets around two limitations (currently) in the civicrm authentication process:

1. [CIVICRM_SIGN_KEYS](https://docs.civicrm.org/sysadmin/en/latest/setup/secret-keys/#civicrm_sign_keys)
   which only supports the `jwt-hs256` and `jwt-hs384` cipher suites, while Auth0
   (effectively) uses `jwt-hs256` suite.

2. The underlying Firebse JWT library uses `openssl_verify()` to verify keys
   using RS* algorithms, which expects it to be in PEM format in (at least)
   3 lines.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.2+

* CiviCRM (*FIXME: Version number*)

* [AuthX](https://docs.civicrm.org/dev/en/latest/framework/authx/) core
  extension enabled. [TODO: Refer to the version with the PR adding in the
  `civi.authx.jwtclaimscheck` event in]

* Drupal CMS with [Drupal Auth0](https://www.drupal.org/project/auth0) library
  (*This is temporary and will be replaced with use of the
  [openid connect library](https://www.drupal.org/project/openid_connect)*)
  [TODO: Maybe this would be better handled as some settings to specify which
  tables to look up]

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the
[CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

[TODO: Does this work]

```bash
cd <extension-dir>
cv dl civiauth0jwt@https://github.com/australiangreens/civiauth0jwt/archive/main.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git)
repo for this extension and install it with the command-line tool
[cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/australiangreens/civiauth0jwt.git
cv en civiauth0jwt
```

## Getting Started

1. Visit `<siteroot>/civicrm/admin/setting/civiauth0jwt`.
2. Put the auth0 domain of your tenant, without including the scheme. This could
   be an auth0 subdomain (yourtenant.auth0.com) or your own subdomain
   (auth.yourdomain.com). Note this will be the same as the `iss` claim in your
   JWTs tokens, minus the https.
3. Click save.
4. This should fetch the latest key sign key id and store the public key (in pem
   format) as a civicrm setting.
5. You can confirm it worked by revisting the setting page. It the "Current key
   id" and "Current pem" fields should now be populated.

[TODO: ]

## Refreshing/rotating keys

If your Auth0 signing key is rotated, simply visiting the settings page and
clicking save will fetch the latest one.

## Known Issues

Watch this space
