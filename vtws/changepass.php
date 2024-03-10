<?php



$endpointurl = 'http://localhost/qler_vtiger_dev/modules/Mobile/api.php'; // You crm url prepended with webservice.php

$postlist = array(
    '_operation' => 'login',
    'username' => 'crmadmin',//'admin',
    'password' => 'ki32f3#$$24^'//'B#Major7'
);

$loginResp = getResponseFromURL($endpointurl, $postlist);
//print_r($loginResp);


$resp = json_decode($loginResp,true);
$session = $resp['result']['login']['session'];

 $postlist = array(
     '_operation' => 'changepassword',
     '_session' => $session,
     'username'=>'test',
     'email' => 'test@test.com',
     'password'=>'Abc@#$321091',
     'confirmpassword' => 'Abc@#$321091',
 );

$taskResp = getResponseFromURL($endpointurl, $postlist);
echo "<pre>";
print_r($taskResp);
echo "</pre>";

$resp = json_decode($taskResp,true);
echo '<pre>';var_dump($resp);//exit;

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
          var_dump(http_build_query($post));echo '<hr/>';
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