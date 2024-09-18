SELECT mb.id,mb.crmid,mb.module, mb.changedon, md.fieldname, md.prevalue AS lastvalue, md.postvalue AS newvalue,
 u.user_name,CONCAT (u.first_name, " ",u.last_name) AS Changedby,
ce.label,   
mr.targetmodule AS relatedmodule,mr.targetid AS related_crmid
FROM `vtiger_modtracker_basic` mb 
INNER JOIN vtiger_crmentity ce ON ce.crmid = mb.crmid 
LEFT JOIN vtiger_users u ON u.id = mb.whodid
LEFT JOIN vtiger_modtracker_relations mr ON mb.id = mr.id 
LEFT JOIN vtiger_modtracker_detail md ON mb.id = md.id 
