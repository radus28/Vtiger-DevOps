<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

/**
 * Sample code to add a block and a field inside that block
 */
$Vtiger_Utils_Log = true;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
include_once('../../../config.inc.php');
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');

function addFields() {

    /** Invoice */
    //Module Nmae
    $moduleInstance = Vtiger_Module::getInstance('Invoice');
    //Block Name
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'Xero Information';
    $blockInstance->sequence = 10;
    $moduleInstance->addBlock($blockInstance);
    $blockId = $blockInstance->getInstance("Xero Information", $moduleInstance)->id;
    $blockInstance = Vtiger_Block::getInstance($blockId);

    $fieldInstance = Vtiger_Field::getInstance("xero_id", $moduleInstance);
    if ($fieldInstance === false) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'xero_id';
        $fieldInstance->label = 'Xero ID';
        $fieldInstance->table = 'vtiger_invoice';
        $fieldInstance->column = 'xero_id';
        $fieldInstance->columntype = 'varchar(32)';
        $fieldInstance->uitype = 1;
        $fieldInstance->displaytype = 2;// Hides from edit view.  Remove this line if you want to it in edit view
        $fieldInstance->typeofdata = 'V~O';
        $blockInstance->addField($fieldInstance);
    }


    echo 'fields done';
}

addFields();
