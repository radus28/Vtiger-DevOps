<?php

require_once('vtiger/curl.func.php');

class CRMCustomer {

    private $CRMApi;

    /**
     * Set authenticated API Object with session key
     * @param type $CRMApi
     */
    public function setAPI($CRMApi) {
        $this->CRMApi = $CRMApi;
    }

    /**
     * Returns CRM Organization by given XeroId
     * @param type $xeroId
     * @return boolean
     */
    public function getCustomerByXeroId($xeroId) {
//echo $xeroId;
        $query = "SELECT+%2A+FROM+Accounts+WHERE+xero_id='" . $xeroId . "';";
        $params = "sessionName=" . $this->CRMApi->session . "&operation=query&query=" . $query;
        $response = getResponseFromURL($this->CRMApi->endpointurl . "?" . $params);
        $result = json_decode($response);
        if ($result->success) {
            return $result;
        } else if ($result->error) {
            return $result->error;
        } else {
            return false;
        }
    }

    /**
     * Creating customer in Organization module
     * @param type $customerData
     * @param type $CRMAPi
     */
    public function createCustomer($crmContactData) {

        $data['accountname'] = $crmContactData->getName();
        $data['xero_first_name'] = $crmContactData->getFirstName();
        $data['xero_last_name'] = $crmContactData->getLastName();
        $data['phone'] = $crmContactData->getPhones()[0]->getPhoneNumber();
        $data['email1'] = $crmContactData->getEmailAddress();
        $data['xero_id'] = $crmContactData->getContactId();
        $data['assigned_user_id'] = '19x6';
        $params = array("sessionName" => $this->CRMApi->session, "operation" => 'create',
            "element" => json_encode($data), "elementType" => 'Accounts');
        $response = getResponseFromURL($this->CRMApi->endpointurl, $params);
        $created = json_decode($response);
        return $created;
    }

}
