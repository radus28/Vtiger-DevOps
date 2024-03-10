<?php
/**
 * Check README.md before continue
 * retrieving a  file attached to any module
 * @param operation =file_retrieve 
 * @param file_id wsEntity x attachment id. 
 * Here wsEntity should be the parent module where the file is attached. Example Document is 15x
 */
$params = array("sessionName" => $session, "operation" => 'file_retrieve' ,"file_id" => '15x143964' );
$response = getResponseFromURL("$endpointurl?operation=file_retrieve&sessionName=" . $session . "&file_id=15x143964");
$file = json_decode($response,true);

/**
 * Example of retrieve image and display
 */
echo '<pre>';
echo '<img src="data:'.$file['result'][0]['filetype'].';base64,'.$file['result'][0]['filecontents'].'" />';
var_dump($file);
exit;