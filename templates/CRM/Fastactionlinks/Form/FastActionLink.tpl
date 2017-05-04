{* HEADER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>
{if $action eq 8}
  <div class="messages status no-popup">
    <div class="icon inform-icon"></div>
    {ts}Do you want to delete this fast action link?{/ts}
  </div>
{else}
  {* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}
  {* debug *}
  {foreach from=$elementNames item=elementName}
    <div class="crm-section">
      <div class="label">{$form.$elementName.label} {if $elementName|array_key_exists:$help}{help id=$help.$elementName.id file=$help.$elementName.hlpFile}{/if}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
    </div>
  {/foreach}
{/if}
{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>