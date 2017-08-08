<?php


include_once('../../config.inc.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
set_include_path($root_directory);
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');
//
$module = filter_input(INPUT_GET, 'module');//  URL?module=<modulename>
$childModule = filter_input(INPUT_GET, 'childModule');//  URL?childmodule=<modulename>
var_dump($module);
//if ($module!='' && $childModule!=''){
    $moduleOb = Vtiger_Module::getInstance($module);
    $moduleChildOb = Vtiger_Module::getInstance($childModule);
    var_dump($moduleOb->setRelatedList($moduleChildOb, $childModule, array('ADD'), 'get_dependents_list'));
//}
