<?php
/**
 * If you are running this script from folder like migrations/relatedlist.
 * Run this using a URL like FOLDER#1/FOLDER#2/SetDependTab.php?module=ServiceContracts&childmodule=Events&fieldname=servicecontract_no
 * @author Sutharsan Jeganathan <sutharsan@radus28.com>
 * @internal  A common script to create Vtiger dependant list based on uitype 10 field
 * @param  $module fetch via $_GET
 * @param $childmodule  via $_GET
 * @param $fieldName via $_GET pass your UIType 10 field reference
 * @link https://github.com/radus28/Vtiger-DevOps/blob/master/fields/ui10.php to see how to create UI Type 10 field 
 */
include_once('../../config.inc.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);
ini_set('display_errors', 1);
set_include_path($root_directory);
include_once 'include/utils/CommonUtils.php';
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');
//
$module = filter_input(INPUT_GET, 'module');//  URL?module=<modulename> , parent module
$childModule = filter_input(INPUT_GET, 'childmodule');//  URL?childmodule=<modulename>, child module
$fieldName = filter_input(INPUT_GET, 'fieldname');//  URL?fieldname=xxx, get field name from vtiger_fields

$tabId = getTabid($childModule);
$fieldId = getFieldid($tabId, $fieldName);

$fieldInstance = Vtiger_Field::getInstance("servicecontract_no", $moduleInstance);
if ($module!='' && $childModule!=''){
    $moduleOb = Vtiger_Module::getInstance($module);
    $moduleChildOb = Vtiger_Module::getInstance($childModule);
    /**
    * Use any of these to enable buttons in related list : array('ADD') | array('SELECT') | array('ADD','SELECT). Note, this won't work to Calendar/events
    * Instead of 'get_dependents_list':
    * Use get_related_list for N:M Relation, eg, ServiceContract & Event/Task. This will create a reference field of parent module into child module
    * Use get_activity_list if child module is calendar
    * User get_emails if child module is Emails
    **/
   var_dump($moduleOb->setRelatedList($moduleChildOb, $childModule,array('ADD'),'get_dependents_list',$fieldId));
}
