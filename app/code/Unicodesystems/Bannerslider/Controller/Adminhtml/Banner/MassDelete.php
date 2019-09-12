<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;

/**
 * MassDelete action.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class MassDelete extends \Unicodesystems\Bannerslider\Controller\Adminhtml\AbstractAction
{

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());

        $collectionSize = $collection->getSize();
        foreach ($collection as $banner) {
            /*delete image file*/
            $banner_image = $banner['image'];
            $this->deleteImageFile($banner_image);

            $banner->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /*
    Delete image file
    */
    public function deleteImageFile($image)
    {
        if (!$image) {
            return;
        }
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $directory = $objectManager->get(\Magento\Framework\Filesystem\DirectoryList::class);
            $rootPath  =  $directory->getRoot();

            $mediaDirectory = $objectManager->get(\Magento\Framework\Filesystem::class)
            ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $mediaRootDir = $mediaDirectory->getAbsolutePath();

            if ($this->_file->fileExists($mediaRootDir . $image)) {
                $this->_file->rm($mediaRootDir . $image);
            }
        } catch (\Exception $exc) {
            $this->messageManager->addError($exc->getTraceAsString());
        }
    }
}
