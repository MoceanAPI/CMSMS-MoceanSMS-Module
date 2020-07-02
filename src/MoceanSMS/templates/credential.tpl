<h3>MoceanAPI Credential</h3>

{form_start}

<div class="pageoverflow">
    <p class="pageinput">
        <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
        <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('apikey')}:</p>
    <p class="pageinput">
        <input type="text" name="{$actionid}key" value="{$credential->key}" />
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('apisecret')}:</p>
    <p class="pageinput">
        <input type="text" name="{$actionid}secret" value="{$credential->secret}"/>
    </p>
</div>

{form_end}