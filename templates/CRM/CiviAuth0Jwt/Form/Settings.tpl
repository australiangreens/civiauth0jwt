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

<div class="crm-section">
  <div class="label">{$form.civiauth0jwt_auth0_domain.label}</div>
  <div class="content">
    {$form.civiauth0jwt_auth0_domain.html}
    {* TODO: Retrieve description from metadata instead of hardcoding it here *}
    <div class="description">Your auth0 domain. E.g. "somedevtenant.auth0.com", "auth.yoursite.com" etc.<br/>(Do not include https://)</div>
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
  <div class="label">{$form.civiauth0jwt_force_cid.label}</div>
  <div class="content">
    {$form.civiauth0jwt_force_cid.html}
    <div class="description">(For debugging) If set, will be used instead of looking up the auth0 id.</div>
  </div>
  <div class="clear"></div>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
