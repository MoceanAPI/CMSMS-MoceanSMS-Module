<?php
/** @var $this \CMSModule */
if (!defined('CMS_VERSION')) exit;
if (!$this->CheckPermission(Holidays::MANAGE_PERM)) return;

if (isset($params["cancel"])) $this->RedirectToAdminTab();

$page = 1;
if (isset($params["page"])) $page = $params["page"];

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('history.tpl'), null, null, $smarty);
$History = History::loadBypPage($page);

$pathname = $_SERVER["REQUEST_URI"];
$pathname_split = explode("?",$pathname);
if(isset($pathname_split[1])) {
    $params = array();
    foreach (explode("&",$pathname_split[1]) as $row) {
        $split = explode("=",$row);
        if($split[0] === "page") continue;

        $params[] = $split[0]."=".$split[1];
    }
    $pathname = $pathname_split[0]."?".implode("&",$params);
}

$tpl->assign("histories",$History["data"]);
$tpl->assign("paging",$History["paging_info"]);
$tpl->assign("pathname",$pathname);
$tpl->display();
?>