<?php
if( !defined('CMS_VERSION') ) exit;
/** @var $this \CMSModule */
/** @var $db \CMSMS\Database\Connection  */
$db = $this->GetDb();
$pref = cms_db_prefix();
$dict = $db->NewDataDictionary();
$taboptarray = array('mysql' => 'ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci',
                    'mysqli' => 'ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci');

//$phonebook_fields = "
//id	I AUTOINCREMENT KEY,
//name C(255) NOTNULL,
//number C(255) NOTNULL
//";
//$sqlarray = $dict->CreateTableSQL($pref."mod_moceansms_phonebook",$phonebook_fields,$taboptarray);
//$res = $dict->ExecuteSQLArray($sqlarray);

$history_fields = "
id I AUTOINCREMENT KEY,
text x NOTNULL,
ip c(100) NOTNULL,
receiver x NOTNULL,
datetime DT
";
$sqlarray = $dict->CreateTableSQL($pref."mod_moceansms_history",$history_fields,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);


$sqlarray = $dict->CreateTableSQL($pref."mod_moceansms_history",$history_fields,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);



$this->CreatePermission(MoceanSMS::MANAGE_PERM);