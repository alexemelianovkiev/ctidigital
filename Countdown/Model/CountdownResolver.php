<?php

namespace Ctidigital\Countdown\Model;

use Ctidigital\Countdown\Api\CountdownResolverInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CountdownResolver implements CountdownResolverInterface
{
    const XML_PATH_COUNTDOWN_ENABLED = 'catalog/product_countdown/status';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * CountdownResolver constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function isCountdownEnabledForProduct(ProductInterface $product): bool
    {
        return (bool) $product->getCustomAttribute(self::COUNTDOWN_PRODUCT_ATTRIBUTE);
    }

    /**
     * @return bool
     */
    public function isCountdownEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_COUNTDOWN_ENABLED);
    }
}
