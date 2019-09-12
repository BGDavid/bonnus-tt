<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Banner;

/**
 * Banner grid action.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Grid extends \Unicodesystems\Bannerslider\Controller\Adminhtml\Banner
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }
}
