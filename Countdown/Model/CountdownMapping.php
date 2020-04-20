<?php

namespace Ctidigital\Countdown\Model;

use Ctidigital\Countdown\Api\CountdownMappingInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * @api
 */
class CountdownMapping implements CountdownMappingInterface
{
    const XML_PATH_COUNTDOWN = 'catalog/product_countdown/countdown_%s';

    /**
     * In order to speedup OPcache should be private static, rather than const
     *
     * @var array
     */
    private static $weekDays = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * CountdownMapping constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve mapping in next format
     *
     * [
     *   day_of_week => 'HH:mm'
     * ]
     *
     * @return array
     */
    public function get(): array
    {
        $mapping = [];

        foreach ($this::$weekDays as $weekDay) {
            $mapping[$weekDay] = $this->scopeConfig->getValue(sprintf(self::XML_PATH_COUNTDOWN, $weekDay));
        }

        return $mapping;
    }
}
