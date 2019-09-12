<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\Slider;

use Unicodesystems\Bannerslider\Model\Status;

/**
 * Slider grid.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * slider collection factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * helper.
     *
     * @var \Unicodesystems\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    /**
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Unicodesystems\Bannerslider\Helper\Data                             $bannersliderHelper
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Unicodesystems\Bannerslider\Helper\Data $bannersliderHelper,
        array $data = []
    ) {
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_bannersliderHelper = $bannersliderHelper;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return [type] [description]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('sliderGrid');
        $this->setDefaultSort('slider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection.
     *
     * @return [type] [description]
     */
    protected function _prepareCollection()
    {
        $collection = $this->_sliderCollectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'slider_id',
            [
                'header' => __('Slider ID'),
                'type' => 'number',
                'index' => 'slider_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'index' => 'position',
                'type' => 'options',
                'class' => 'xxx',
                'width' => '50px',
                'options' => $this->_bannersliderHelper->getAvailablePositions(),
            ]
        );

        $this->addColumn(
            'style_slide',
            [
                'header' => __('Slider\'s Mode'),
                'index' => 'style_slide',
                'class' => 'xxx',
                'width' => '50px',
                'type' => 'options',
                'options' => $this->_bannersliderHelper->getSliderModeAvailable(),
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $status = $objectManager->get(\Unicodesystems\Bannerslider\Model\Status::class)->getAvailableStatuses();
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $status,
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'is_system'=>true,
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                        ],
                        'field' => 'slider_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('bannerslideradmin/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $statuses = $objectManager->get(\Unicodesystems\Bannerslider\Model\Status::class)->getAvailableStatuses();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('bannerslideradmin/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['slider_id' => $row->getId()]
        );
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
