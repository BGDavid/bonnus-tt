<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

use Magento\Framework\Controller\ResultFactory;
use Unicodesystems\Bannerslider\Model\ResourceModel\Banner\Grid\StatusesArray;

/**
 * MassDisable action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class MassDisable extends \Unicodesystems\Bannerslider\Controller\Adminhtml\AbstractAction
{

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $sliderCollection = $this->_objectManager->create(
            \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\Collection::class
        );
        $collection = $this->_massActionFilter->getCollection($sliderCollection);
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->setStatus(StatusesArray::STATUS_DISABLED);
            try {
                $item->save();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
