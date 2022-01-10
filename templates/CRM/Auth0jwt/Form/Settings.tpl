{* HEADER *}

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
</div>

<p>
  <em>
    When the auth0 domain has been saved, the key id and key will be updated
    using data from <code>https://&lt;domain&gt;/.well-known/jwks.json</code>.
    Saving without changing will force an update in case there has been a key
    rotation.
  </em>
</p>

<div class="crm-section">
  <div class="label">{$form.auth0jwt_auth0_domain.label}</div>
  <div class="content">{$form.auth0jwt_auth0_domain.html}</div>
  <div class="clear"></div>
</div>


<div class="crm-section">
  <div class="label">Current key id</div>
  <div class="content">
    {if empty($current_auth0jwt_public_signing_key_id)}
    <pre class="auth0jwt-static">Not available yet</pre>
    {else}
    <pre class="auth0jwt-static">{$current_auth0jwt_public_signing_key_id}</pre>
    {/if}
  </div>
  <div class="clear"></div>
</div>

<div class="crm-section">
  <div class="label">Current pem</div>
  <div class="content">
    {if empty($current_auth0jwt_public_signing_key_pem)}
    <pre class="auth0jwt-static">Not available yet</pre>
    {else}
    <pre class="auth0jwt-static">{$current_auth0jwt_public_signing_key_pem}</pre>
    {/if}
  </div>
  <div class="clear"></div>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
