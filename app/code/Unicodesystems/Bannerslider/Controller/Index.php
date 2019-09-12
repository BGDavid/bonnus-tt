<?php
/**
 * Copyright © 2019 Unicode Systems. All rights reserved.
 */
namespace Unicodesystems\Bannerslider\Controller;

/**
 * Index action
 * @category Unicodesystems
 * @package  Unicodesystems_Bannerslider
 * @module   Bannerslider
 * @author   Unicodesystems Developer
 */
abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Slider factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * banner factory.
     *
     * @var \Unicodesystems\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * A result that contains raw response - may be good for passing through files
     * returning result of downloads or some other binary contents.
     *
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultRawFactory;
    /**
     * logger.
     *
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     * stdlib timezone.
     *
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     * @param \Unicodesystems\Bannerslider\Model\SliderFactory                          $sliderFactory
     * @param \Unicodesystems\Bannerslider\Model\BannerFactory                          $bannerFactory
     * @param \Magento\Framework\Controller\Result\RawFactory                      $resultRawFactory
     * @param \Magento\Framework\Logger\Monolog                                    $monolog
     * @param \Magento\Framework\Stdlib\DateTime\Timezone                          $stdTimezone
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Unicodesystems\Bannerslider\Model\SliderFactory $sliderFactory,
        \Unicodesystems\Bannerslider\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Logger\Monolog $monolog,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
    ) {
        parent::__construct($context);
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_resultRawFactory = $resultRawFactory;
        $this->_monolog = $monolog;
        $this->_stdTimezone = $stdTimezone;
    }
    public function getCookieManager()
    {
        return $this->_objectManager->create(
            Magento\Framework\Stdlib\CookieManagerInterface::class
        );
    }
    /**
     * get user code.
     *
     * @param mixed $id
     *
     * @return string
     */
    protected function getUserCode($id)
    {
        $ipAddress = $this->_objectManager->create(
            Magento\Framework\HTTP\PhpEnvironment\Request::class
        )->getClientIp(true);

        $cookiefrontend = $this->getCookieManager()->getCookie('frontend');
        $usercode = $ipAddress.$cookiefrontend.$id;

        return sha1($usercode);
    }
}
