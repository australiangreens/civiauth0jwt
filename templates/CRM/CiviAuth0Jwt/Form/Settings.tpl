{* HEADER *}

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
</div>

<p>
  <em>
    When the auth0 domain has been saved, the key id and key will be retrieved from the auth0 tenant
    defined by the domain. Saving without changing will force an update (to handle key rotation).
  </em>
</p>

<p>
  <em>
    Only the Auth0 domain is strictly required. If the lookup table details are
    not set then you can still use the force user id setting for debugging purposes.
  </em>
</p>

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_auth0_domain.label}*</div>
  <div class="content">
    {$form.civiauth0jwt_auth0_domain.html}
    {* TODO: Retrieve description from metadata instead of hardcoding it here *}
    <div class="description">Your auth0 domain. E.g. "somedevtenant.auth0.com", "auth.yoursite.com" etc.<br/>(Do not include https://)</div>
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_user_lookup_table_name.label}</div>
  <div class="content">
    {$form.civiauth0jwt_user_lookup_table_name.html}
    <div class="description">Database table to use to match auth0 ids to CMS user ids</div>
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_user_lookup_table_auth0_col.label}</div>
  <div class="content">
    {$form.civiauth0jwt_user_lookup_table_auth0_col.html}
    <div class="description">Name column in the table containing the auth0 id</div>
  </div>
  <div class="clear"></div>

  <div class="content">
    {$form.civiauth0jwt_user_lookup_table_auth0_col_contains_prefix.html}
    <div class="description">Check if the auth0 ids in table contain the prefix, E.g. "auth0|1234".<br/>Uncheck if already stripped out, E.g. "1234".</div>
  </div>
  <div class="clear">
</div>

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_user_lookup_table_cms_col.label}</div>
  <div class="content">
    {$form.civiauth0jwt_user_lookup_table_cms_col.html}
    <div class="description">Name of column in the table containing the CMS id</div>
  </div>
  <div class="clear"></div>
</div>



<div class="crm-section">
  <div class="label">Current key id</div>
  <div class="content">
    {if empty($current_civiauth0jwt_public_signing_key_id)}
    <pre class="civiauth0jwt-static">Not available yet</pre>
    {else}
    <pre class="civiauth0jwt-static">{$current_civiauth0jwt_public_signing_key_id}</pre>
    {/if}
    <div class="description">{literal}The id of the signing key from auth0 tenant.<br/>(Copied from keys[0].kid at https://{Auth0 domain}/.well-known/jwks.json){/literal}</div>
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">Current pem</div>
  <div class="content">
    {if empty($current_civiauth0jwt_public_signing_key_pem)}
    <pre class="civiauth0jwt-static">Not available yet</pre>
    {else}
    <pre class="civiauth0jwt-static">{$current_civiauth0jwt_public_signing_key_pem}</pre>
    {/if}
    <div class="description">{literal}Signing key certificate from Auth0 tenant in PEM format.<br/>(Built from keys[0].x5c in https://{Auth0 domain}/.well-known/jwks.json){/literal}</div>
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_force_user_id.label}</div>
  <div class="content">
    {$form.civiauth0jwt_force_user_id.html}
    <div class="description">(For debugging) If set, will be used instead of searching the table for a matching auth0 id.</div>
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">Save for all domains</div>
    <div class="content">
      {* __all_civi_domains is a special input that does not correspond to a setting*}
      <input id="__all_civi_domains" name="__all_civi_domains" type="checkbox" value="1" class="crm-form-checkbox civiauth0jwt-align-hack" checked>
      <label class="description align-hack" for="__all_civi_domains">Check to update settings across all domains on a multi-site installation.</label>
    </div>
    <div class="clear"></div>
</div>


{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
