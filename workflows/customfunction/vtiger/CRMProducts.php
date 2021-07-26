<?php

require_once('vtiger/curl.func.php');

class CRMProduct {

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
    public function getProductByXeroId($xeroId, $itemDescription = '') {

        if ($xeroId != '') {
            $query = "SELECT+%2A+FROM+Products+WHERE+xero_id='" . $xeroId . "';";
        } else {
            $query = "SELECT+%2A+FROM+Products+WHERE+productname='" . urlencode($itemDescription) . "';";
        }
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
    public function createProduct($item) {

        $data['productname'] = $item->getDescription();
        $data['xero_id'] = $item->getItemCode();
        $data['qtyinstock'] = $item->getQuantity();
        $data['unit_price'] = $item->getLineAmount();
        $data['assigned_user_id'] = '19x6';
        $data['discontinued'] = '1';
        $params = array("sessionName" => $this->CRMApi->session, "operation" => 'create',
            "element" => json_encode($data), "elementType" => 'Products');
        $response = getResponseFromURL($this->CRMApi->endpointurl, $params);
        $created = json_decode($response);
        return $created;
    }

}
