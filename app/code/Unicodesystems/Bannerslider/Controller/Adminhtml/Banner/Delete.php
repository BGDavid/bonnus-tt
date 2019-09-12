<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Banner;

/**
 * Delete Banner action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Delete extends \Unicodesystems\Bannerslider\Controller\Adminhtml\Banner
{

    public function execute()
    {
        $bannerId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
        try {
            /*get banner data*/
         
            $banner_data = $this->_bannerFactory->create()->load($bannerId);

            $banner = $this->_bannerFactory->create()->setId($bannerId);

            $bannerdata = $banner_data->getData();
            $banner_image = $bannerdata['image'];
            
            /*delete image file*/
            $this->deleteImageFile($banner_image);

            $banner->delete();

            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }

    public function deleteImageFile($image)
    {
        if (!$image) {
            return;
        }
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $directory = $objectManager->get(\Magento\Framework\Filesystem\DirectoryList::class);
            $rootPath =  $directory->getRoot();
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
