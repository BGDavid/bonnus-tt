<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml;

/**
 * Abstract Action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
abstract class AbstractAction extends \Magento\Backend\App\Action
{
    const PARAM_CRUD_ID = 'entity_id';

    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * A factory that knows how to create a "page" result
     * Requires an instance of controller action in order to impose page type,
     * which is by convention is determined from the controller action class.
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Banner factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Banner Collection Factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * Slider factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * File Factory.
     *
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massActionFilter;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $_adapterFactory;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * File Io.
     *
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $_file;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory
     * @param \Unicodesystems\Bannerslider\Model\SliderFactory $sliderFactory
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Magento\Framework\Filesystem\Io\File $file
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory,
        \Unicodesystems\Bannerslider\Model\SliderFactory $sliderFactory,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Helper\Js $jsHelper,
        \Magento\Ui\Component\MassAction\Filter $massActionFilter,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\Framework\Filesystem\Io\File $file
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;
        $this->_massActionFilter = $massActionFilter;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;

        $this->_bannerFactory = $bannerFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_uploaderFactory = $uploaderFactory;
        $this->_adapterFactory = $adapterFactory;
        $this->_file = $file;
    }
    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     *
     * @throws LocalizedException
     */
    protected function _createMainCollection()
    {
        /** @var \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection */
        $collection = $this->_objectManager->create(
            \Unicodesystems\Bannerslider\Model\ResourceModel\Banner\Collection::class
        );
        return $collection;
    }

    /**
     * Get back result redirect after add/edit.
     *
     * @param \Magento\Framework\Controller\Result\Redirect $resultRedirect
     * @param null                                          $paramCrudId
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function _getBackResultRedirect(
        \Magento\Framework\Controller\Result\Redirect $resultRedirect,
        $paramCrudId = null
    ) {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
