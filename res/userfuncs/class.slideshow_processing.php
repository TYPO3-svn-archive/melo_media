<?php

/**
* 
*/
class slideshow_processing
{
	function main($conf,$parent){
		$images = t3lib_div::trimExplode(",",$conf["flexform"]["images"]);
		$conf["context"]["flexform"]["images"] = array();
		$captions = t3lib_div::trimExplode("\n",$conf["flexform"]["caption"]);
		$links = t3lib_div::trimExplode("\n",$conf["flexform"]["link"]);
		
		$conf["typeConf"]["image."]["width"] = $conf["flexform"]["width"] ? $conf["flexform"]["width"] : $conf["typeConf"]["image."]["width"];
		$conf["typeConf"]["image."]["height"] = $conf["flexform"]["height"] ? $conf["flexform"]["height"] : $conf["typeConf"]["image."]["height"];
		
		$conf["flexform"]["images"] = array();
		foreach ($images as $key => $image) {
			$image = $parent->cObj->IMG_RESOURCE(array(
				"file" => $image,
				"file." => $conf["typeConf"]["image."]
			));
			$conf["flexform"]["images"][] = array(
				"file" => $image,
				"caption" => $captions[$key],
				"link" => $links[$key]
			);
		}
#		print_r($conf["flexform"]);
		$conf["context"] = $conf;
		return $conf;
	}
}