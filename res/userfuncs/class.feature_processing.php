<?php

/**
* 
*/
class feature_processing
{
	function main($conf,$parent){
		$imgc = array(
			"file" => $conf["flexform"]["image"],
			"file." => $conf["typeConf"]["image."]
		);
		$conf["flexform"]["image"] = $parent->cObj->IMG_RESOURCE($imgc);
		$conf["flexform"]["text"] = explode("<placeholder>",$conf["flexform"]["text"]);
		$conf["context"] = $conf;
		return $conf;
	}
}