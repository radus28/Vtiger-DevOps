<?php

chdir(dirname(__FILE__));
if(!file_exists("config.inc.php")) {
	exit("config.inc.php not found\nPlease place in vtiger root directory\n");
}
include "config.inc.php";
require_once('modules/Users/CreateUserPrivilegeFile.php');

global $adb;

$forUser ='';
if(isset($argv[1])) {
	$forUser = " AND `id`=".$argv[1];
} else {
	$forUser = "";
}

$user_array = array();
$sql = "SELECT * FROM vtiger_users WHERE `status`='Active' AND user_name !='' AND user_name NOT LIKE '%\'%'".$forUser;
$sth = $adb->query($sql);
while($row=$adb->fetch_row($sth)) {
	$user_array[$row["id"]] = $row;
}


foreach($user_array as $userid=>$user) {
	echo "running for ".$user["user_name"]." / $userid.. ";
	createUserPrivilegesfile($userid);
	echo "Done.\n";
}


foreach($user_array as $userid=>$user) {
	echo "running for ".$user["user_name"]." / $userid.. ";
	if(!file_exists("user_privileges/user_privileges_$userid.php")) {
		file_put_contents("user_privileges/user_privileges_$userid.php","");
	}
	createUserSharingPrivilegesfile($userid);
	//populateSharingtmptables($userid);
	echo "Done.\n";
}
//populateSharingtmptables
foreach($user_array as $userid=>$user) {
	echo "running for ".$user["user_name"]." / $userid.. ";
	populateSharingtmptables($userid);
	echo "Done.\n";
}
