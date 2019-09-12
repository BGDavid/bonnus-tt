<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Model\ResourceModel\Value;

/**
 * Value Collection
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Unicodesystems\Bannerslider\Model\Value::class,
            \Unicodesystems\Bannerslider\Model\ResourceModel\Value::class
        );
    }
}
