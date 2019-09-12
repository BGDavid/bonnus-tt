<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Model\Config\Source;

/**
 * Slider Model
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Slider implements \Magento\Framework\Option\ArrayInterface
{
    protected $sliderFactory;

    public function __construct(
        \Unicodesystems\Bannerslider\Model\SliderFactory $sliderFactory
    ) {
        $this->sliderFactory = $sliderFactory;
    }

    public function getSliders()
    {
        $sliderModel = $this->sliderFactory->create();
        return $sliderModel->getCollection()->getData();
    }

    public function toOptionArray()
    {
        $sliders = [];
        foreach ($this->getSliders() as $slider) {
            array_push($sliders, [
                'value' => $slider['slider_id'],
                'label' => $slider['title']
            ]);
        }
        return $sliders;
    }
}
