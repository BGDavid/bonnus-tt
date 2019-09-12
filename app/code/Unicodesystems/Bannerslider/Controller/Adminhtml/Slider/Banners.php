<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

/**
 * Banners of slider action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Banners extends \Unicodesystems\Bannerslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('bannerslider.slider.edit.tab.banners')
                     ->setInBanner($this->getRequest()->getPost('banner', null));

        return $resultLayout;
    }
}
