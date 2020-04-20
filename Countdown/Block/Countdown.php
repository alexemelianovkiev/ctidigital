<?php

namespace Ctidigital\Countdown\Block;

use Ctidigital\Countdown\Api\CountdownMappingInterface;
use Ctidigital\Countdown\Api\CountdownResolverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\View\Context;

/**
 * @api
 */
class Countdown extends View
{
    /**
     * @var CountdownMappingInterface
     */
    private $countdownMapping;

    /**
     * @var CountdownResolverInterface
     */
    private $countdownResolver;

    /**
     * @var Timezone
     */
    private $timezone;

    /**
     * Countdown constructor.
     * @param Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param CountdownMappingInterface $countdownMapping
     * @param CountdownResolverInterface $countdownResolver
     * @param Timezone $timezone
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        CountdownMappingInterface $countdownMapping,
        CountdownResolverInterface $countdownResolver,
        Timezone $timezone,
        array $data = []
    ) {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
        $this->countdownMapping = $countdownMapping;
        $this->countdownResolver = $countdownResolver;
        $this->timezone = $timezone;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->countdownResolver->isCountdownEnabled() &&
               $this->countdownResolver->isCountdownEnabledForProduct($this->getProduct());
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone->getConfigTimezone();
    }

    /**
     * @return string
     */
    public function getJsonMapping(): string
    {
        if (!$this->isEnabled()) {
            return json_encode([]);
        }

        return json_encode($this->countdownMapping->get());
    }
}
