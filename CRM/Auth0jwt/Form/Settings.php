<?php

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Auth0jwt_Form_Settings extends CRM_Admin_Form_Setting {
  // protected $_settings = [
  //   'auth0jwt_auth0_domain' => CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME,
  //   'auth0jwt_public_signing_key_id' => CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME,
  //   'auth0jwt_public_signing_key_pem' => CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME,
  // ];

  public function buildQuickForm() {
    Civi::resources()->addStyle('pre.auth0jwt-static { background: #dfdfdf; padding: 10px; font-family: monospace; border: 1px solid silver;}');

    // public_signing_key_id and auth0jwt_public_signing_key_pem are settings,
    // but we don't let the user edit them directly, instead the current values
    // are displayed before saving.
    $this->assign('current_auth0jwt_public_signing_key_id', Civi::settings()->get('auth0jwt_public_signing_key_id'));
    $this->assign('current_auth0jwt_public_signing_key_pem', Civi::settings()->get('auth0jwt_public_signing_key_pem'));

    parent::buildQuickForm();
  }

  public function postProcess() {
    // This is the same as the parent postProcess except we modify params
    $params = $this->controller->exportValues($this->_name); // Submitted values

    $domain = $params['auth0jwt_auth0_domain'];

    // TODO: Should we catch exception, or just let everything die so we know?
    list($kid, $pem) = CRM_Auth0jwt_Utils::fetchNewSigningKey($domain);

    $msg = "setting auth0jwt_auth0_domain to $domain and updating updated id and pem using $domain\n";
    $msg .= '  auth0jwt_public_signing_key_id = ' . $kid . "\n";
    $msg .= '  auth0jwt_public_signing_key_pem = ' . $pem . "\n";
    Civi::log()->info($msg);

    // Now continue with the newly fetched values
    $params['auth0jwt_public_signing_key_id'] = $kid;
    $params['auth0jwt_public_signing_key_pem'] = $pem;
    parent::commonProcess($params);
  }
}
