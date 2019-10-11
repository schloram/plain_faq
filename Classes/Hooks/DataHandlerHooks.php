<?php
declare(strict_types = 1);
namespace Derhansen\PlainFaq\Hooks;

/*
 * This file is part of the Extension "plain_faq" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hooks for DataHandler
 */
class DataHandlerHooks
{
    /**
     * Checks if the fields defined in $checkFields are set in the data-array of pi_flexform.
     * If a field is present and contains an empty value, the field is unset.
     *
     * Structure of the checkFields array:
     *
     * array('sheet' => array('field1', 'field2'));
     *
     * @param string $status
     * @param string $table
     * @param string $id
     * @param array $fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $reference
     *
     * @return void
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$reference)
    {
        if ($table === 'tt_content' && $status == 'update' && isset($fieldArray['pi_flexform'])) {
            $checkFields = [
                'sDEF' => [
                    'settings.orderField',
                    'settings.orderDirection',
                    'settings.categories',
                    'settings.includeSubcategories',
                    'settings.storagePage',
                    'settings.recursive',
                ],
                'additional' => [
                    'settings.detailPid',
                    'settings.listPid',
                ],
                'template' => [
                    'settings.templateLayout'
                ]
            ];

            $flexformData = GeneralUtility::xml2array($fieldArray['pi_flexform']);
            foreach ($checkFields as $sheet => $fields) {
                foreach ($fields as $field) {
                    if (isset($flexformData['data'][$sheet]['lDEF'][$field]['vDEF']) &&
                        $flexformData['data'][$sheet]['lDEF'][$field]['vDEF'] === ''
                    ) {
                        unset($flexformData['data'][$sheet]['lDEF'][$field]);
                    }
                }

                // If remaining sheet does not contain fields, then remove the sheet
                if (isset($flexformData['data'][$sheet]['lDEF']) && $flexformData['data'][$sheet]['lDEF'] === []) {
                    unset($flexformData['data'][$sheet]);
                }
            }

            /** @var \TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools $flexFormTools */
            $flexFormTools = GeneralUtility::makeInstance(FlexFormTools::class);
            $fieldArray['pi_flexform'] = $flexFormTools->flexArray2Xml($flexformData, true);
        }
    }
}