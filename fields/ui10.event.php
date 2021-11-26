<?php
/**
 * Adding a UIType10 reference field under Event module. Change 'Events' to 'Calendar' to add reference field to 'Tasks'. 
 * Refer https://github.com/radus28/Vtiger-DevOps/tree/master/set-related-lists for how to related dependant list by reference field
 * Run this from 2 level sub folder or change include path of config.inc.php
 * @author Sutharsan Jeganathan
 */
//die('remove die');
$Vtiger_Utils_Log = true;
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', '1');
include_once('../../config.inc.php');
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');

//Module Nmae
$moduleInstance = Vtiger_Module::getInstance('Events');
//Block Name
$blockInstance = Vtiger_Block::getInstance ('LBL_EVENT_INFORMATION', $moduleInstance);


$fieldInstance = Vtiger_Field::getInstance("servicecontract_no", $moduleInstance);
if ($fieldInstance === false) {
    $fieldInstance = new Vtiger_Field();
    $fieldInstance->name = 'servicecontract_no';
    $fieldInstance->label = 'Service Contract';
    $fieldInstance->table = 'vtiger_activity';
    $fieldInstance->column = 'servicecontract_no';
    $fieldInstance->columntype = 'int(11)';
    $fieldInstance->uitype = 10;
    $fieldInstance->typeofdata = 'V~O';
    $blockInstance->addField($fieldInstance);
    $fieldInstance->setRelatedModules(array('ServiceContracts'));
}


echo 'fields done';
