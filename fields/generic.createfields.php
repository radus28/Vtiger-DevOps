 <?php

ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');
include_once('../../../config.inc.php');
set_include_path($root_directory); //for include root path
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Block.php');



$moduleName = "Partner";
echo '<pre>';
echo "$moduleName Module Fields Create Page".PHP_EOL;
echo '</pre>';
$fieldsArray = [
    'LBL_PARTNER_INFORMATION' => [
        'blockLabel' => 'LBL_PARTNER_INFORMATION',
        'fields' => [

            'partner_number' => [
                'name' => 'partner_number',
                'label' => 'Partner Number',
                'table' => 'vtiger_partner',
                'column' => 'partner_number',
                'columntype' => 'varchar(100)',
                'uitype' => 4,
                'typeofdata' => 'V~O',
                
            ],

            'partner_address' => [
                'name' => 'partner_address',
                'label' => 'Address',
                'table' => 'vtiger_partner',
                'column' => 'partner_address',
                'columntype' => 'varchar(255)',
                'uitype' => 21,
                'typeofdata' => 'V~O',
                
            ],
            'organization_contact_no' => [
                'name' => 'organization_contact_no',
                'label' => 'Contact Number of the Organization',
                'table' => 'vtiger_partner',
                'column' => 'organization_contact_no',
                'columntype' => 'varchar(30)',
                'uitype' => 11,
                'typeofdata' => 'N~O',
                
            ],
            'website' => [
                'name' => 'website',
                'label' => 'Website',
                'table' => 'vtiger_partner',
                'column' => 'website',
                'columntype' => 'varchar(255)',
                'uitype' => 17,
                'typeofdata' => 'V~O',
                
            ],
            'contact_person_full_name' => [
                'name' => 'contact_person_full_name',
                'label' => 'Contact person Full Name',
                'table' => 'vtiger_partner',
                'column' => 'contact_person_full_name',
                'columntype' => 'varchar(100)',
                'uitype' => 1,
                'typeofdata' => 'V~O',
                
            ],
            'job_itle' => [
                'name' => 'job_itle',
                'label' => 'Job Title',
                'table' => 'vtiger_partner',
                'column' => 'do_you_have_a_signed_vsd',
                'columntype' => 'varchar(255)',
                'uitype' => 1,
                'typeofdata' => 'V~O',
                
            ],
            'type_of_program' => [
                'name' => 'type_of_program',
                'label' => 'Type of Program',
                'table' => 'vtiger_partner',
                'column' => 'type_of_program',
                'columntype' => 'varchar(255)',
                'picklistValues'=> ['Employment Ontario', 'Placement Partner'],
                'uitype' => 15,
                'typeofdata' => 'V~O',
                
            ],
            'email_address' => [
                'name' => 'email_address',
                'label' => 'Email Address',
                'table' => 'vtiger_partner',
                'column' => 'email_address',
                'columntype' => 'varchar(255)',
                'uitype' => 13,
                'typeofdata' => 'E~O',
                
            ],
            'phone_number' => [
                'name' => 'phone_number',
                'label' => 'Phone Number',
                'table' => 'vtiger_partner',
                'column' => 'phone_number',
                'columntype' => 'varchar(255)',
                'uitype' => 11,
                'typeofdata' => 'V~O',
                
            ],
            
        ],
    ],


];


    

$relatedLists = [
    [
        'parentModule' => $moduleName,
        'relatedModule' => 'Emails',
        'label' => 'Emails',
        'actions' => 'ADD',
        'function_name' => 'get_emails'
    ],
    [
        'parentModule' => $moduleName,
        'relatedModule' => 'Documents',
        'label' => 'Documents',
        'actions' => 'ADD,SELECT',
        'function_name' => 'get_attachments'
    ],
    [
        'parentModule' => $moduleName,
        'relatedModule' => 'ModComments',
        'label' => 'Comments',
        'actions' => '',
        'function_name' => 'get_comments',
        // 'relationfieldid' => 670
    ]
];


$moduleInstance = Vtiger_Module::getInstance($moduleName);//Module Name
if ($moduleInstance) {
    foreach ($fieldsArray as $blockName => $fieldsData) {
        // Block check / create
        $blockInstance = Vtiger_Block::getInstance($blockName, $moduleInstance);//Block Name
        if (!$blockInstance) {
            $blockInstance = new Vtiger_Block();
            $blockInstance->label = $blockName;
            $moduleInstance->addBlock($blockInstance);
            echo '<pre>';
            echo "Create New Block: " . $blockName;
            echo '</pre>';
        }
        foreach ($fieldsData['fields'] as $fieldName => $fieldInfo) {
            //Field check / Create
            $fieldInstance = Vtiger_Field::getInstance($fieldName, $moduleInstance);//Field Name
            if (!$fieldInstance) {
                $field = new Vtiger_Field();
                $field->name = $fieldInfo['name'];
                $field->label = $fieldInfo['label'];
                $field->table = $fieldInfo['table'];
                $field->column = $fieldInfo['column'];
                $field->columntype = $fieldInfo['columntype'];
                $field->uitype = $fieldInfo['uitype'];
                $field->typeofdata = $fieldInfo['typeofdata'];
                if ($field->uitype == '15' || $field->uitype == '16') {
                    if (!empty($fieldInfo['picklistValues'])) {
                        $field->setPicklistValues($fieldInfo['picklistValues']);
                    } else {
                        $field->setPicklistValues([]);
                    }
                }
                if(isset($fieldInfo['presence'])){
                    $field->presence = $fieldInfo['presence'];
                }

                if(isset($fieldInfo['displaytype'])){
                    $field->displaytype = $fieldInfo['displaytype'];
                }

                if(isset($fieldInfo['readonly'])){
                    $field->readonly = $fieldInfo['readonly'];
                }

                $blockInstance->addField($field);
                if($field->uitype == '10'){
                    $field->setRelatedModules($fieldInfo['modules']);
                }
                echo '<pre>';
                echo "Field Created: " . $fieldName;
                echo '</pre>';
            } else {
                echo '<pre>';
                echo "Field Already Present: " . $fieldName;
                echo '</pre>';
            }
        }
    }

} else {
    exit("Module Name is Wrong");
}

/**
 * Start to add related list.
 */

foreach ($relatedLists as $relatedList){
    $parentInstance = Vtiger_Module::getInstance($relatedList['parentModule']);
    $relatedInstance = \Vtiger_Module::getInstance($relatedList['relatedModule']);

    if($parentInstance && $relatedInstance){
        $parentInstance->getId();
        $isRelatedListExist = $adb->pquery("SELECT relation_id FROM vtiger_relatedlists where tabid = ? and related_tabid = ? and name = ?",
            array($parentInstance->getId(), $relatedInstance->getId(), $relatedList['function_name']));

        if($adb->num_rows($isRelatedListExist) === 0){
            $relationFieldId = ($relatedList['relationfieldid'])??'';
            $parentInstance->setRelatedList($relatedInstance, $relatedList['label'], $relatedList['actions'],
                $relatedList['function_name'],$relationFieldId);
            echo '<pre>';
            echo $relatedList['relatedModule'] . " related list created for  " . $relatedList['parentModule'];
            echo '</pre>';

        }else{
            echo '<pre>';
            echo $relatedList['relatedModule'] . " related list already exist for  " . $relatedList['parentModule'];
            echo '</pre>';
        }
    }
}
