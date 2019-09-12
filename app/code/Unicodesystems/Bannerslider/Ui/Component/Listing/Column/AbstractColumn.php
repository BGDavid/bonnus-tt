<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Ui\Component\Listing\Column;

/**
 * AbstractColumn
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
abstract class AbstractColumn extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $this->_prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return array
     */
    abstract protected function _prepareItem(array & $item);
}
