<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com.
 * All Rights Reserved.
 * *********************************************************************************************************************************** */

/**
 * Handle Lead module workflow creation for sending email
 *
 * @internal Lead Email Workflow
 */

ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');
include_once('../../config.inc.php');
global $root_directory, $adb;
set_include_path($root_directory); //for include root path
include_once("$root_directory/vtlib/Vtiger/Menu.php");
include_once("$root_directory/vtlib/Vtiger/Module.php");
include_once("$root_directory/vtlib/Vtiger/Block.php");
include_once("$root_directory/includes/runtime/Globals.php");
include_once("$root_directory/modules/com_vtiger_workflow/VTWorkflowManager.inc");
include_once("$root_directory/modules/com_vtiger_workflow/VTTaskManager.inc");

$moduleName = "Leads";
$workflowName = "Send Email on Lead Creation";
$workflowDescription = "Send an email when a lead is created";

echo '<pre>';
echo "$moduleName Workflow Creation Page".PHP_EOL;
echo '</pre>';

$Vtiger_Utils_Log = true;

echo '<pre>';
echo "Creating $moduleName Workflow".PHP_EOL;
echo '</pre>';

$vtWorkFlow = new VTWorkflowManager($adb);

// Check if the workflow already exists
$existingWorkflows = $vtWorkFlow->getWorkflowsForModule($moduleName);
$workflowExists = false;
foreach ($existingWorkflows as $workflow) {
    if ($workflow->description === $workflowName) {
        $workflowExists = true;
        break;
    }
}

if (!$workflowExists) {
    // Create a new workflow
    $leadWorkFlow = $vtWorkFlow->newWorkFlow($moduleName);

    // Define the workflow condition - here we check if the lead is created
    $leadWorkFlow->test = '[]'; // No condition, will trigger on every new lead

    $leadWorkFlow->description = $workflowName;
    $leadWorkFlow->name = $workflowName;
    $leadWorkFlow->status = 1;
    $leadWorkFlow->executionCondition = VTWorkflowManager::$ON_FIRST_SAVE; // Execute only on first save
    $leadWorkFlow->filtersavedinnew = 6;
    $vtWorkFlow->save($leadWorkFlow);

    // Create a task to send email
    $tm = new VTTaskManager($adb);

    $task = $tm->createTask('VTEmailTask', $leadWorkFlow->id);
    $task->summary = $workflowDescription;
    $task->active = true;
    $task->recepient = "\$(assigned_user_id : (Users) email1)";
    $task->subject = "New Lead Created: \$firstname";
    $task->content = "Hi,<br>A new lead has been created with the following details: <br> \n\nLead Number: \$lead_no <br> \nLead Name: \$firstname  \$surname 
                    <br>\nEmail: \$email <br> \nMobile: \$mobile <br> \nCourse to Register: \$course_to_register\n\n <br><br><br> Thank you.";
    $tm->saveTask($task);

    echo '<pre>';
    echo "$workflowName workflow successfully added!" . PHP_EOL;
    echo '</pre>';
} else {
    echo "Workflow already exists!";
}
?>
