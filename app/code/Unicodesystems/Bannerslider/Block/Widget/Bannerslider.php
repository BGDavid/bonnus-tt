<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Widget;

/**
 * Bannerslider Block
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Bannerslider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        parent::__construct($context);
    }
}
