<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer;

/**
 * Edit banner form
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class EditBanner extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * banner factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Context              $context       [description]
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager  [description]
     * @param \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory [description]
     * @param array                                       $data          [description]
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_bannerFactory = $bannerFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return '<a href="' . $this->getUrl(
            '*/banner/edit',
            ['_current' => false,
            'banner_id' => $row->getId()]
        ). '" target="_blank">Edit</a> ';
    }
}
