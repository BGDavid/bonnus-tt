<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block;

use Unicodesystems\Bannerslider\Model\Slider as SliderModel;
use Unicodesystems\Bannerslider\Model\Status;

/**
 * Bannerslider Block
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Bannerslider extends \Magento\Framework\View\Element\Template
{
    /**
     * banner slider template
     * @var string
     */
    protected $_template = 'Unicodesystems_Bannerslider::bannerslider.phtml';

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider collecion factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magento\Framework\Registry                                     $coreRegistry
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Catalog\Model\CategoryFactory                          $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(
            SliderModel::XML_CONFIG_BANNERSLIDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        )
        ) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setCategoryPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $category = $this->_coreRegistry->registry('current_category');
        if ($category != null) {
            $categoryPathIds = $category->getPathIds();
    
            foreach ($sliderCollection as $slider) {
                $sliderCategoryIds = explode(',', $slider->getCategoryIds());
                if (!empty(array_intersect($categoryPathIds, $sliderCategoryIds))) {
                    $this->append(
                        $this->getLayout()->createBlock(
                            \Unicodesystems\Bannerslider\Block\SliderItem::class
                        )->setSliderId($slider->getId())
                    );
                }
            }
        }
        return $this;
    }

    /**
     * add child block slider.
     *
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection [description]
     *
     * @return \Unicodesystems\Bannerslider\Block\Bannerslider [description]
     */
    public function appendChildBlockSliders(
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection
    ) {
        foreach ($sliderCollection as $slider) {
            $this->append(
                $this->getLayout()->createBlock(
                    \Unicodesystems\Bannerslider\Block\SliderItem::class
                )->setSliderId($slider->getId())
            );
        }

        return $this;
    }
}
