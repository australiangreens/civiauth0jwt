<?php

require_once 'civiauth0jwt.civix.php';
// phpcs:disable
use CRM_CiviAuth0Jwt_ExtensionUtil as E;
// phpcs:enable


/**
 * Implements hook_civicrm_crypto() to store the retrieved keys.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_crypto/
 */
function civiauth0jwt_civicrm_crypto($registry) {
  if (
    !empty($auth0SigningKeyId = \Civi::settings()->get('civiauth0jwt_public_signing_key_id'))
    && !empty($auth0SigningKeyPem = \Civi::settings()->get('civiauth0jwt_public_signing_key_pem'))
  ) {

    // Despite the name, this works just fine with public keys
    $registry->addSymmetricKey([
      'id' => $auth0SigningKeyId,
      'key' => $auth0SigningKeyPem,
      'suite' => 'jwt-rs256',
      'tags' => ['SIGN'],

      // By default during install CiviCRM will populate CIVICRM_SIGN_KEYS with
      // a new signing key with suite of jwt-hs256. That will be added to the
      // registry with a weight of 0, so we use a weight of -1 here to ensure
      // our signing key is used instead by the CryptoJwt class called by AuthX.
      // TODO: Is using -1 still the best approach?
      'weight' => -1,
    ]);
  }
}

/**
 * Implement hook_civicrm_container() to add our subscriber to listen for authx
 * credential events.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_container/
 */
function civiauth0jwt_civicrm_container(\Symfony\Component\DependencyInjection\ContainerBuilder $container) {
  $container->register('civiauth0jwt_credentials', '\Civi\CiviAuth0Jwt\CheckAuth0JwtCredential')
    ->addTag('kernel.event_subscriber')
    ->setPublic(TRUE);
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function civiauth0jwt_civicrm_config(&$config) {
  _civiauth0jwt_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function civiauth0jwt_civicrm_install() {
  _civiauth0jwt_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function civiauth0jwt_civicrm_postInstall() {
  _civiauth0jwt_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function civiauth0jwt_civicrm_uninstall() {
  _civiauth0jwt_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function civiauth0jwt_civicrm_enable() {
  _civiauth0jwt_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function civiauth0jwt_civicrm_disable() {
  _civiauth0jwt_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function civiauth0jwt_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civiauth0jwt_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function civiauth0jwt_civicrm_entityTypes(&$entityTypes) {
  _civiauth0jwt_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---
//     I.e. just for development purposes

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function civiauth0jwt_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function civiauth0jwt_civicrm_navigationMenu(&$menu) {
  _civiauth0jwt_civix_insert_navigation_menu($menu, 'Administer', array(
    'label' => E::ts('CiviAuth0Jwt'),
    'name' => 'civiauth0jwt_settings',
    'url' => 'civicrm/admin/setting/civiauth0jwt',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _civiauth0jwt_civix_navigationMenu($menu);
}
