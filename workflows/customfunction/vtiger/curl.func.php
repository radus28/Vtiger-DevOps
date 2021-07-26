<?php

function getResponseFromURL($url = "", $post = array(), $headers = array(), $debug = false, $jsonpost = false, $isPut = false) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 0,
        CURLOPT_TIMEOUT => 400,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ));

    if (count($post) > 0) {

        if ($jsonpost) {
            if ($isPut) {
                curl_setopt_array($curl, array(
                    CURLOPT_PUT => true,
                    CURLOPT_POSTFIELDS => json_encode($post),
                ));
            } else {
                curl_setopt_array($curl, array(
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($post),
                ));
            }
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($post)
            ));
        }
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
?>
