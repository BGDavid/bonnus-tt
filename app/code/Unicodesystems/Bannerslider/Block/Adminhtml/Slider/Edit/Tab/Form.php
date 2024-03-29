<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\Slider\Edit\Tab;

use Unicodesystems\Bannerslider\Model\Status;

/**
 * Slider Form.
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    const FIELD_NAME_SUFFIX = 'slider';

    /**
     * @var \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory
     */
    protected $_fieldFactory;

    /**
     * [$_bannersliderHelper description].
     *
     * @var \Unicodesystems\Bannerslider\Helper\Data
     */
    protected $_bannersliderHelper;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context                                $context            [description]
     * @param
     \Unicodesystems\Bannerslider\Helper\Data $bannersliderHelper [description]
     * @param \Magento\Framework\Registry                                            $registry           [description]
     * @param \Magento\Framework\Data\FormFactory                                    $formFactory        [description]
     * @param \Magento\Store\Model\System\Store                                      $systemStore        [description]
     * @param \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory       [description]
     * @param array                                                                  $data               [description]
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Unicodesystems\Bannerslider\Helper\Data $bannersliderHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        array $data = []
    ) {
        $this->_bannersliderHelper = $bannersliderHelper;
        $this->_fieldFactory = $fieldFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $slider = $this->getSlider();
        $isElementDisabled = true;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        /*
         * declare dependence
         */
        // dependence block
        $dependenceBlock = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Form\Element\Dependence::class
        );

        // dependence field map array
        $fieldMaps = [];

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider Information')]);

        if ($slider->getId()) {
            $fieldset->addField('slider_id', 'hidden', ['name' => 'slider_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $statuses = $objectManager->get(\Unicodesystems\Bannerslider\Model\Status::class)->getAvailableStatuses();

        $fieldMaps['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Slider Status'),
                'title' => __('Slider Status'),
                'name' => 'status',
                'options' => $statuses,
                'disabled' => false,
            ]
        );

        $fieldMaps['style_content'] = $fieldset->addField(
            'style_content',
            'select',
            [
                'label' => __('Select available Slider Styles'),
                'name' => 'style_content',
                'values' => [
                    [
                        'value' => Status::STATUS_ENABLED,
                        'label' => __('Yes'),
                    ],
                    [
                        'value' => Status::STATUS_DISABLED,
                        'label' => __('No'),
                    ],
                ],
            ]
        );

        $fieldMaps['custom_code'] = $fieldset->addField(
            'custom_code',
            'editor',
            [
                'name' => 'custom_code',
                'label' => __('Custom slider'),
                'title' => __('Custom slider'),
                'wysiwyg' => true,
                'required' => false,
            ]
        );

        if ($slider->getStyleSlide() !='') {
            $sliderId = $slider->getStyleSlide();
        } else {
            $sliderId = 7;
        }
        $previewUrl = $this->_bannersliderHelper->getBackendUrl(
            '*/*/preview',
            ['_current' => false,
            'sliderpreview_id'=>$sliderId]
        );
        $fieldMaps['style_slide'] = $fieldset->addField(
            'style_slide',
            'select',
            [
                'label' => __('Select Slider Mode'),
                'name' => 'style_slide',
                'values' => $this->_bannersliderHelper->getStyleSlider(),
                'note' => '<a data-preview-url="' . $previewUrl . '" href="'
                 . $previewUrl . '" target="_blank" id="style-slide-view">Preview</a>',
            ]
        );

        $fieldMaps['style_slide']->setAfterElementHtml("<script>
            require(['jquery'],
                function($) {
                    $(document).ready( function(){
                        var lastsliderId = '$sliderId';
                        $(document).on('change', '#page_style_slide', function() {
                            var previewId = $('#page_style_slide').val();
                            if(previewId == '') previewId = 7;
                            var reExp = 'sliderpreview_id/'+lastsliderId;
                            var url = $('#style-slide-view').attr('href');
                            var newurl = url.replace(reExp, 'sliderpreview_id/' + previewId);
                            $('#style-slide-view').attr('href',newurl);
                            lastsliderId = previewId;
                        });
                    });
            });</script>");
        $fieldMaps['sort_type'] = $fieldset->addField(
            'sort_type',
            'select',
            [
                'label' => __('Sort type'),
                'name' => 'sort_type',
                'values' => [
                    [
                        'value' => \Unicodesystems\Bannerslider\Model\Slider::SORT_TYPE_RANDOM,
                        'label' => __('Random'),
                    ],
                    [
                        'value' => \Unicodesystems\Bannerslider\Model\Slider::SORT_TYPE_ORDERLY,
                        'label' => __('Orderly'),
                    ],
                ],
            ]
        );

        $fieldMaps['width'] = $fieldset->addField(
            'width',
            'text',
            [
                'label' => __('Width'),
                'name' => 'width',
                'required' => true,
                'class' => 'required-entry validate-number validate-greater-than-zero',
            ]
        );

        $fieldMaps['height'] = $fieldset->addField(
            'height',
            'text',
            [
                'label' => __('Height'),
                'name' => 'height',
                'required' => true,
                'class' => 'required-entry validate-number validate-greater-than-zero',
            ]
        );

        $fieldMaps['animationB'] = $fieldset->addField(
            'animationB',
            'select',
            [
                'label' => __('Animation Effect'),
                'name' => 'animationB',
                'values' => $this->_bannersliderHelper->getAnimationB(),
            ]
        );

        $fieldMaps['animationA'] = $fieldset->addField(
            'animationA',
            'select',
            [
                'label' => __('Animation Effect'),
                'name' => 'animationA',
                'values' => $this->_bannersliderHelper->getAnimationA(),
            ]
        );

        $fieldMaps['note_color'] = $fieldset->addField(
            'note_color',
            'select',
            [
                'name' => 'note_color',
                'label' => __('Color'),
                'title' => __('Color'),
                'values' => $this->_bannersliderHelper->getOptionColor(),
            ]
        );

        $fieldMaps['slider_speed'] = $fieldset->addField(
            'slider_speed',
            'text',
            [
                'label' => __('Speed'),
                'name' => 'slider_speed',
                'note' => 'milliseconds . This is the display time of a banner',
            ]
        );

        $fieldMaps['position_note'] = $fieldset->addField(
            'position_note',
            'select',
            [
                'name' => 'position_note',
                'label' => __('Position'),
                'title' => __('Position'),
                'values' => $slider->getPositionNoteOptions(),
                'note' => 'is position will be shown on all pages',
            ]
        );

        $fieldMaps['description'] = $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Note\'s content'),
                'title' => __('Note\'s content'),
                'wysiwyg' => true,
                'required' => false,
            ]
        );

        $positionImage = [];
        for ($i = 1; $i <= 5; ++$i) {
            $positionImage[] = $this->getViewFileUrl("
                Unicodesystems_Bannerslider::images/position/bannerslider-ex{$i}.png");
        }
        $fieldMaps['position'] = $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Position'),
                'title' => __('Position'),
                'values' => $this->_bannersliderHelper->getBlockIdsToOptionsArray(),
            ]
        );

        $fieldMaps['position_custom'] = $fieldset->addField(
            'position_custom',
            'select',
            [
                'name' => 'position_custom',
                'label' => __('Position'),
                'title' => __('Position'),
                'values' => $this->_bannersliderHelper->getBlockIdsToOptionsArray(),
                'note' => '<a title="" data-position-image=\'' .
                 json_encode($positionImage) . '\' data-tooltip-image="">Preview</a>',
            ]
        );

        $fieldMaps['category_ids'] = $fieldset->addField(
            'category_ids',
            'multiselect',
            [
                'label' => __('Categories'),
                'name' => 'category_ids',
                'values' => $this->_bannersliderHelper->getCategoriesArray(),
            ]
        );

        /*
         * Add field map
         */
        foreach ($fieldMaps as $fieldMap) {
            $dependenceBlock->addFieldMap($fieldMap->getHtmlId(), $fieldMap->getName());
        }

        $mappingFieldDependence = $this->getMappingFieldDependence();

        /*
         * Add field dependence
         */
        foreach ($mappingFieldDependence as $dependence) {
            $negative = isset($dependence['negative']) && $dependence['negative'];
            if (is_array($dependence['fieldName'])) {
                foreach ($dependence['fieldName'] as $fieldName) {
                    $dependenceBlock->addFieldDependence(
                        $fieldMaps[$fieldName]->getName(),
                        $fieldMaps[$dependence['fieldNameFrom']]->getName(),
                        $this->getDependencyField($dependence['refField'], $negative)
                    );
                }
            } else {
                $dependenceBlock->addFieldDependence(
                    $fieldMaps[$dependence['fieldName']]->getName(),
                    $fieldMaps[$dependence['fieldNameFrom']]->getName(),
                    $this->getDependencyField($dependence['refField'], $negative)
                );
            }
        }

        /*
         * add child block dependence
         */
        $this->setChild('form_after', $dependenceBlock);

        $defaultData = [
            'width' => 400,
            'height' => 200,
            'slider_speed' => 4500,
        ];

        if (!$slider->getId()) {
            $slider->setStatus($isElementDisabled ? Status::STATUS_ENABLED : Status::STATUS_DISABLED);
            $slider->addData($defaultData);
        }

        if ($slider->hasData('animationB')) {
            $slider->setData('animationA', $slider->getData('animationB'));
        }

        if ($slider->hasData('position')) {
            $slider->setPositionCustom($slider->getPosition());
        }

        $form->setValues($slider->getData());
        $form->addFieldNameSuffix(self::FIELD_NAME_SUFFIX);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    /**
     * get dependency field.
     *
     * @return Magento\Config\Model\Config\Structure\Element\Dependency\Field [description]
     */
    public function getDependencyField($refField, $negative = false, $separator = ',', $fieldPrefix = '')
    {
        return $this->_fieldFactory->create(
            ['fieldData' => ['value' => (string)$refField,
             'negative' => $negative, 'separator' => $separator], 'fieldPrefix' => $fieldPrefix]
        );
    }

    public function getMappingFieldDependence()
    {
        return [
            [
                'fieldName' => ['width', 'height'],
                'fieldNameFrom' => 'style_slide',
                'refField' => '1,2,3,4,5',
            ],
            [
                'fieldName' => 'category_ids',
                'fieldNameFrom' => 'position',
                'refField' => implode(',', [
                    'category-sidebar-right-top',
                    'category-sidebar-right-bottom',
                    'category-sidebar-left-top',
                    'category-sidebar-left-bottom',
                    'category-content-top',
                    'category-menu-top',
                    'category-menu-bottom',
                    'category-page-bottom',
                ]),
            ],
            [
                'fieldName' => [
                    'width',
                    'height',
                    'animationA',
                    'animationB',
                    'position',
                    'style_slide',
                    'sort_type',
                    'note_color',
                    'slider_speed',
                    'position_note',
                ],
                'fieldNameFrom' => 'style_content',
                'refField' => '1',
            ],
            [
                'fieldName' => 'animationA',
                'fieldNameFrom' => 'style_slide',
                'refField' => '1,2,3,4',
            ],
            [
                'fieldName' => 'animationB',
                'fieldNameFrom' => 'style_slide',
                'refField' => '7,8,9',
            ],
            [
                'fieldName' => 'position',
                'fieldNameFrom' => 'style_slide',
                'refField' => '5,6,',
                'negative' => true,
            ],
            [
                'fieldName' => 'position_custom',
                'fieldNameFrom' => 'style_content',
                'refField' => '2',
            ],
            [
                'fieldName' => 'sort_type',
                'fieldNameFrom' => 'style_slide',
                'refField' => '5,',
                'negative' => true,
            ],
            [
                'fieldName' => ['note_color', 'position_note'],
                'fieldNameFrom' => 'style_slide',
                'refField' => '6',
            ],
            [
                'fieldName' => 'slider_speed',
                'fieldNameFrom' => 'style_slide',
                'refField' => '5,10,',
                'negative' => true,
            ],
        ];
    }

    public function getSlider()
    {
        return $this->_coreRegistry->registry('slider');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Slider Information');
    }

    public function getPageTitle()
    {
        return $this->getSlider()->getId() ? __(
            "Edit Slider '%1'",
            $this->escapeHtml($this->getSlider()->getTitle())
        ) : __('New Slider');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Slider Information');
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
}
