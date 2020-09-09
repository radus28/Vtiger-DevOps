# Vtiger Development

## Creating custom module
[How to create a basic module](https://drive.google.com/file/d/1kPZgr2-8RYTls0Jug9AmKYejZKBokO4w/view?usp=sharing)

### Adding fields to module
[How to add a custom field](https://drive.google.com/file/d/1hoAOF8rXYhHw_WeftzqwqL4jF_YIulsq/view?usp=sharing)

[How to add a custom picklist field](https://drive.google.com/file/d/1Rss3dS017HD_0N-Nbu7lLwi5_MKWLI7A/view?usp=sharing)

### Set Related module (Related Tab) to a module
[How to add a Related Modules](https://drive.google.com/file/d/1CBvD-f4bWTIUvCWUrhg5AnCrrOfpb9ze/view?usp=sharing)

## Workflows
Create workflows :  Settings > Automation > Workflows,  Choose module, then click "Add Workflow" button
### Update fields
[How to add a workflow - Update field](https://drive.google.com/file/d/13R3TJDuqfn4kKl0-bpwXt7x7RW4QJHiM/view?usp=sharing)

### Send email
[How to add a Workflow - Send email](https://drive.google.com/file/d/11VUR5o1IauQcrV47S6I-k3EZtP25WeJw/view?usp=sharing)

### Create Entity
// update content
### Custom function
Use below script to register a custom function
https://github.com/radus28/vt.training/tree/master/register-customfunctions

// update content


# vtlib.scripts
Using vtlib library for common tasks such as add fields, set relation ship for vtiger crm

## How to use
 Folder structure described below
  * Databases : for SQL scripts to do common tasks/changes in vtiger
  * fields : add custom fields
  * set-related-lists : adding related module to a parent module
  * register-custom-function : Registering a PHP script as vtiger workflow custom function


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
