<?php
/** @var $this \CMSModule */
if (!defined('CMS_VERSION')) exit;
if (!$this->CheckPermission(Holidays::MANAGE_PERM)) return;
$Credential = new Credential();
if (isset($params['cancel'])) {
    $this->RedirectToAdminTab();
} else if (isset($params['submit'])) {

    if(!isset($params["key"]) || strlen(trim($params["key"])) === 0) {
        $this->SetError($this->Lang("msg_fail_save_credential"));
        $this->RedirectToAdminTab();
    } else if(!isset($params["secret"]) || strlen(trim($params["secret"])) === 0) {
        $this->SetError($this->Lang("msg_fail_save_credential"));
        $this->RedirectToAdminTab();
    }

    if (Credential::verifyCredential($params["key"],$params["secret"])) {
        $Credential->key = $params['key'];
        $Credential->secret = $params['secret'];
        $Credential->save();
        $this->SetMessage($this->Lang("msg_success_save_credential"));

    } else {
        $this->SetError($this->Lang("msg_fail_save_credential"));
    }
    $this->RedirectToAdminTab();
}

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('credential.tpl'), null, null, $smarty);
$tpl->assign('credential', Credential::load());
$tpl->display();
?>