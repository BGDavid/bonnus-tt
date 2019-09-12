<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

/**
 * Delete Slider action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Delete extends \Unicodesystems\Bannerslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
        try {
            $slider = $this->_sliderFactory->create()->setId($sliderId);
            $slider->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
