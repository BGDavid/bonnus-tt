<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Model;

/**
 * Slider Model
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Slider extends \Magento\Framework\Model\AbstractModel
{
    const XML_CONFIG_BANNERSLIDER = 'bannerslider/general/enable_frontend';

    /**
     * Allow to show title or not.
     */
    const SHOW_TITLE_YES = 1;
    const SHOW_TITLE_NO = 2;

    /**
     * style custom content.
     */
    const STYLE_CONTENT_YES = 1;
    const STYLE_CONTENT_NO = 2;

    /**
     * sort type of banners in a slider.
     */
    const SORT_TYPE_RANDOM = 1;
    const SORT_TYPE_ORDERLY = 2;
    /**
     * popup.
     */
    const STYLESLIDE_POPUP = 5;
    /**
     * flexslider.
     */
    const STYLESLIDE_FLEXSLIDER_ONE = 7;
    const STYLESLIDE_FLEXSLIDER_TWO = 8;
    const STYLESLIDE_FLEXSLIDER_THREE = 9;

    /**
     * position code of note slider.
     */
    const NOTE_POSITION_TOP_LEFT = 'top-left';
    const NOTE_POSITION_MIDDLE_TOP = 'middle-top';
    const NOTE_POSITION_TOP_RIGHT = 'top-right';
    const NOTE_POSITION_MIDDLE_LEFT = 'middle-left';
    const NOTE_POSITION_MIDDLE_RIGHT = 'middle-right';
    const NOTE_POSITION_BOTTOM_LEFT = 'bottom-left';
    const NOTE_POSITION_MIDDLE_BOTTOM = 'middle-bottom';
    const NOTE_POSITION_BOTTOM_RIGHT = 'bottom-right';

    /**
     * banner collection factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * constructor.
     *
     * @param \Magento\Framework\Model\Context                                $context
     * @param \Magento\Framework\Registry                                     $registry
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider                   $resource
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\Collection        $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider $resource,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
    }

    /**
     * get banner collection of slider.
     *
     * @return \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\Collection
     */
    public function getOwnBanerCollection()
    {
        return $this->_bannerCollectionFactory->create()->addFieldToFilter('slider_id', $this->getId());
    }
}
