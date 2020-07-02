<?php
/** @var $this \CMSModule */
if (!defined('CMS_VERSION')) exit;
if (!$this->CheckPermission(Holidays::MANAGE_PERM)) return;

if (isset($params["cancel"])) $this->RedirectToAdminTab();
else if (isset($params["submit"])){

    if (strlen(trim($params["receiver"])) == 0 || preg_match("/[^0-9,]/",$params["receiver"])) {
        $this->SetError($this->Lang("msg_invalid_receiver"));
    } else if (strlen(trim($params["sender"])) === 0) {
        $this->SetError($this->Lang("msg_invalid_sender"));
    } else if (strlen(trim($params["message"])) === 0) {
        $this->SetError($this->Lang("msg_invalid_message"));
    }

    try {
        SMS::newSMS()->addRecipient($params["receiver"])
            ->from($params["sender"])
            ->sendMessage($params["message"]);
        $this->SetMessage($this->Lang("msg_success_send_sms"));
    } catch (AuthenticationError $e) {
        $this->SetError($this->Lang("msg_authentication_fail"));
    } catch (InsufficientCreditError $e) {
        $this->SetError($this->Lang("msg_insufficient_credit"));
    } catch (Exception $e) {
        $this->SetError($this->Lang("msg_unknown_error"));
    }
    $this->RedirectToAdminTab();
}

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('sms.tpl'), null, null, $smarty);

$tpl->display();
?>