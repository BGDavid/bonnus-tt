<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Model\Data\Option;

/**
 * Interface OptionHashInterface
 * @package Unicodesystems\Storelocator\Model\Data\Option
 */
interface OptionHashInterface
{
    /**
     * Return array of options as key-value pairs.
     *
     * @return array Format: array('<key>' => '<value>', '<key>' => '<value>', ...)
     */
    public function toOptionHash();
}
