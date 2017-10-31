<?php

$Vtiger_Utils_Log = true;
include_once 'config.inc.php';
ini_set('include_path', $root_directory);
include_once('include/utils/utils.php');
include_once('vtlib/Vtiger/Module.php');
$modulename = $_REQUEST['module'];
$moduleDir = 'modules/' . $modulename . '/';
$moduleDirRenamed = 'modules/' . $modulename . time() . '/';
include_once ($moduleDir . $modulename . '.php');
$moduleobj = new $modulename;
$moduleVars = get_object_vars($moduleobj);
echo '<pre>';

$adb = PearDatabase::getInstance();
if (isset($moduleVars['customFieldTable'][0])) {
    $result1 = $adb->query('DROP TABLE ' . $moduleVars['customFieldTable'][0]);
    if ($result1 != false) {
        $result2 = $adb->query('DROP TABLE ' . $moduleVars['table_name']);
        $result3 = $adb->query('DELETE FROM vtiger_field where fieldid IN (SELECT fieldid FROM vtiger_fieldmodulerel WHERE relmodule="'.$modulename.'")');
    }
}
//var_dump($adb);
$isRemoved = false;
if ($result2 != false) {
    if (file_exists($moduleDir))
        $isRemoved = rename($moduleDir, $moduleDirRenamed);
}

if ($isRemoved) {
    $module = Vtiger_Module::getInstance($modulename);
    if ($module) {
        $module->delete();
    }
}
?>