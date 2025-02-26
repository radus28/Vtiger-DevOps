# Creating a Custom module
Follow below instructions to create a vtiger custom module programatically 

## Create using CLI

1. Login to CLI

2. Move to Vtiger root directory

3. Run 

``php -f vtlib/tools/console.php``


Further reference https://community.vtiger.com/help/vtigercrm/developers/vtlib/console-tool.html

## Create using script
1. Place the script create-sample.php under migrations/modules folder in vtiger folder
2. Open the script
3. Change variable ``$moduleInformation`` with required values
   1. name : The new module name you want to create
   2. parent : The parent menu item which the new module will be displated. Example "Marketing" or "Sales"
4. Run the script from browser. Example http://YOUR-CRM-URL/migrations/modules/create-sample.php
