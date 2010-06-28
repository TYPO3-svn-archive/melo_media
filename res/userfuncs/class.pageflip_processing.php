<?php

/**
* 
*/
class pageflip_processing
{
    protected $debug = true;
	function main($conf,$parent){
		$pages = t3lib_div::trimExplode(",",$conf["context"]["flexform"]["pages"]);
		$conf["context"]["flexform"]["pages"] = array();
        #$pathSite = str_replace("typo3conf/ext/media/res/userfuncs/","",dirname(__FILE__));
		foreach ($pages as $page) {
            $page = str_replace(PATH_site, "", $page);
            #$page = str_replace("typo3conf/ext/media/res/userfuncs/","",$page);
			$thumb = $parent->cObj->IMG_RESOURCE(array(
				"file" => $page,
				"file." => $conf["typeConf"]["sizes."]["thumbnail."]
			));
			$normal= $parent->cObj->IMG_RESOURCE(array(
				"file" => $page,
				"file." => $conf["typeConf"]["sizes."]["normal."]
			));
			$conf["context"]["flexform"]["pages"][] = array(
				"thumb" => str_replace(PATH_site, "", $thumb),
				"normal" => str_replace(PATH_site, "", $normal),
				"large" => str_replace(PATH_site, "", $page)
			);
		}
		$xml = $parent->fluidView(t3lib_div::getFileAbsFileName($conf["typeConf"]["xmltemplate"]),$conf["context"]);
		#echo $xml; exit;
        $salt = "mySalt";
		$md5 = md5($xml.$salt);
		$cacheFileName = PATH_site."typo3temp/".$md5.".xml";
		if(!file_exists($cacheFileName)){
			t3lib_div::writeFileToTypo3tempDir($cacheFileName,$xml);
		}
		$conf["context"]["xml"] = "typo3temp/".$md5.".xml";
		return $conf;
	}
}