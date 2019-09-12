<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller\Adminhtml;

/**
 * Slider Abstract Action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
abstract class Slider extends \Unicodesystems\Bannerslider\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'slider_id';

    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Unicodesystems_Bannerslider::bannerslider_sliders');
    }
}
