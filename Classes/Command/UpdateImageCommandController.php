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
	 * @param string $imageURLs The URLs of intranet to get image
	 */
	public function updateImageCommand($imageURLs = NULL) {
		$imageURLs = explode(',', $imageURLs);
		foreach($imageURLs as $imageURL) {
			if ($this->checkRemoteFile($imageURL)) {
				$imageName = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tx_juliusbaerstock/' . 'a4.jpg';
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