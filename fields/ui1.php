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

$fieldInstance = Vtiger_Field::getInstance("street_test", $moduleInstance);
        if ($fieldInstance === false) {
$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'street_test';
$fieldInstance->label = 'LBL_STREET_TEST';
$fieldInstance->table = 'vtiger_contactdetails';
$fieldInstance->column = 'street_test';
$fieldInstance->columntype = 'varchar(100)';
//text uitype = 1
$fieldInstance->uitype = 1; // or uitype = 19 (For Description or Comments)
// Use 2 to hide from edit view
$fieldInstance->displaytype = 1;
$fieldInstance->typeofdata = 'V~O';
$blockInstance->addField($fieldInstance);
}



echo 'fields done';
