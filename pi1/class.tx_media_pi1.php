<?php
			/***************************************************************
			*  Copyright notice
			*
			*  (c) 2010 Marc Neuhaus <marc@mneuhaus.com>
			*  All rights reserved
			*
			*  This script is part of the TYPO3 project. The TYPO3 project is
			*  free software; you can redistribute it and/or modify
			*  it under the terms of the GNU General Public License as published by
			*  the Free Software Foundation; either version 2 of the License, or
			*  (at your option) any later version.
			*
			*  The GNU General Public License can be found at
			*  http://www.gnu.org/copyleft/gpl.html.
			*
			*  This script is distributed in the hope that it will be useful,
			*  but WITHOUT ANY WARRANTY; without even the implied warranty of
			*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
			*  GNU General Public License for more details.
			*
			*  This copyright notice MUST APPEAR in all copies of the script!
			***************************************************************/
			/**
 			 * [CLASS/FUNCTION INDEX of SCRIPT]
 			 *
 			 * Hint: use extdeveval to insert/update function index above.
 			 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Multimedia' for the 'media' extension.
 *
 * @author	Marc Neuhaus <marc@mneuhaus.com>
 * @package	TYPO3
 * @subpackage	tx_media
 */
class tx_media_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_media_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_media_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'media';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)	{
		$this->pi_initPIflexForm();
		$conf["type"] = $this->cObj->data["tx_media_type"];
		$conf["typeConf"] = $conf["types."][$conf["type"]."."];
		$conf["flexform"] = $conf["typeConf"]["defaults."];
		$conf["baseUrl"] = $GLOBALS["TSFE"]->tmpl->setup["config."]["baseURL"];
		$conf["host"] = t3lib_div::getHostname();
		$conf["basePath"] = str_replace("http://".$conf["host"],"",$conf["baseUrl"]);
		$conf["basePath"] = str_replace("https://".$conf["host"],"",$conf["basePath"]);
		
		foreach ($this->cObj->data['pi_flexform']["data"]["sDEF"] as $sheet) {
			foreach ($sheet as $field => $value) {
				$conf["flexform"][$field] = !empty($value["vDEF"]) ? $value["vDEF"] : $conf["flexform"][$field];
			}
		}
		
		foreach ($conf["typeConf"]["headerData."] as $key => $value) {
			$GLOBALS['TSFE']->additionalHeaderData["tx_media_pi1".$key] = $value;
		}

		$this->conf = $conf;
		$conf["context"] = array_merge($conf,array_merge($conf["typeConf"]["context."],array("row" => $this->cObj->data )));
		
		if(isset($conf["typeConf"]["userfunc"])){
			$userfunc = t3lib_div::getUserObj($conf["typeConf"]["userfunc"],"");
			$conf = $userfunc->main($conf,$this);
		}

		$output= $this->fluidView($conf["typeConf"]["template"],$conf["context"]);
		if($conf["debug"])
			$output.=  t3lib_div::view_array($conf);
		return $output;
	}
	
	function fluidView($template,$context = array()) {
	    $renderer = t3lib_div::makeInstance('Tx_Fluid_View_TemplateView');
	    $controllerContext = t3lib_div::makeInstance('Tx_Extbase_MVC_Controller_ControllerContext');
	    $controllerContext->setRequest(t3lib_div::makeInstance('Tx_Extbase_MVC_Web_Request'));
	    $renderer->setControllerContext($controllerContext);
			
	    $renderer->setPartialRootPath(t3lib_div::getFileAbsFileName($this->conf["paths."]["partial"]));
	    $renderer->setTemplateRootPath(t3lib_div::getFileAbsFileName($this->conf["paths."]["templates"]));
	    $renderer->setLayoutRootPath(t3lib_div::getFileAbsFileName($this->conf["paths."]["layouts"]));
	    $renderer->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($template));
	    foreach ($context as $key => $value) {
	        $renderer->assign($key,$value);
	    }
	    return $renderer->render();
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/media/pi1/class.tx_media_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/media/pi1/class.tx_media_pi1.php']);
}

?>