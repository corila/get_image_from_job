<?php
namespace DS360\JuliusbaerStock\Command;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 DS360
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

class UpdateImageCommandController extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	/**
	 * @var string $imageLargeIntradayURL
	 */
	public $imageLargeIntradayURL;

	/**
	 * @var string $imageLargeMonthURL
	 */
	public $imageLargeMonthURL;
	/**
	 * @var string $imageLarge3MonthsURL
	 */
	public $imageLarge3MonthsURL;
	/**
	 * @var string $imageLargeYearURL
	 */
	public $imageLargeYearURL;
	/**
	 * @var string $imageLarge5YearsURL
	 */
	public $imageLarge5YearsURL;
	/**
	 * @var string $imageSmallIntradayURL
	 */
	public $imageSmallIntradayURL;
	/**
	 * @var string $imageSmallMonthURL
	 */
	public $imageSmallMonthURL;
	/**
	 * @var string $imageSmall3MonthsURL
	 */
	public $imageSmall3MonthsURL;
	/**
	 * @var string $imageSmallYearURL
	 */
	public $imageSmallYearURL;
	/**
	 * @var string $imageSmall5YearsURL
	 */
	public $imageSmall5YearsURL;
	/**
	 * @var string $imageMobileIntradayURL
	 */
	public $imageMobileIntradayURL;
	/**
	 * @var string $imageMobileMonthURL
	 */
	public $imageMobileMonthURL;
	/**
	 * @var string $imageMobile3MonthsURL
	 */
	public $imageMobile3MonthsURL;
	/**
	 * @var string $imageMobileYearURL
	 */
	public $imageMobileYearURL;
	/**
	 * @var string $imageMobile5YearsURL
	 */
	public $imageMobile5YearsURL;


	/**
	 * Function executed from the Scheduler.
	 * Sends an email
	 *
	 * @return boolean
	 */
	public function execute() {
		$imageURLs = array(
			'Chart-Large-Intraday' => $this->imageLargeIntradayURL,
			'Chart-Large-Month' => $this->imageLargeMonthURL,
			'Chart-Large-3-Months' => $this->imageLarge3MonthsURL,
			'Chart-Large-Year' => $this->imageLargeYearURL,
			'Chart-Large-5-Years' => $this->imageLarge5YearsURL,
			'Chart-Small-Intraday' => $this->imageSmallIntradayURL,
			'Chart-Small-Month' => $this->imageSmallMonthURL,
			'Chart-Small-3-Months' => $this->imageSmall3MonthsURL,
			'Chart-Small-Year' => $this->imageSmallYearURL,
			'Chart-Small-5-Years' => $this->imageSmall5YearsURL,
			'Chart-Mobile-Intraday' => $this->imageMobileIntradayURL,
			'Chart-Mobile-Month' => $this->imageMobileMonthURL,
			'Chart-Mobile-3-Months' => $this->imageMobile3MonthsURL,
			'Chart-Mobile-Year' => $this->imageMobileYearURL,
			'Chart-Mobile-5-Years' => $this->imageMobile5YearsURL
		);
		$this->updateImageCommand($imageURLs);
		return TRUE;
	}

	/**
	 * This method returns the destination mail address as additional information
	 *
	 * @return string Information to display
	 */
	public function getAdditionalInformation() {
		return $GLOBALS['LANG']->sL('LLL:EXT:juliusbaer_stock/Resources/Private/Language/locallang.xlf:update_image_stock.description');
	}

	private function updateImageCommand($imageURLs = array()) {
		foreach($imageURLs as $imageName => $imageURL) {
			if ($this->checkRemoteFile($imageURL)) {
				$imageName = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tx_juliusbaerstock/' . $imageName . '.gif';
				if (ini_get('allow_url_fopen')) {
					file_put_contents($imageName, file_get_contents($imageURL));
				} else {
					$ch = curl_init($imageURL);
					$fp = fopen($imageName, 'wb');
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
				}
			}
		}
	}

	/**
	 * Check if image from remote url have or not
	 *
	 * @param $url
	 *
	 * @return bool
	 */
	private function checkRemoteFile($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(curl_exec($ch)!==FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}