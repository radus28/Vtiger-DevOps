<?php 
$username = 'admin'; // You may use any user
$accessKey = 'VAqAV6pX24AJZS11'; // Obtain from CRM > My Preference > Access Key  (Use admin user to get all privileges
$endpointurl = 'http://localhost/[CRM-FOLDER]/webservice.php'; // You crm url prepended with webservice.php
echo '<pre>';
/**
 * Getting challenge token - Challenge response authentication to avoid eavesdropping
 */
$ws_url = "{$endpointurl}?operation=getchallenge&username={$username}";
$response = getResponseFromURL($ws_url);
$resobj = json_decode($response);
$token = $resobj->result->token;

/**
 * Authentication (Login)
 */
$preparedkey = md5($token . $accessKey);
$postlist = array(
    'operation' => 'login',
    'username' => $username,
    'accessKey' => $preparedkey
);
$loginresponse = getResponseFromURL($endpointurl, $postlist);
$sesobj = json_decode($loginresponse);
$session = $sesobj->result->sessionName;
$userId = $sesobj->result->userId;

/**

* Create example : Contacts module

*/
$data = [];
$data['firstname'] = 'too tt';
$data['lastname'] = 'Iname';
$data['email'] = 'jpg@image.io';
$data['phone'] = '12457889';
$data['assigned_user_id'] = '19x1';// note prefix '19x'
$params = array("sessionName" => $session, "operation" => 'create', "element" => json_encode($data), "elementType" => 'Documents');// Final parameters
$response = getResponseFromURL($endpointurl, $params);// Note 'getResponseFromURL()' is just a custom method used with php / cURL.
$created = json_decode($response);

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
//          var_dump($post);echo '<hr/>';
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
?>
