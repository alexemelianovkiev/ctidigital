<?php

namespace Ctidigital\Countdown\Test;

use Ctidigital\Countdown\Block\Countdown;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/**
 */
class MappingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Countdown
     */
    private $block;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
        $this->block = $this->objectManager->get(Countdown::class);
    }

    /**
     * Check if mapping json is correct
     *
     * @magentoConfigFixture current_store catalog/product_countdown/status 1
     * @magentoConfigFixture current_store catalog/product_countdown/countdown_monday 12,12
     * @magentoDataFixture Ctidigital_Countdown/_files/product.php
     */
    public function testMappingJsonWithProductEnabled()
    {
        $mapping = $this->block->getJsonMapping();
        $this->assertMondayMapping($mapping);
    }

    /**
     * Check if mapping json is empty if module disabled
     *
     * @magentoConfigFixture current_store catalog/product_countdown/status 0
     * @magentoConfigFixture current_store catalog/product_countdown/countdown_monday 12,12
     * @magentoDataFixture Ctidigital_Countdown/_files/product.php
     */
    public function testMappingJsonWithProductEnabledModuleDisabled()
    {
        $mapping = $this->block->getJsonMapping();
        $this->assertEmptyMapping($mapping);
    }

    /**
     * Check if mapping json is empty if module disabled
     *
     * @magentoConfigFixture current_store catalog/product_countdown/status 1
     * @magentoConfigFixture current_store catalog/product_countdown/countdown_monday 12,12
     * @magentoDataFixture Ctidigital_Countdown/_files/product.php
     */
    public function testMappingJsonWithProductDisabledModuleEnabled()
    {
        $mapping = $this->block->getJsonMapping();
        $this->assertEmptyMapping($mapping);
    }

    /**
     * @param $mapping
     */
    private function assertMondayMapping($mapping)
    {
        $mondayMapping = '{"monday":"12,12"}';
        $this->assertEquals($mapping, $mondayMapping);
    }

    private function assertEmptyMapping($mapping)
    {
        $mapping = json_decode($mapping, true);
        $this->assertEmpty($mapping);
    }
}
