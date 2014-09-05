<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DS360.' . $_EXTKEY,
	'Juliusbaerstock',
	array(
		'Stock' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Stock' => 'list',
		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DS360\\JuliusbaerStock\\Command\\UpdateImageCommandController'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:update_image_stock.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:update_image_stock.description',
	'additionalFields' => 'DS360\\JuliusbaerStock\\Command\\UpdateImageAdditionalFieldProvider'
);