<?php
namespace DS360\JuliusbaerStock\Controller;


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

/**
 * StockController
 */
class StockController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$imageDimensions = array('width' => $this->settings['imageDimensions']['width'][$this->settings['imageSize']],
								'height' => $this->settings['imageDimensions']['height'][$this->settings['imageSize']]);
		$this->view->assign('images', $this->getImagesPart());
		$this->view->assign('imageDimensions', $imageDimensions);
	}

	private function getImagesPart() {
		$images = $this->settings['ImagesName'];
		foreach ($images as $key => $image) {
			$realName = str_replace('###size###', '-' .$this->settings['imageSize'] . '-', $image['name']);
			$imagePath = $this->settings['imagePath'] . $realName;
			if (file_exists($imagePath)) {
				$images[$key]['name'] = htmlspecialchars_decode($imagePath);
			} else {
				$images[$key]['name'] = 0;
			}
		}
		return $images;
	}


}