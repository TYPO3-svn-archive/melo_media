<?php

/**
* 
*/
class flvplayer_processing
{
	function main($conf,$parent){
		$conf["context"]["flexform"]["file"] = str_replace(PATH_site, "", $conf["context"]["flexform"]["file"]);
		$conf["context"]["flexform"]["poster"] = str_replace(PATH_site, "", $conf["context"]["flexform"]["poster"]);
		return $conf;
	}
}