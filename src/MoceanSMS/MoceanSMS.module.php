<?php

class MoceanSMS extends CMSModule
{
    const MANAGE_PERM = 'MoceanSMS-ADMIN';


    public function GetVersion()
    {
        return '1.0';
    }

    public function GetFriendlyName()
    {
        return $this->Lang('friendlyname');
    }

    public function GetAdminDescription()
    {
        return $this->Lang('admindescription');
    }

    public function IsPluginModule()
    {
        return TRUE;
    }

    public function HasAdmin()
    {
        return TRUE;
    }

    public function GetAuthor()
    {
        return 'MoceanAPI';
    }

    public function GetAuthorEmail()
    {
        return 'support@moceanapi.com';
    }

    public function VisibleToAdminUser()
    {
        return $this->CheckPermission(self::MANAGE_PERM);
    }

    public function UninstallPreMessage()
    {
        return $this->Lang('ask_uninstall');
    }



}

?>
