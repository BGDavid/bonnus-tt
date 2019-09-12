<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml\Slider;

use Magento\Framework\Controller\ResultFactory;

/**
 * MassStatus action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class MassStatus extends \Unicodesystems\Bannerslider\Controller\Adminhtml\AbstractAction
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {

         $ids = $this->getRequest()->getParam('slider');

         $status = $this->getRequest()->getParam('status');
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select slider.'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get(
                        \Unicodesystems\Bannerslider\Model\Slider::class
                    )->load($id);
                    $row->setData('status', $status)
                            ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) status have been changed.', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
         $this->_redirect('*/*/');
    }
}
