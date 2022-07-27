<?php

use Civi\CiviAuth0Jwt\Auth0Tenant;

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
    Civi::resources()->addStyle('.civiauth0jwt-align-hack { vertical-align: middle }');

    // public_signing_key_id and auth0jwt_public_signing_key_pem are settings,
    // but we don't let the user edit them directly, instead the current values
    // are displayed before saving.
    $this->assign('current_civiauth0jwt_public_signing_key_id', Civi::settings()->get('civiauth0jwt_public_signing_key_id'));
    $this->assign('current_civiauth0jwt_public_signing_key_pem', Civi::settings()->get('civiauth0jwt_public_signing_key_pem'));

    parent::buildQuickForm();
  }

  public function postProcess() {
    // This is similar to the parent postProcess except we modify params, and
    // depending on __all_civi_domains save the settings across all domains
    $params = $this->controller->exportValues($this->_name);

    $domain = $params['civiauth0jwt_auth0_domain'];

    // TODO: Should we catch exception, or just let everything die so we know?
    $auth0Tenant = new Auth0Tenant($domain);
    list($kid, $pem) = $auth0Tenant->fetchNewSigningKey();

    // Now continue with the newly fetched values
    $params['civiauth0jwt_public_signing_key_id'] = $kid;
    $params['civiauth0jwt_public_signing_key_pem'] = $pem;

    // The special __all_civi_domains form element does not correspond to a
    // setting, so won't be in $params
    $allCiviDomains = \CRM_Utils_Request::retrieve('__all_civi_domains', 'Integer');
    // Will be 1 if box was checked, otherwise null

    if ($allCiviDomains) {
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_auth0_domain');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_public_signing_key_id');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_public_signing_key_pem');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_force_user_id');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_user_lookup_table_name');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_user_lookup_table_auth0_col');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_user_lookup_table_auth0_col_contains_prefix');
      self::saveSettingOnAllDomains($params, 'civiauth0jwt_user_lookup_table_cms_col');

      Civi::log()->info("Fetched new civiauth0jwt_public_signing_key_id setting (\"$kid\") and pem from $domain\n: Saved on all domains");
    }
    else {
      Civi::log()->info("Fetched new civiauth0jwt_public_signing_key_id setting (\"$kid\") and pem from $domain\n: Saved on current domain");
    }

    // TODO: This will mean the settings get saved twice in current domain, but doesn't seem like a big problem
    parent::commonProcess($params);
  }

  private static function saveSettingOnAllDomains($params, $name) {
    if ($params[$name]) {
      civicrm_api3('Setting', 'create', ['domain_id' => 'all', $name => $params[$name]]);
    }
  }

}
