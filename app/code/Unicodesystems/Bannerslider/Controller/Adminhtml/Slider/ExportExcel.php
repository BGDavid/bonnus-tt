<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Export Excel action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class ExportExcel extends \Unicodesystems\Bannerslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $fileName = 'sliders.xls';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock(
            \Unicodesystems\Bannerslider\Block\Adminhtml\Slider\Grid::class
        )->getExcel();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
