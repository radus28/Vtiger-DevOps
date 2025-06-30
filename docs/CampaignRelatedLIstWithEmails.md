# Campaign Related list with Send Email

Follow below steps to add any modules including custom modules other than standard campaign modules Leads, Contacts and Accounts.

## Set Related list

Use a script like below. Run the file from the pat mentioned at [Set Related List section](https://github.com/radus28/Vtiger-DevOps/blob/master/set-related-lists/setRelatedList.php)

```


include_once('../../config.inc.php');

global $$root_directory, $$adb;

set_include_path($root_directory);

require 'vendor/autoload.php';

include_once('vtlib/Vtiger/Module.php');

include_once('vtlib/Vtiger/Block.php');

$module = 'Campaigns';

$childModules = ['CUSTOM-MODULE1','CUSTOM-MODULE2','HostFamily']; // Change your module names

foreach($childModules as $childModule){

    $moduleOb = Vtiger_Module::getInstance($module);
    
    $moduleChildOb = Vtiger_Module::getInstance($childModule);
    
     $functionName = 'get_'.strtolower($childModule);
     
    var_dump($moduleOb->setRelatedList($moduleChildOb, $childModule,['add','select'], $functionName));
    
    echo '<hr>';
}

```

## Create tables for each related module

Example

```
CREATE TABLE `vtiger_campaignhostfamilyrel` (
  `campaignid` int NOT NULL DEFAULT '0',
  `hostfamilyid` int NOT NULL DEFAULT '0',
  `campaignrelstatusid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`campaignid`,`hostfamilyid`,`campaignrelstatusid`),
  KEY `campaignhostfamilyrel_hostfamilyid_campaignid_idx` (`hostfamilyid`,`campaignid`),
  CONSTRAINT `fk_2_vtiger_campaignhostfamilyrel` FOREIGN KEY (`hostfamilyid`) REFERENCES `vtiger_hostfamily` (`hostfamilyid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```

## Update Campaign Class

Update following to `` modules/Campaigns/Campaign.php``

1. SetRelationTable()

	``` "HostFamily" => array("vtiger_campaignhostfamilyrel"=>array("campaignid","hostfamilyid")),```

2. UnlinkRelationship()

```	} elseif($return_module == 'HostFamily') {

			$sql = 'DELETE FROM vtiger_campaignhostfamilyrel WHERE campaignid=? AND hostfamilyid=?';
   
			$this->db->pquery($sql, array($id, $return_id));`1
   ```

  3. save_related_module()

``` elseif($with_module == 'HostFamily') {
				$checkResult = $adb->pquery('SELECT 1 FROM vtiger_campaignhostfamilyrel WHERE campaignid = ? AND hostfamilyid = ?',
												array($crmid, $with_crmid));
            
				if($checkResult && $adb->num_rows($checkResult) > 0) {
					continue;
				}

    $sql = 'INSERT INTO vtiger_campaignhostfamilyrel VALUES(?,?,1)';
    
				$adb->pquery($sql, array($crmid, $with_crmid));

			} 
   ```

4. Add get Related list function for Campaign related tabs (Change to get_<your-module>() )

```
function get_hostfamily($id, $cur_tab_id, $rel_tab_id, $actions=false) {
		global $log, $singlepane_view, $currentModule;
        $log->debug("Entering get_hostfamily(".$id.") method ...");
		$this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();

		$is_CampaignStatusAllowed = false;
		global $current_user;
		if(getFieldVisibilityPermission('HostFamily', $current_user->id, 'campaignrelstatus') == '0') {
			$other->list_fields['Status'] = array('vtiger_campaignrelstatus'=>'campaignrelstatus');
			$other->list_fields_name['Status'] = 'campaignrelstatus';
			$other->sortby_fields[] = 'campaignrelstatus';
			$is_CampaignStatusAllowed  = (getFieldVisibilityPermission('HostFamily', $current_user->id, 'campaignrelstatus','readwrite') == '0')? true : false;
		}

		vtlib_setup_modulevars($related_module, $other);
		$singular_modname = vtlib_toSingular($related_module);

		$parenttab = getParentTab();

		if($singlepane_view == 'true')
			$returnset = '&return_module='.$this_module.'&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module='.$this_module.'&return_action=CallRelatedList&return_id='.$id;

		$button = '';

		// Send mail button for selected HostFamily
		$button .= "<input title='".getTranslatedString('LBL_SEND_MAIL_BUTTON')."' class='crmbutton small edit' value='".getTranslatedString('LBL_SEND_MAIL_BUTTON')."' type='button' name='button' onclick='rel_eMail(\"$this_module\",this,\"$related_module\")'>";
		$button .= '&nbsp;&nbsp;&nbsp;&nbsp';

		/* To get HostFamily CustomView -START */
		require_once('modules/CustomView/CustomView.php');
		$lhtml = "<select id='".$related_module."_cv_list' class='small'><option value='None'>-- ".getTranslatedString('Select One')." --</option>";
		$oCustomView = new CustomView($related_module);
		$viewid = $oCustomView->getViewId($related_module);
		$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid, false);
		$lhtml .= $customviewcombo_html;
		$lhtml .= "</select>";
		/* To get HostFamily CustomView -END */

		$button .= $lhtml."<input title='".getTranslatedString('LBL_LOAD_LIST',$this_module)."' class='crmbutton small edit' value='".getTranslatedString('LBL_LOAD_LIST',$this_module)."' type='button' name='button' onclick='loadCvList(\"$related_module\",\"$id\")'>";
		$button .= '&nbsp;&nbsp;&nbsp;&nbsp';

		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($related_module) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input type='hidden' name='createmode' id='createmode' value='link' />".
					"<input title='".getTranslatedString('LBL_ADD_NEW'). " ". getTranslatedString($singular_modname) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}

		$userNameSql = getSqlForNameInDisplayFormat(array('first_name'=>
							'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');
		$query = "SELECT vtiger_hostfamily.*, vtiger_crmentity.crmid,
				CASE when (vtiger_users.user_name not like '') then $userNameSql else vtiger_groups.groupname end as user_name,
				vtiger_crmentity.smownerid, vtiger_campaignrelstatus.*
				FROM vtiger_hostfamily
				INNER JOIN vtiger_campaignhostfamilyrel ON vtiger_campaignhostfamilyrel.hostfamilyid=vtiger_hostfamily.hostfamilyid
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_hostfamily.hostfamilyid
				INNER JOIN vtiger_hostfamilycf ON vtiger_hostfamily.hostfamilyid = vtiger_hostfamilycf.hostfamilyid
				LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id
				LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid
				LEFT JOIN vtiger_campaignrelstatus ON vtiger_campaignrelstatus.campaignrelstatusid = vtiger_campaignhostfamilyrel.campaignrelstatusid
				WHERE vtiger_crmentity.deleted=0  AND vtiger_campaignhostfamilyrel.campaignid = ".$id;

		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

		if($return_value == null)
			$return_value = Array();
		else if($is_CampaignStatusAllowed) {
			$statusPos = isset($return_value['header']) ? php7_count($return_value['header']) - 2 : ''; // Last column is for Actions, exclude that. Also the index starts from 0, so reduce one more count.
			$return_value = $this->add_status_popup($return_value, $statusPos, 'HostFamily');
		}

		$return_value['CUSTOM_BUTTON'] = $button;

		$log->debug("Exiting get_hostfamily method ...");
		return $return_value;
	}

```

## Update Campaigns/models/Relation.php

Add below into ```getEmailEnabledModulesInfoForDetailView() ```

```  'HostFamily' => array('fieldName' => 'hostfamilyid', 'tableName' => 'vtiger_campaignhostfamilyrel'),```

## Update modules/Campaigns/models/Module.php (Optional, future use)

In ``` getQueryByModuleField() ``` add

```case 'HostFamily'  : $tableName = 'vtiger_campaignhostfamilyrel'; $relatedFieldName = 'hostfamilyid';     break;```




