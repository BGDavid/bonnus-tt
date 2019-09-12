<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml;

use Unicodesystems\Bannerslider\Model\Slider as SliderModel;

/**
 * Preview Block
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Preview extends \Magento\Backend\Block\Template
{
    const STYLESLIDE_PARAM = 'sliderpreview_id';
    const PREVIEW_NOTE_ID_MIN = 1;
    const PREVIEW_NOTE_ID_MAX = 8;

    /**
     * preview template for slider.
     */
    
    const STYLESLIDE_FLEXSLIDER_PREVIEW_TEMPLATE = 'Unicodesystems_Bannerslider::slider/preview/flexslider.phtml';

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Unicodesystems\Bannerslider\Helper\Data $bannersliderHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Add elements in layout.
     *
     * @return
     */
    protected function _prepareLayout()
    {
        $styleslideParam = $this->getRequest()->getParam(self::STYLESLIDE_PARAM);
        $this->setStyleSlidePreviewTemplate($styleslideParam);

        return parent::_prepareLayout();
    }

    /**
     * set style slide template.
     *
     * @return string|null
     */
    public function setStyleSlidePreviewTemplate($styleslideParam)
    {
        switch ($styleslideParam) {
            case SliderModel::STYLESLIDE_FLEXSLIDER_ONE:
            case SliderModel::STYLESLIDE_FLEXSLIDER_TWO:
            case SliderModel::STYLESLIDE_FLEXSLIDER_THREE:
                $this->setTemplate(self::STYLESLIDE_FLEXSLIDER_PREVIEW_TEMPLATE);
                break;
        }
    }
}
