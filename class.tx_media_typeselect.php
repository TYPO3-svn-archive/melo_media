<?php
require_once (PATH_t3lib."class.t3lib_page.php");
require_once (PATH_t3lib."class.t3lib_tstemplate.php");
require_once (PATH_t3lib."class.t3lib_tsparser_ext.php");

class tx_media_typeselect {
	
	function getTypes ($config) {
		$setup = $this->getPageSetup($config["row"]["pid"]);
		foreach ($setup["plugin."]["tx_media_pi1."]["types."] as $key => $value) {
			$conf = $setup["plugin."]["tx_media_pi1."]["types."][$key];
			$key = trim($key,".");
			
			$config["items"][] = array($conf["name"],$key);
		}
		
		return $config;
	}
	
	function getPageSetup($pageId){
		$template = t3lib_div::makeInstance("t3lib_tsparser_ext");
		$template->tt_track = 0;
		$template->init();
		$sys_page = t3lib_div::makeInstance("t3lib_pageSelect");
		$rootLine = $sys_page->getRootLine($pageId);
		// This generates the constants/config + hierarchy info for the template.
		$template->runThroughTemplates($rootLine);
		$template->generateConfig();
		return $template->setup;
	}
	
	function getFlexFormDS_postProcessDS(&$dataStructArray, $conf, $row, $table, $fieldName){
		if(empty($row["tx_media_type"])) return;
		if($GLOBALS["tx_media_getFlexFormDS_postProcessDS"]) return;
		
		$setup = $this->getPageSetup($row["pid"]);
		foreach ($setup["plugin."]["tx_media_pi1."]["types."] as $key => $value) {
			$conf = $setup["plugin."]["tx_media_pi1."]["types."][$key];
			$key = trim($key,".");
			if(substr($conf["flexform"],0,5)!=="FILE:")
				$conf["flexform"] = "FILE:".$conf["flexform"];
			$GLOBALS['TCA'][$table]['columns']["pi_flexform"]['config']["ds"][$key.",media_pi1"] = $conf["flexform"];
		}
		$GLOBALS['TCA'][$table]['columns']["pi_flexform"]['config']["ds_pointerField"] = "tx_media_type,CType";
		$conf = $GLOBALS['TCA'][$table]['columns']["pi_flexform"]['config'];
		
		$GLOBALS["tx_media_getFlexFormDS_postProcessDS"] = true;
		$dataStructArray = t3lib_BEfunc::getFlexFormDS($conf, $row, $table,'');
		$GLOBALS["tx_media_getFlexFormDS_postProcessDS"] = false;

#		echo "<pre>";
#		print_r($conf);
#		print_r($dataStructArray);
#		print_R(debug_backtrace());
#		exit;
	}
}

?>