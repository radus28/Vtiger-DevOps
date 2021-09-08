## How to add RelatedTab in Detail view

* Open or Extend method `getDetailViewRalatedLinks()` from module/Vtiger/DetailView.php 
* Add an entry as shown below

		$relatedLinks[] = array(
				'linktype' => 'DETAILVIEWTAB',
				'linklabel' => vtranslate('LBL_YOUR-TAB-NAME', $moduleName),
				'linkKey' => 'LBL_RECORD_YOUR-TAB-NAME',
				'linkurl' => str_replace('view=Detail','view=YOUR-TAB-NAME',$recordModel->getDetailViewUrl()).'&mode=showDetailViewByMode&requestMode=summary',
				'linkicon' => ''
		);
