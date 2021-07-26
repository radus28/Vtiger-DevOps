<?php

/**
 * @author  sutharsan@nulosoft
 * Creating Host portal contact
 */
function createPortalContact ($entity)
{
    global $adb;
    $entity_data = get_object_vars ($entity);
    $data = $entity_data['data'];

    $id = explode ('x', $data['id']);
    $startDate = date ('d-m-Y', time());
    $endDate = date ("d-m-Y", (time() + 157680000));// Portal enabled for 5 years
//    echo '<pre>';var_dump($endDate);exit;
    $record = Vtiger_Record_Model::getCleanInstance ('Contacts');
    $record->set ('firstname', 'Agent Portal ');
    $record->set ('lastname', 'Portal contact for '.$data['agents_name']);
    $record->set ('email', $data['email']);
    $record->set ('portal', 1);
    $record->set ('support_start_date', $startDate);
    $record->set ('support_end_date', $endDate);

    $record->set ('au_contacttype', 'Agent');
    $record->set ('au_agent', $id[1]);
    $record->save ();
}
?>
