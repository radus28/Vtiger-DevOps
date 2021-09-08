<?php
/**
 * @author Sutharsan J
 * @internal Place this file in CRM root , 
 * Modify below script to match your Requirments,  
 * Run from browser
 * CAUTION : Do not repeatly run, which may create duplicate links
**/
include_once('../../config.inc.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
//Example #1
$link_module = Vtiger_Module::getInstance('Invoice');
$link_module->addLink('HEADERSCRIPT', 'SPECIALFIELDSHEADERSCRIPT', 'modules/Invoice/views/resources/ITMSpecialFields.js', '', '1');

//Example #2
$link_module = Vtiger_Module::getInstance('PurchaseOrder');
$link_module->addLink('DETAILVIEWBASIC', 'ExportPDF', 'index.php?module=$MODULE$&action=ExportPdf&record=$RECORD$', '', '0');
