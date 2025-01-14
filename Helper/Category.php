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

namespace Bitpolar\CategoryImgWidget\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Category extends AbstractHelper
{

    /**
     * @return array
     */
    public function getAdditionalImageTypes()
    {
        return array('thumbnail');
    }

    /**
     * Retrieve image URL
     * @param $image
     * @return string
     */
    public function getImageUrl($image)
    {
        $url = false;
        //$image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_urlBuilder->getBaseUrl(
                        ['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

}
