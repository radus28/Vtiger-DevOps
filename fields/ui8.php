<?php
$Vtiger_Utils_Log = true;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
include_once('../../config.inc.php');
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');

//Module Nmae
$moduleInstance = Vtiger_Module::getInstance('Contacts');
//Block Name
$blockInstance = Vtiger_Block::getInstance('LBL_CONTACT_INFORMATION',$moduleInstance);
$fieldInstance = Vtiger_Field::getInstance("ccemail", $moduleInstance);
        if ($fieldInstance === false) {
$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'ccemail';
$fieldInstance->label = 'LBL_CCEMAIL';
$fieldInstance->table = 'vtiger_contactdetails';
$fieldInstance->column = 'ccemail';
$fieldInstance->columntype = 'text';
$fieldInstance->uitype = 8;
$fieldInstance->typeofdata = 'V~O';
$blockInstance->addField($fieldInstance);
}


echo 'fields done';
