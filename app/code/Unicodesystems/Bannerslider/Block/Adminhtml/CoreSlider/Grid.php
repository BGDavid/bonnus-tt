<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\CoreSlider;

/**
 * Core slider grid.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Data\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * helper.
     *
     * @var \Unicodesystems\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context     $context            [description]
     * @param \Magento\Backend\Helper\Data                $backendHelper      [description]
     * @param \Magento\Framework\Data\Collection          $dataCollection     [description]
     * @param \Unicodesystems\Bannerslider\Helper\Data         $bannersliderHelper [description]
     * @param array                                       $data               [description]
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Unicodesystems\Bannerslider\Helper\Data $bannersliderHelper,
        array $data = []
    ) {
        $this->_bannersliderHelper = $bannersliderHelper;
        $this->_collectionFactory = $collectionFactory;
        $this->_objectFactory = $objectFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * [_construct description].
     *
     * @return [type] [description]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('coresliderGrid');
        $this->setDefaultSort('coreslider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        $coreSlider = $this->_bannersliderHelper->getCoreSlider();

        $collection = $this->_collectionFactory->create();
        foreach ($coreSlider as $slider) {
            $collection->addItem(
                $this->_objectFactory->create(
                    ['data' => [
                        'id' => $slider['value'],
                        'title' => $slider['label'],
                    ]]
                )
            );
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'title',
            [
                'header' => __('List Slider'),
                'align' => 'left',
                'index' => 'title',

            ]
        );

        $this->addColumn(
            'preview',
            [
                'header' => __('Preview'),
                'align' => 'left',
                'index' => 'preview',
                'renderer' => \Unicodesystems\Bannerslider\Block\Adminhtml\CoreSlider\Helper\Renderer\Action::class,
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/slider/preview', ['sliderpreview_id' => $row->getId()]);
    }
}
