<?php

$endpointurl = 'https://crm.domain.com/modules/Mobile/api.php'; // You crm url prepended with webservice.php
$postlist = array(
    '_operation' => 'login',
    'username' => 'Dev',//'live',
    'password' => 'DdddMx&'//
);
$assigneUserId ='19x5';// use an existing user id



$loginResp = getResponseFromURL($endpointurl, $postlist);
$resp = json_decode($loginResp,true);
//var_dump($loginResp);exit;
$session = $resp['result']['login']['session'];
//echo "Session is ".$session;

/**
 * Query with Events module example
 */
//$postlist = array(
//    '_operation' => 'query',
//    '_session' => $session,
//    'query' => "SELECT * FROM Events WHERE activitytype='Visits';"
//);
//$taskResp = getResponseFromURL($endpointurl, $postlist);
//$resp = json_decode($taskResp,true);

/**
 * Create document
 */

//$fileName = 'document.vtws.pdf';
$fileName = 'doc-upload-test.jpg';
$fileContent = file_get_contents ($fileName);
$fileSize = strlen ($fileContent);

$data['notes_title'] = 'TEST doc from sandbox mobile api';
$data['filelocationtype'] = 'I';
//$data['filetype'] = 'application/pdf';
$data['filetype'] = 'image/jpeg';// uncomment to test image
$data['filename'] = $fileName;
$data['assigned_user_id'] = $assigneUserId;
$data['filesize'] = $fileSize;
$data['filestatus'] = '1';
$data['file'] = base64_encode ($fileContent); 
echo '<pre>';

$postlist = array(
    '_operation' => 'saveRecord',
    'module' => 'Documents',
    '_session' => $session,
    'values' => $data
);
$cFile = new CURLFile(@realpath($fileName), $data['filetype'], $fileName);
$postlist['filename'] = $cFile;



// print_r($postlist);
// exit;

// $headers = ["Content-Type" => "multipart/form-data"];
// $headers = ["CONTENT_TYPE" => "application/x-www-form-urlencoded"];
$taskResp = getResponseFromURL($endpointurl, $postlist,$headers);
$resp = json_decode($taskResp);
var_dump($resp); 
exit;


function getResponseFromURL($url = "", $post = array(), $headers = array(), $debug = false) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 0,
        CURLOPT_TIMEOUT => 400,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));

    if (count($post) > 0) {
        curl_setopt_array($curl, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post)
        ));
//          var_dump(http_build_query($post));echo '<hr/>';
    }
    if (!empty($headers)) {

        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => $headers
        ));
    }

    $resp = curl_exec($curl);

    if ($resp === false) {
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl) . "<br />" . $url);
    }

    if ($debug) {
        echo "<pre>" . print_r(curl_getinfo($curl), true) . "</pre>";
        echo "<pre>" . print_r($resp, true) . "</pre>";
    }

    curl_close($curl);
    return $resp;
}

exit;

