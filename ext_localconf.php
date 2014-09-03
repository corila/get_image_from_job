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

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DS360\JuliusbaerStock\Command\UpdateImageCommandController';