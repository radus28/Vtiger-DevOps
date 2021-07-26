<?php

require_once('vtiger/curl.func.php');

class CRMApi {

    private $username = 'apiuser'; // You may use any user
    private $accessKey = 'zXEsu0vt2VItass7'; // Obtain from CRM > My Preference > Access Key  (Use admin user to get all privileges
    private $token = '';
    public $endpointurl = 'https://localhost/bdc_crm/webservice.php';
    public $session = '';

    private function getToken() {
        $ws_url = "{$this->endpointurl}?operation=getchallenge&username={$this->username}";
        $response = getResponseFromURL($ws_url);
        $resobj = json_decode($response);
        $this->token = $resobj->result->token;
    }

    public function getSession() {
        $this->getToken();
        $preparedkey = md5($this->token . $this->accessKey);
        $postlist = array(
            'operation' => 'login',
            'username' => $this->username,
            'accessKey' => $preparedkey
        );
        $loginresponse = getResponseFromURL($this->endpointurl, $postlist);
        $sesobj = json_decode($loginresponse);
        if ($sesobj->result->sessionName) {
            $session = $sesobj->result->sessionName;
            $userId = $sesobj->result->userId;
            $this->session = $session;
        } else {
            return false;
        }
    }

}
