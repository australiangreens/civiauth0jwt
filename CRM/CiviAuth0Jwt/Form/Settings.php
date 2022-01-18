<?php

use Civi\CiviAuth0Jwt\Util;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_CiviAuth0Jwt_Form_Settings extends CRM_Admin_Form_Setting {

  public function buildQuickForm() {
    $styleStrs = [
      'background: #dfdfdf',
      'padding: 10px',
      'font-family: monospace',
      'border: 1px solid silver',
      'width: 64ch',
      'margin-bottom: 1px',
    ];

    Civi::resources()->addStyle('pre.civiauth0jwt-static {' . implode(';', $styleStrs) . '}');

    // public_signing_key_id and auth0jwt_public_signing_key_pem are settings,
    // but we don't let the user edit them directly, instead the current values
    // are displayed before saving.
    $this->assign('current_civiauth0jwt_public_signing_key_id', Civi::settings()->get('civiauth0jwt_public_signing_key_id'));
    $this->assign('current_civiauth0jwt_public_signing_key_pem', Civi::settings()->get('civiauth0jwt_public_signing_key_pem'));

    parent::buildQuickForm();
  }

  public function postProcess() {
    // This is the same as the parent postProcess except we modify params
    $params = $this->controller->exportValues($this->_name); // Submitted values

    $domain = $params['civiauth0jwt_auth0_domain'];

    // TODO: Should we catch exception, or just let everything die so we know?
    list($kid, $pem) = Util::fetchNewSigningKey($domain);

    Civi::log()->info("Fetched new civiauth0jwt_public_signing_key_id setting (\"$kid\") and pem from $domain\n");

    // Now continue with the newly fetched values
    $params['civiauth0jwt_public_signing_key_id'] = $kid;
    $params['civiauth0jwt_public_signing_key_pem'] = $pem;
    parent::commonProcess($params);
  }
}
