<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\Banner\Helper\Renderer;

/**
 * Image renderer.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
     * @param \Magento\Backend\Block\Context              $context
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory
     * @param array                                       $data
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
        $storeViewId = $this->getRequest()->getParam('store');
        $banner = $this->_bannerFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . $banner->getImage();

        return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$banner->getImage().'" >';
    }
}
