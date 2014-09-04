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

class UpdateImageCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @param string $imageLargeIntradayURL Image Large for Intraday URL:
	 * @param string $imageLargeMonthURL Image Large for a Month URL:
	 * @param string $imageLarge3MonthsURL Image Large for 3 Months URL:
	 * @param string $imageLargeYearURL Image Large for a Year URL :
	 * @param string $imageLarge5YearsURL Image Large for 5 Years URL :
	 * @param string $imageSmallIntradayURL Image Small for Intra day URL :
	 * @param string $imageSmallMonthURL Image Small for a Month URL :
	 * @param string $imageSmall3MonthsURL Image Small for 3 Months URL:
	 * @param string $imageSmallYearURL Image Small for a Year URL :
	 * @param string $imageSmall5YearsURL Image Small for 5 Years URL :
	 * @param string $imageMobileIntradayURL Image Mobile for Intraday URL :
	 * @param string $imageMobileMonthURL Image Mobile for a Month URL :
	 * @param string $imageMobile3MonthsURL Image Mobile for 3 Months URL :
	 * @param string $imageMobileYearURL Image Mobile for a Year URL :
	 * @param string $imageMobile5YearsURL Image Mobile for 5 Years URL :
	 */
	public function updateImageCommand($imageLargeIntradayURL = NULL, $imageLargeMonthURL = NULL, $imageLarge3MonthsURL = NULL, $imageLargeYearURL = NULL, $imageLarge5YearsURL = NULL,
									   $imageSmallIntradayURL = NULL, $imageSmallMonthURL = NULL, $imageSmall3MonthsURL = NULL, $imageSmallYearURL = NULL, $imageSmall5YearsURL = NULL,
									   $imageMobileIntradayURL = NULL, $imageMobileMonthURL = NULL, $imageMobile3MonthsURL = NULL, $imageMobileYearURL = NULL, $imageMobile5YearsURL = NULL) {
		$imageURLs = array(
			'Chart-Large-Intraday' => $imageLargeIntradayURL,
			'Chart-Large-Month' => $imageLargeMonthURL,
			'Chart-Large-3-Months' => $imageLarge3MonthsURL,
			'Chart-Large-Year' => $imageLargeYearURL,
			'Chart-Large-5-Years' => $imageLarge5YearsURL,
			'Chart-Small-Intraday' => $imageSmallIntradayURL,
			'Chart-Small-Month' => $imageSmallMonthURL,
			'Chart-Small-3-Months' => $imageSmall3MonthsURL,
			'Chart-Small-Year' => $imageSmallYearURL,
			'Chart-Small-5-Years' => $imageSmall5YearsURL,
			'Chart-Mobile-Intraday' => $imageMobileIntradayURL,
			'Chart-Mobile-Month' => $imageMobileMonthURL,
			'Chart-Mobile-3-Months' => $imageMobile3MonthsURL,
			'Chart-Mobile-Year' => $imageMobileYearURL,
			'Chart-Mobile-5-Years' => $imageMobile5YearsURL
		);
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