<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Block\Adminhtml\System\Config;

/**
 * Implement
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
class Implementcode extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '
		<div class="notices-wrapper">
		        <div class="messages">
		            <div class="message" style="margin-top: 10px;">
		                <strong>'.__('Add code below to a template file.').'</strong><br />
		                $this->getLayout()->createBlock(
		                "Unicodesystems\Bannerslider\Block\SliderItem"
		                )->setSliderId(your_slider_id)->toHtml();
		            </div>
		            <div class="message" style="margin-top: 10px;">
		                <strong>'.__('You can put a slider on a cms page. 
		                	Below is an example which we put a slider with slider_id
		                	 is your_slider_id on a cms page.').'</strong><br />
		                {{block class="Unicodesystems\Bannerslider\Block\SliderItem"
		                 name="bannerslider.slidercustom" slider_id="your_slider_id"}}
		            </div>
		            <div class="message" style="margin-top: 10px;">
		                <strong>'.__('Please copy and paste the code below on one of xml layout files where you want to show the banner. Please replace the your_slider_id variable with your own slider Id.').'</strong><br />
		                &lt;block class="Unicodesystems\Bannerslider\Block\SliderItem"&gt;<br />
                           &nbsp;&lt;action method="setSliderId"&gt;<br />
                               &nbsp;&nbsp;&lt;argument name="sliderId" xsi:type="string"&gt;your_slider_id&lt;/argument&gt;<br/>
                           &nbsp;&lt;/action&gt;<br />
                       &lt;/block&gt;
		            </div>
		        </div>
		</div>';
    }
}
