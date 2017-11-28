<?php

$Vtiger_Utils_Log = true;
include_once 'config.inc.php';
ini_set('include_path', $root_directory);
include_once('include/utils/utils.php');
include_once('vtlib/Vtiger/Module.php');
$modulename = $_REQUEST['module'];
$moduleDir = 'modules/' . $modulename . '/';
$moduleDirRenamed = 'modules/' . $modulename . time() . '/';
$layoutDir = 'layouts/v7/modules/' . $modulename . '/';
$layoutDirRenamed = 'layouts/v7/modules/Settings/' . $modulename . time() . '/';
$layoutSettDir = 'layouts/v7/modules/Settings/' . $modulename . '/';
$layoutSettDirRenamed = 'layouts/v7/modules/' . $modulename . time() . '/';
$moduleSettingDir = 'modules/Settings/' . $modulename . '/';
$moduleSettingDirRenamed = 'modules/Settings/' . $modulename . time() . '/';
$adb = PearDatabase::getInstance();
$tabId = getTabid($modulename);
$tabInfoResult = $adb->pquery('SELECT * FROM vtiger_tab WHERE tabid=? LIMIT 1', array($tabId));
$tabInfo = $adb->fetch_array($tabInfoResult);
$result2 = true;
if (isset($tabInfo['isentitytype']) == false) {// wrong module name passed
    die('invalid module ');
} else {
    include_once ($moduleDir . $modulename . '.php');
    $moduleobj = new $modulename;
    $moduleVars = get_object_vars($moduleobj);
    if ($tabInfo['isentitytype'] == '1' && isset($moduleVars['customFieldTable'][0])) {// if entity module only
        $result1 = $adb->query('DROP TABLE ' . $moduleVars['customFieldTable'][0]);
        if ($result1 != false) {
            $result2 = $adb->query('DROP TABLE ' . $moduleVars['table_name']);
            $result3 = $adb->query('DELETE FROM vtiger_field where fieldid IN (SELECT fieldid FROM vtiger_fieldmodulerel WHERE relmodule="' . $modulename . '")');
        }
    }
}

$module = Vtiger_Module::getInstance($modulename);
if ($module) {
    $module->delete();
}

//var_dump($adb);
$isRemoved = false; // removing module folder
if ($result2 != false) {
    if (file_exists($moduleDir))
        $isRemoved = rename($moduleDir, $moduleDirRenamed);
    $isRemovedLay = rename($layoutDir, $layoutDirRenamed);
    if ($tabInfo['isentitytype'] == '0') {// if extension
        $isRemovedSet = rename($moduleSettingDir, $moduleSettingDirRenamed);
        $isRemovedLaySet = rename($layoutSettDir, $layoutSettDirRenamed);
        $adb->pquery('DELETE FROM vtiger_settings_field WHERE name=?', array('LBL_ADVANCED_MENU_MANAGER_CONFIG'));
    }
}
?>
