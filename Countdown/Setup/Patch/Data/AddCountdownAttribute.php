<?php

namespace Ctidigital\Countdown\Setup\Patch\Data;

use Ctidigital\Countdown\Api\CountdownResolverInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCountdownAttribute implements DataPatchInterface
{
    /**
     * @var \Magento\Eav\Setup\EavSetup
     */
    private $eavSetup;

    /**
     * AddCountdownAttribute constructor.
     * @param \Magento\Eav\Setup\EavSetup $eavSetup
     */
    public function __construct(\Magento\Eav\Setup\EavSetup $eavSetup)
    {
        $this->eavSetup = $eavSetup;
    }

    /**
     * @return DataPatchInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function apply()
    {
        $this->eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            CountdownResolverInterface::COUNTDOWN_PRODUCT_ATTRIBUTE,
            [
                'group' => 'Product Details',
                'type' => 'int',
                'label' => 'Product countdown status',
                'input' => 'boolean',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_WEBSITE,
                'visible' => true,
            ]
        );
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
