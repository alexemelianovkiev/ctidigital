<?php

namespace Ctidigital\Countdown\Api;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * The main responsibility of this class is to declare attribute code, that will be used further in block, setup
 * and graphql.
 * Used as mediator, to make weaker coupling between setup and presentation layer.
 * As well to resolve if countdown is enabled for product or disabled
 *
 * @api
 */
interface CountdownResolverInterface
{
    const COUNTDOWN_PRODUCT_ATTRIBUTE = 'countdown_status';

    /**
     * @return bool
     */
    public function isCountdownEnabled(): bool ;

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function isCountdownEnabledForProduct(ProductInterface $product): bool ;
}
