<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Model;

/**
 * Value Model
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Value extends \Magento\Framework\Model\AbstractModel
{
    /**
     * constructor.
     *
     * @param \Magento\Framework\Model\Context                        $context
     * @param \Magento\Framework\Registry                             $registry
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Value            $resource
     * @param \Unicodesystems\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Value $resource,
        \Unicodesystems\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

    /**
     * load attribute value.
     *
     * @param int    $bannerId
     * @param int    $storeViewId
     * @param string $attributeCode
     *
     * @return $this
     */
    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
    {
        $attributeValue = $this->getResourceCollection()
            ->addFieldToFilter('banner_id', $bannerId)
            ->addFieldToFilter('store_id', $storeViewId)
            ->addFieldToFilter('attribute_code', ['in' => $attributeCode]);

        foreach ($attributeValue as $model) {
            $this->setData('banner_id', $bannerId)
                ->setData('store_id', $storeViewId)
                ->setData('attribute_code', $model->getData('attribute_code'));
            if ($model->getId()) {
                $this->addData($model->getData())
                    ->setId($model->getId());
            }
        }

        return $attributeValue;
    }
}
