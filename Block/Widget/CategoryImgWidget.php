<?php
namespace Bitpolar\CategoryImgWidget\Block\Widget;

class CategoryImgWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/categoryimgwidget.phtml';

    const DEFAULT_IMAGE_WIDTH = 250;
    const DEFAULT_IMAGE_HEIGHT = 250;

    /**
     * \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    protected $_categoryFactory;

    /**
     * \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * @var Product
     */
    protected $_category = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Bitpolar\CategoryImgWidget\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Bitpolar\CategoryImgWidget\Helper\Category $categoryHelper
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Catalog\Model\CategoryFactory $categoryFactory,
    \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
    \Magento\Framework\Registry $registry,
    \Bitpolar\CategoryImgWidget\Helper\Category $categoryHelper,
    array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_coreRegistry = $registry;
        $this->_categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current store categories
     *
     * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
     */
    public function getCategoryCollection()
    {
        $category = $this->_categoryFactory->create();

        if ($this->getData('childrencat')) {
            $categoryIds = array_map('trim',explode(',', $this->getData('childrencat')));
            $childCategories = $this->_categoryCollectionFactory->create();
            $childCategories->addAttributeToFilter('entity_id', ['in' => $categoryIds]);
        }
        else {
            if ($this->getData('parentcat') > 0) {
                $rootCatID = $this->getData('parentcat');
            } else {
                $rootCatID = $this->_storeManager->getStore()->getRootCategoryId();
            }
            $category->load($rootCatID);
            $childCategories = $category->getChildrenCategories();
        }

        $childCategories
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToSelect(['name', 'image', 'thumbnail'])
            ->setOrder('position','ASC');

        if($this->getMenuOnly()) {
            $childCategories->addAttributeToFilter('include_in_menu', 1);
        }

        return $childCategories;
    }

    private function getMenuOnly()
    {
        if (empty($this->getData('menu_only'))) {
            return true;
        }
        return $this->getData('menu_only') === '1';
    }

    /**
     * Get the width of product image
     * @return int
     */
    public function getImageWidth()
    {
        if (empty($this->getData('imagewidth'))) {
            return self::DEFAULT_IMAGE_WIDTH;
        }
        return (int) $this->getData('imagewidth');
    }

    /**
     * Get the height of product image
     * @return int
     */
    public function getImageHeight()
    {
        if (empty($this->getData('imageheight'))) {
            return self::DEFAULT_IMAGE_HEIGHT;
        }
        return (int) $this->getData('imageheight');
    }


    /**
     * Get the url of the category thumbnail image
     *
     * @return string
     */
    public function getThumbnailUrl()
    {

        $imageCode = $this->hasImageCode() ? $this->getImageCode() : 'image';

        // $image = $this->getCurrentCategory()->getData($imageCode);
        $data = $this->getData();

        // return $this->_categoryHelper->getImageUrl($image);
        return $data;
    }


    public function canShowCatImage()
    {
        return in_array($this->getData('display'), ['cat-image', 'cat-image-name']);
    }

    public function canShowThumbnail()
    {
        return in_array($this->getData('display'), ['thumbnail', 'thumbnail-name']);
    }

    public function canShowName()
    {
        return in_array($this->getData('display'), ['name', 'thumbnail-name', 'cat-image-name']);
    }
}
