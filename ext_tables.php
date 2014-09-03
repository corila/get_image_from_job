<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Juliusbaer Stock Information');
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Juliusbaerstock',
	'Juliusbaer Stock Information'
);

$stockPluginSignature = strtolower($extensionName) . '_juliusbaerstock';

\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$stockPluginSignature] = 'layout,recursive,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$stockPluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($stockPluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_stock.xml');
