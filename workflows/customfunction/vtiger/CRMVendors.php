<?php

require_once('vtiger/curl.func.php');

class CRMVendors
{

    private $CRMApi;

    /**
     * Set authenticated API Object with session key
     * @param type $CRMApi
     */
    public function setAPI($CRMApi)
    {
        $this->CRMApi = $CRMApi;
    }

    /**
     * Returns CRM Organization by given XeroId
     * @param type $xeroId
     * @return boolean
     */
    public function getVendorByXeroId($xeroId)
    {
        $query = "SELECT+%2A+FROM+Vendors+WHERE+xero_id='" . $xeroId . "';";
        $params = "sessionName=" . $this->CRMApi->session . "&operation=query&query=" . $query;
        $response = getResponseFromURL($this->CRMApi->endpointurl . "?" . $params);
        $result = json_decode($response, true);
        if (isset($result['success'])) {
            return $result;
        } else if ($result['error']) {
            return $result['error'];
        } else {
            return false;
        }
    }

    /**
     * Creating customer in Organization module
     * @param type $customerData
     * @param type $CRMAPi
     */
    public function createVendor($xeroContacts, $data = [])
    {
        $method = 'create';
        if (count($data) > 0) {
            $method = 'update';
        }
        $data['vendorname'] = $xeroContacts[0]->getName() != '' ? $xeroContacts[0]->getName() : $xeroContacts[0]->getFirstName() . ' ' . $xeroContacts[0]->getLastName();
        ;
        $data['phone'] = $xeroContacts[0]->getPhones()[0]->getPhoneNumber();
        $data['email'] = $xeroContacts[0]->getEmailAddress();
        $data['xero_id'] = $xeroContacts[0]->getContactId();
        $data['assigned_user_id'] = '19x7';

        $params = array("sessionName" => $this->CRMApi->session, "operation" => $method,
            "element" => json_encode($data), "elementType" => 'Vendors');
        $response = getResponseFromURL($this->CRMApi->endpointurl, $params);
        $created = json_decode($response);
        return $created;
    }

}
