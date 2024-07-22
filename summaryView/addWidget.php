<?php

include_once ('../../config.inc.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
global $root_directory;
set_include_path($root_directory); //for include root path
include_once ("$root_directory/vtlib/Vtiger/Menu.php");
include_once ("$root_directory/vtlib/Vtiger/Module.php");
include_once ("$root_directory/vtlib/Vtiger/Block.php");
$modcommentsModuleInstance = Vtiger_Module::getInstance('ModComments');
$moduleFilePath = $root_directory . '/modules/ModComments/ModComments.php';
// var_dump(file_exists($moduleFilePath));
// exit;
if ($modcommentsModuleInstance && file_exists($moduleFilePath)) {
    include_once $moduleFilePath;
    if (class_exists('ModComments')) {
        ModComments::addWidgetTo('Candidates', 'DETAILVIEWWIDGET');
        echo 'Widget added';
        exit;
    } else {
        echo "Mod Comment class doesn't exist";
    }
} else {
    echo "No comments module";
}
