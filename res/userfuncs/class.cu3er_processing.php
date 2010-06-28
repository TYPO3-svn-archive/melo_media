<?php

/**
* 
*/
class cu3er_processing
{
	function main($conf,$parent){
		$pages = t3lib_div::trimExplode(",",$conf["context"]["flexform"]["pages"]);
		$conf["context"]["flexform"]["slides"] = array();
		$header = t3lib_div::trimExplode("\n",$conf["context"]["flexform"]["header"]);
		$caption = t3lib_div::trimExplode("\n",$conf["context"]["flexform"]["caption"]);
		$link = t3lib_div::trimExplode("\n",$conf["context"]["flexform"]["link"]);

		$conf["typeConf"]["image."]["width"] = $conf["flexform"]["width"] ? $conf["flexform"]["width"] : $conf["typeConf"]["image."]["width"];
		$conf["typeConf"]["image."]["height"] = $conf["flexform"]["height"] ? $conf["flexform"]["height"] : $conf["typeConf"]["image."]["height"];
		foreach ($pages as $key => $slide) {
			$slide = $parent->cObj->IMG_RESOURCE(array(
				"file" => $slide,
				"file." => array(
					"width" => $conf["typeConf"]["image."]["width"],
					"height" => $conf["typeConf"]["image."]["height"]
				)
			));
			$conf["context"]["flexform"]["slides"][] = array(
				"file" => $conf["basePath"].$slide,
				"header" => $header[$key],
				"caption" => $caption[$key],
				"link" => $parent->cObj->typoLink_URL(array("parameter"=>$link[$key]))
			);
		}
		$conf["context"]["flexform"]["height"] = current(explode("c",$conf["typeConf"]["image."]["height"]));
		$conf["context"]["flexform"]["width"] = current(explode("c",$conf["typeConf"]["image."]["width"]));
		
		$xml = $parent->fluidView(t3lib_div::getFileAbsFileName($conf["typeConf"]["xmltemplate"]),$conf["context"]);
		#echo $xml; exit;
		$md5 = md5($xml);
		$cacheFileName = PATH_site."typo3temp/".$md5.".xml";
		if(!file_exists($cacheFileName)){
			t3lib_div::writeFileToTypo3tempDir($cacheFileName,$xml);
		}
		$conf["context"]["xml"] = $conf["basePath"]."typo3temp/".$md5.".xml";
		return $conf;
	}
}