


# vtlib.scripts

These scripts available in this repo are extended vtlib (App's native library) to perform common tasks such as adding fields, set relation ship for CRM app. 

## How to use

  * Databases : for SQL scripts to do common tasks/changes in vtiger
  * fields : add custom fields
  * set-related-lists : adding related module to a parent module. Example of Related Module is Contact under Organization.
  * register-custom-function : Registering a PHP script as vtiger workflow custom function
    ** CreateInventoryViaAPI.php - The class file which can be used to create Vtiger Inventoyr modules such as Quotes, Invoices and PurchaseOrder through vtiger WebServices
  
   Folder structure  described below  is maintained in the [Migrations](https://github.com/radus28/v71base/tree/master/migrations) folder of the app. This scripts can be executed using browser. Example http://localhost/v72train/migrations/fields/newFields.php


## Contribution notes
* Please use vt7 for write & test scripts
* name meaningfully

Example,  
  * fields -
    * ui5-date
    * ui10-contacts
    * ui10-organizations
* Add required comments in the code
* Add how to use notes under wiki

## VTWS - Vtiger Web service

### File Retrieve

The web services vtws_file_retrieve exist in vtiger core, but not exposed as webservice. Run below sql to expose File retrieve service

``
UPDATE `vtiger_ws_operation_seq` SET `id` = (id+1);

INSERT INTO `vtiger_ws_operation` (`operationid`, `name`, `handler_path`, `handler_method`, `type`, `prelogin`) VALUES ((SELECT id FROM `vtiger_ws_operation_seq`), 'file_retrieve', 'include/Webservices/FileRetrieve.php', 'vtws_file_retrieve', 'GET', '0');

INSERT INTO `vtiger_ws_operation_parameters` (`operationid`, `name`, `type`, `sequence`) VALUES 
((SELECT id FROM `vtiger_ws_operation_seq`), 'file_id', 'String', '1')

``

### References
* https://wiki.vtiger.com/index.php/Vtlib
* https://wiki.vtiger.com/index.php/CodingGuidelines
