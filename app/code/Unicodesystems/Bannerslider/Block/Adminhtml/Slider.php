<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml;

/**
 * Slider grid container.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'Unicodesystems_Bannerslider';
        $this->_headerText = __('Sliders');
        $this->_addButtonLabel = __('Add New Slider');
        parent::_construct();
    }
}
