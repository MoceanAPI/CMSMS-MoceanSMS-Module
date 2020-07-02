<?php
/** @var $this \CMSModule */
/** @var $db \CMSMS\Database\Connection  */
$db = cmsms()->GetDb();
$pref = cms_db_prefix();

$dict = $db->NewDataDictionary();

$dict->ExecuteSQLArray($dict->DropTableSQL($pref."mod_moceansms_history"));
$this->RemovePermission(MoceanSMS::MANAGE_PERM);