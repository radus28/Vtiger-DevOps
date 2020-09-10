


# vtlib.scripts

These scripts available in this repo are extended vtlib (App's native library) to perform common tasks such as adding fields, set relation ship for CRM app. 

## How to use

  * Databases : for SQL scripts to do common tasks/changes in vtiger
  * fields : add custom fields
  * set-related-lists : adding related module to a parent module
  * register-custom-function : Registering a PHP script as vtiger workflow custom function
  
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

### References
* https://wiki.vtiger.com/index.php/Vtlib
* https://wiki.vtiger.com/index.php/CodingGuidelines
