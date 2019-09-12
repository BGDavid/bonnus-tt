<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

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

    public function execute()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds) || empty($sliderIds)) {
            $this->messageManager->addErrorMessage(__('Please select slider(s).'));
        } else {
            try {
                foreach ($sliderIds as $sliderUd) {
                    $slider = $this->_objectManager->create(
                        \Unicodesystems\Bannerslider\Model\Slider::class
                    )->load($sliderUd);
                    $slider->delete();
                }
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 record(s) have been deleted.', count($sliderIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
