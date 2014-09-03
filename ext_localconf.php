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
