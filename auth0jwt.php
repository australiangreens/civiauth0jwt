<?php

require_once 'auth0jwt.civix.php';
// phpcs:disable
use CRM_Auth0jwt_ExtensionUtil as E;
// phpcs:enable


/**
 * Implements hook_civicrm_crypto().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_crypto/
 */
function auth0jwt_civicrm_crypto($registry) {
  if (
    !empty($auth0SigningKeyId = \Civi::settings()->get('auth0jwt_public_signing_key_id'))
    && !empty($auth0SigningKeyCert = \Civi::settings()->get('auth0jwt_public_signing_key_cert'))
  ) {
    // Despite the name, this works just fine with public keys
    $registry->addSymmetricKey([
      'id' => $auth0SigningKeyId,
      'key' => $auth0SigningKeyCert,
      'suite' => 'jwt-rs256',
      'tags' => ['SIGN'],
      // TODO: Is using -1 this still the best approach?
      'weight' => -1,
    ]);
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function auth0jwt_civicrm_config(&$config) {
  _auth0jwt_civix_civicrm_config($config);
  // This is where we'll add symfony listeners if we need to
  // E.g. Civi::service('dispatcher')->addListener('hook_civicrm_post', 'auth0jwt_symfony_civicrm_post', -99);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function auth0jwt_civicrm_xmlMenu(&$files) {
  _auth0jwt_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function auth0jwt_civicrm_install() {
  _auth0jwt_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function auth0jwt_civicrm_postInstall() {
  _auth0jwt_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function auth0jwt_civicrm_uninstall() {
  _auth0jwt_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function auth0jwt_civicrm_enable() {
  _auth0jwt_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function auth0jwt_civicrm_disable() {
  _auth0jwt_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function auth0jwt_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _auth0jwt_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function auth0jwt_civicrm_managed(&$entities) {
  _auth0jwt_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function auth0jwt_civicrm_caseTypes(&$caseTypes) {
  _auth0jwt_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function auth0jwt_civicrm_angularModules(&$angularModules) {
  _auth0jwt_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function auth0jwt_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _auth0jwt_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function auth0jwt_civicrm_entityTypes(&$entityTypes) {
  _auth0jwt_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function auth0jwt_civicrm_themes(&$themes) {
  _auth0jwt_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function auth0jwt_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function auth0jwt_civicrm_navigationMenu(&$menu) {
  _auth0jwt_civix_insert_navigation_menu($menu, 'Administer', array(
    'label' => E::ts('Auth0jwt'),
    'name' => 'auth0jwt_settings',
    'url' => 'civicrm/admin/setting/auth0jwt',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _auth0jwt_civix_navigationMenu($menu);
}
