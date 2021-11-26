<?php

// If you are running this script from folder like migrations/relatedlist
include_once('../../config.inc.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');
//
$module = filter_input(INPUT_GET, 'module');//  URL?module=<modulename> , parent module
$childModule = filter_input(INPUT_GET, 'childModule');//  URL?childmodule=<modulename>, child module
if ($module!='' && $childModule!=''){
    $moduleOb = Vtiger_Module::getInstance($module);
    $moduleChildOb = Vtiger_Module::getInstance($childModule);
    /**
    * Use any of these to enable buttons in related list : array('ADD') | array('SELECT') | array('ADD','SELECT)
    * Instead of 'get_dependents_list':
    * Use get_related_list for 1:M Relation, eg, Project & project tasks. This will create a reference field of parent module into child module
    * Use get_activity_list if child module is calendar
    * User get_emails if child module is Emails
    **/
    var_dump($moduleOb->setRelatedList($moduleChildOb, $childModule, array('ADD'), 'get_dependents_list'));
}
