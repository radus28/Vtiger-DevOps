<?php
/**
 * CAUTIION : Doublt check the $moduleName variable, before run script.
 * @internal This is a script to remove a module from vtiger instance
 * 1. This removes module from db only
 * 2. Remove the files under /modules, /language, and any other folders by a commit after deleting local
 * 
 */

ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');
include_once ('../../config.inc.php');
global $root_directory, $adb;
set_include_path($root_directory); //for include root path
include_once ('vtlib/tools/console.php');


class Radus_ModuleController extends Vtiger_Tools_Console_ModuleController
{
    public static function build($moduleInformation)
    {
        $controller = new Vtiger_Tools_Console_RemoveController();
        $controller->setArguments([$moduleInformation], FALSE)->handle();
        return ' <br> Module ' . $moduleInformation[0] . ' removed successfully';
    }
}
/**
 * @var $moduleName Change the name of the module to delete it
 * 
 */
$moduleName = "Candidate";
$response = Radus_ModuleController::build($moduleName);
echo $response;


