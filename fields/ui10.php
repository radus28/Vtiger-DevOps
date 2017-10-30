    <?php

    $Vtiger_Utils_Log = true;
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
    include_once('../../config.inc.php');
    set_include_path($root_directory); //for include root path
    include_once('vtlib/vtiger/menu.php');
    include_once('vtlib/Vtiger/Module.php');
    include_once('vtlib/Vtiger/Block.php');
    //Module Nmae
    $moduleInstance = Vtiger_Module::getInstance('Contacts');
    //Block Name
    $blockInstance = Vtiger_Block::getInstance('LBL_CONTACT_INFORMATION',$moduleInstance);


    $fieldInstance = Vtiger_Field::getInstance("accounts", $moduleInstance);
            if ($fieldInstance === false) {
    $fieldInstance = new Vtiger_Field();
    $fieldInstance->name = 'accounts';
    $fieldInstance->label = 'ACCOUNTS';
    $fieldInstance->table = 'vtiger_contactdetails';
    $fieldInstance->column = 'accounts';
    $fieldInstance->columntype = 'int(11)';
    $fieldInstance->uitype = 10;
    $fieldInstance->typeofdata = 'V~O';
    $blockInstance->addField($fieldInstance);
    $fieldInstance->setRelatedModules(array('Accounts')); //Choose your related module or modules in array

    }
    echo 'fields done';
