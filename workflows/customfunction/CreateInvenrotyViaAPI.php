<?php

/**
 * @author Sutharsan J
 * @internal Class to create Inventory Records such as Quotes, SalesOrder, Invoice and PurchaseOrder Module
 */
require_once('vtiger/curl.func.php');

class CRMInvoice
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
     * @author Sutharsan J
     * @internal Create an inventory data
     * @param array $inventoryData
     */
    public function createInvoiceRecordViaAPI($inventoryData,$module)
    {
        $invoiceResult=[];
        if (isset($inventoryData['id'])) {
            $invoiceResult = $this->getInventoryByField('id', $inventoryData['id']);
        }
        if (isset($invoiceResult['result'][0])) {
            $crmInvoiceData = $invoiceResult['result'][0];
        } else {
            $crmInvoiceData = array(
                'hdnDiscountAmount' => '0',
                "ship_street" => '-',
                "bill_street" => '-',
                'balance' => 0,
                'hdnS_H_Amount' => 0,
                'received' => 0,
            );
        }
        $statusField ='';
        $dateField ='';
        switch ($module)
        {
            case 'Invoice':
                $statusField='invoicestatus';
                $dateField='invoicedate';
        }
        /**
         * Preparing invoice date
         */
        $invoiceDate = (array) $xeroInvoice[0]->getDateAsDate();
        $invoiceDate = (isset($inventoryData[$dateField]) && $inventoryData[$dateField]!='') ?$inventoryData[$dateField] : array(date('d-m-Y', time()));

        $dueDate = (array) $xeroInvoice[0]->getDueDateAsDate();
        $dueDate =  (isset($inventoryData['duedate']) && $inventoryData['duedate']!='') ?$inventoryData['duedate']: array(date('d-m-Y', time()));
        foreach($inventoryData as $fieldName=>$fieldValue){
            if(isset($crmInvoiceData [$fieldName] ))
            {
                $crmInvoiceData [$fieldName] =$fieldValue;
            }
        }
       
//        $crmInvoiceData ['subject'] = $inventoryData['subject'];
//        $crmInvoiceData ['account_id'] = $inventoryData['account_id'];
//        $crmInvoiceData ['sostatus'] = 'Created';
//        $crmInvoiceData [$statusField] = 'Created';
//        $crmInvoiceData ['currency_id'] = '21x1';
//        $crmInvoiceData ['hdnTaxType'] = 'group';
//        $crmInvoiceData ['tax1'] = '0.000';
//        $crmInvoiceData ['tax2'] = '10.000';
//        $crmInvoiceData ['tax3'] = '0.000';
//        $crmInvoiceData ['tax2_percentage'] = '10';
//        $crmInvoiceData ['region_id'] = '1';
//        $crmInvoiceData ['productid'] = $productData[0]['productid'];
//        $crmInvoiceData [$dateField] = $invoiceDate[0]; //date('d-m-Y', strtotime($invoiceDate[0]));
//        $crmInvoiceData ['duedate'] = $dueDate[0]; //date('d-m-Y', strtotime($dueDate[0]));
//        $crmInvoiceData['hdnGrandTotal'] = $xeroInvoice[0]->getTotal();
//        $crmInvoiceData ['LineItems'] = $productData;
        
        $processedInvoice = $this->createInventory($crmInvoiceData,$module);
    }

    /**
     * Returns CRM Organization by given XeroId
     * @param type $xeroId
     * @return boolean
     */
    public function getInventoryByField($fieldName, $fieldValue, $module)
    {

        $query = "SELECT+%2A+FROM+" . $module . "+WHERE+" . $fieldName . "='" . $fieldValue . "';";
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
    public function createInventory($crmInvoiceData, $module)
    {
        $crmInvoiceData['assigned_user_id'] = '19x6';
        $method = 'create';
        if ((isset($crmInvoiceData['id']))) {
            $method = 'update';
        }
        $params = array("sessionName" => $this->CRMApi->session, "operation" => $method,
            "element" => json_encode($crmInvoiceData), "elementType" => $module);
        $response = getResponseFromURL($this->CRMApi->endpointurl, $params);
        $processed = json_decode($response);
        return $processed;
    }

}
