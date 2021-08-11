<?php
/**
 * @author Sutharsan J <support@radus28.com>
 * @internal This will add parent and child SETTINGS Table as shown below
 * LBL_TELEPHONY_CONFIGURATION
 *  -- LBL_TELEPHONY_3CX
 * 
 */
$adb = \PearDatabase::getInstance();

$blockLabel = "LBL_TELEPHONY_CONFIGURATION"; // Parent Settings Tabe
$label = "LBL_TELEPHONY_3CX"; // Child Settings tab
$linkTo = "index.php?module=Telephony&parent=Settings&view=Index";
$description = "Telephony settings";

//Get selected block
$block = $adb->pquery("SELECT blockid
                               FROM vtiger_settings_blocks
                               WHERE label=?;", array($blockLabel));
//Get blockid
if ($adb->num_rows($block)) {
    //Block exists
    $blockID = $adb->query_result($block, 0, "blockid");
} else {
    //Block does not exist
    $blockID = $adb->getUniqueID("vtiger_settings_blocks");
    $result = $adb->pquery("SELECT max(sequence) as sequence
                                    FROM vtiger_settings_blocks;", array());
    $sequence = $adb->num_rows($result) ? $adb->query_result($result, 0, "sequence") : 0;

    //Create block
    $adb->pquery(
            "INSERT INTO vtiger_settings_blocks
                 (blockid, label, sequence)
                 VALUES
                 (?,?,?)", array($blockID, $blockLabel, ++$sequence)
    );
}
    