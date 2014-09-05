<?php
namespace DS360\JuliusbaerStock\Command;

	/**
	 * This file is part of the TYPO3 CMS project.
	 *
	 * It is free software; you can redistribute it and/or modify it under
	 * the terms of the GNU General Public License, either version 2
	 * of the License, or any later version.
	 *
	 * For the full copyright and license information, please read the
	 * LICENSE.txt file that was distributed with this source code.
	 *
	 * The TYPO3 project - inspiring people to share!
	 */
/**
 * Additional fields provider class for usage with the Scheduler's test task
 *
 * @author 		François Suter <francois@typo3.org>
 */
class UpdateImageAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {

	/**
	 * @var array
	 */
	protected $additionalFieldsName = array('imageLargeIntradayURL', 'imageLargeMonthURL', 'imageLarge3MonthsURL', 'imageLargeYearURL', 'imageLarge5YearsURL',
		'imageSmallIntradayURL', 'imageSmallMonthURL', 'imageSmall3MonthsURL', 'imageSmallYearURL', 'imageSmall5YearsURL',
		'imageMobileIntradayURL', 'imageMobileMonthURL', 'imageMobile3MonthsURL', 'imageMobileYearURL', 'imageMobile5YearsURL'
	);

	/**
	 * This method is used to define new fields for adding or editing a task
	 * In this case, it adds an email field
	 *
	 * @param array $taskInfo Reference to the array containing the info used in the add/edit form
	 * @param object $task When editing, reference to the current task object. Null when adding.
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
	 * @return array	Array containing all the information pertaining to the additional fields
	 */
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
		$additionalFields = array();
		foreach ($this->additionalFieldsName as $additionalFieldName) {
			if (empty($taskInfo[$additionalFieldName])) {
				if ($parentObject->CMD == 'add') {
					// In case of new task and if field is empty, set default email address
					$taskInfo[$additionalFieldName] = '';
				} elseif ($parentObject->CMD == 'edit') {
					// In case of edit, and editing a test task, set to internal value if not data was submitted already
					$taskInfo[$additionalFieldName] = $task->$additionalFieldName;
				} else {
					// Otherwise set an empty value, as it will not be used anyway
					$taskInfo[$additionalFieldName] = '';
				}
			}

			// Write the code for the field
			$fieldID = 'task_' . $additionalFieldName;
			$fieldCode = '<input type="text" name="tx_scheduler['. $additionalFieldName .']" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo[$additionalFieldName]) . '" size="55" />';
			$additionalFields[$fieldID] = array(
				'code' => $fieldCode,
				'label' => 'LLL:EXT:juliusbaer_stock/Resources/Private/Language/locallang.xlf:tx_juliusbaerstock_label.' . $additionalFieldName,
				'cshKey' => '_MOD_system_txschedulerM1',
				'cshLabel' => $fieldID
			);
		}
		return $additionalFields;
	}

	/**
	 * This method checks any additional data that is relevant to the specific task
	 * If the task class is not relevant, the method is expected to return TRUE
	 *
	 * @param array	 $submittedData Reference to the array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
	 * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
		return TRUE;
	}

	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches
	 *
	 * @param array $submittedData Array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the current task object
	 * @return void
	 */
	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		foreach ($this->additionalFieldsName as $additionalFieldName) {
			$task->$additionalFieldName = $submittedData[$additionalFieldName];
		}
	}
}
