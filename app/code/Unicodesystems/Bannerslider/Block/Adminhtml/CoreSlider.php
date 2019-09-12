<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml;

/**
 * core slider grid container.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class CoreSlider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_coreSlider';
        $this->_blockGroup = 'Unicodesystems_Bannerslider';
        $this->_headerText = __('Preview Slider Styles');
        $this->_addButtonLabel = __('Add New Slider');
        parent::_construct();
        $this->removeButton('add');
    }
}
