<?php

$Vtiger_Utils_Log = true;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
include_once('../../config.inc.php');
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');

$moduleInstance = Vtiger_Module::getInstance('OccupantCertificate');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION',$moduleInstance);

$fieldInstance = Vtiger_Field::getInstance("application_status", $moduleInstance);
        if ($fieldInstance === false) {
$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'application_status';
$fieldInstance->label = 'LBL_APPLICATION_STATUS';
$fieldInstance->table = 'vtiger_occupantcertificate';
$fieldInstance->column = 'application_status';
$fieldInstance->columntype = 'varchar(100)';
$fieldInstance->uitype = 15;
$fieldInstance->setPicklistValues(array('Inspection','Proceedings – VI','Proceedings – Chief VI','Proceddings – Accountant', 'Proceedings – Commissioner','Approval – VI','Approval – Chief VI','Approval – Accountant',
                                        'Approval - Commissioner','Rejected – VI','Rejected – Chief VI','Rejected – Accountant','Rejected – Commissioner'));
$fieldInstance->typeofdata = 'V~O';
$blockInstance->addField($fieldInstance);
}



// LOCATION INFORMATION



echo 'fields done';
