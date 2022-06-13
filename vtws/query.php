<?php
/**
 * This script is a sample for using vtiger webservice query method
 * @author  Sutharsan Jeganathan
 * 
 */

$username = 'admin'; // You may use any user
$accessKey = 'OPENCRMITALIAKEY'; // Obtain from CRM > My Preference > Access Key  (Use admin user to get all privileges
$vtEndpointurl = 'http://localhost:15080/webservice.php'; // You crm url prepended with webservice.php
                

$ws_url = "{$vtEndpointurl}?operation=getchallenge&username={$username}";
$response = getResponseFromURL($ws_url);
$resobj = json_decode($response);

$token = $resobj->result->token;
echo '<pre>';
//print_r($token);

$preparedkey = md5($token . $accessKey);
$postlist = array(
    'operation' => 'login',
    'username' => $username,
    'accessKey' => $preparedkey
);

$loginresponse = getResponseFromURL($vtEndpointurl, $postlist);
$sesobj = json_decode($loginresponse);
$session = $sesobj->result->sessionName;
$userId=$sesobj->result->userId;
//echo '<hr/>';
print_r($loginresponse);

//$query = "SELECT+%2A+FROM+Products;";
$query = urlencode("SELECT * FROM Products WHERE productname IN ('Telefonia','stampante', 'webinar');");

$params = "sessionName=".$session."&operation=query&query=".$query;

$response = getResponseFromURL($vtEndpointurl."?".$params);

//decode the json encode response from the server.
$jsonResponse = json_decode($response, true);
var_dump($jsonResponse);exit;



function getResponseFromURL($url = "", $post = array(), $headers = array(), $debug = false) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 0, 
        CURLOPT_TIMEOUT => 400
    ));

    if(count($post)>0){
        curl_setopt_array($curl, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post)
        ));
//          var_dump($post);echo '<hr/>';
    }
    if(!empty($headers)){
      
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => $headers
        ));
    }

    $resp = curl_exec($curl);

    if($resp === false){
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl) . "<br />" . $url);
    }

    if($debug){
        echo "<pre>" . print_r(curl_getinfo($curl), true) . "</pre>";             
        echo "<pre>" . print_r($resp, true) . "</pre>";             
    }

    curl_close($curl);
    return $resp;
}


?>
