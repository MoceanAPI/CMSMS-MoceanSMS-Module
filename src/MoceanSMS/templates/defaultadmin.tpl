<div class="pageoptions">
   <ul>
       <li><a href="{cms_action_url action=credential}">{admin_icon icon='newobject.gif'} {$mod->Lang('credential')}</a></li>
    
    {if ($credential_added === true) }
        <li><a href="{cms_action_url action=sms}">{admin_icon icon='newobject.gif'} {$mod->Lang('sms')}</a></li>
        <li><a href="{cms_action_url action=history}">{admin_icon icon='newobject.gif'} {$mod->Lang('history')}</a></li>
    {/if}
   <ul>
</div>