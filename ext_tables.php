<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = 'CType;;4;button;1-1-1, header;;3;;2-2-2';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:media/locallang_db.xml:tt_content.CType_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'CType');

include_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_media_typeselect.php');

// checkbox
$tempColumns = Array (
	"tx_media_type" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:media/locallang_db.xml:tt_content.tx_media_type",
		"config" => Array (
			"type" => "select",
			"itemsProcFunc" => "tx_media_typeselect->getTypes"
		)
	),
);


t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);

$GLOBALS['TCA']['tt_content']['types']['media_pi1']["showitem"] = "CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;3-3-3,--div--;LLL:EXT:media/locallang_db.xml:pages.tabs.media, tx_media_type, pi_flexform;LLL:EXT:media/locallang_db.xml:pages.tabs.media, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime";
$GLOBALS['TCA']['tt_content']['types']['media_pi1']["subtype_value_field"] = "tx_media_type";
$GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] = $GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] ? $GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] . ',tx_media_type' : 'tx_media_type';
// Flexforms
#$GLOBALS['TCA']['tt_content']['types']['media_pi1']['subtypes_addlist']["flvplayer"]='pi_flexform';
#t3lib_extMgm::addPiFlexFormValue('flvplayer', 'FILE:EXT:'.$_EXTKEY.'/res/flexforms/flvplayer.xml');
?>