{form_start}
<div class="pageoverflow">
    <div class="pageoverflow">
        <p class="pageinput">
            <input type="submit" name="{$actionid}submit" value="{$mod->Lang('send')}"/>
            <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('back')}"/>
        </p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('sender')}:</p>
        <p class="pageinput">
            <input type="text" name="{$actionid}sender" value="" />
        </p>
    </div>

    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('receiver')}:</p>
        <p class="pageinput">
            <input type="text" name="{$actionid}receiver" value="" />
        </p>
    </div>

    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('message')}:</p>
        <p class="pageinput">
            <textarea name="{$actionid}message" rows="10" cols="5" ></textarea>
        </p>
    </div>
</div>
{form_end}