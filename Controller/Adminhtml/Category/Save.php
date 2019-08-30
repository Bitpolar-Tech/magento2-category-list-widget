<?php
/**
 * Bitpolar Technologies
 *
 ********************************************************************
 *
 * @category   Bitpolar
 * @package    Bitpolar_CategoryImgWidget
 * @author     Stefan Euchenhofer (info@bitpolar.de)
 * @copyright  Copyright (c) 2019 Bitpolar Technologies (https://www.bitpolar.de)
 */

namespace Bitpolar\CategoryImgWidget\Controller\Adminhtml\Category;
class Save extends \Magento\Catalog\Controller\Adminhtml\Category\Save
{
    /**
     * @return array
     */
    protected function getAdditionalImages() {
        return array('thumbnail');
    }
    /**
     * Image data preprocessing
     *
     * @param array $data
     *
     * @return array
     */
    public function imagePreprocessing($data)
    {
        foreach ($this->getAdditionalImages() as $imageType) {
            if (empty($data[$imageType])) {
                unset($data[$imageType]);
                $data[$imageType]['delete'] = true;
            }
        }
        return parent::imagePreprocessing($data);
    }
    /**
     * Filter category data
     *
     * @param array $rawData
     * @return array
     */
    protected function _filterCategoryPostData(array $rawData)
    {
        $data = $rawData;
        /**
         * a workaround for adding extra image fields to category form
         */
        foreach ($this->getAdditionalImages() as $imageType) {
            if (isset($data[$imageType]) && is_array($data[$imageType])) {
                if (!empty($data[$imageType]['delete'])) {
                    $data[$imageType] = null;
                } else {
                    if (isset($data[$imageType][0]['name']) && isset($data[$imageType][0]['tmp_name'])) {
                        $data[$imageType] = $data[$imageType][0]['name'];
                    } else {
                        unset($data[$imageType]);
                    }
                }
            }
        }
        return parent::_filterCategoryPostData($data);
    }
}
