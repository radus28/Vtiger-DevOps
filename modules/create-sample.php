<?php
ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');
include_once ('../../config.inc.php');
global $root_directory, $adb;
set_include_path($root_directory); //for include root path
include_once ('vtlib/tools/console.php');

$moduleInformation = [
    'name' => 'Trialmodule',//  Change YOUR MODULE NAME
    'parent' => 'SALES',// CHANGE PARENT TAB
    'entityfieldname' => 'tm_name', // CHANGE KEY FIELD OF the module
    'entityfieldlabel' => 'TM Name', // CHANGE LABLE OF KEY FIELD

];
class Radus_ModuleController extends Vtiger_Tools_Console_ModuleController
{
    public static function build($moduleInformation)
    {
        $createModuleController = new Vtiger_Tools_Console_ModuleController();
        $createModuleController->create($moduleInformation);
        echo 'Module created successfully';
    }
}
$moduleController = Radus_ModuleController::build($moduleInformation);

