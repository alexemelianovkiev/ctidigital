<?php

namespace Ctidigital\Countdown\Api;

interface CountdownMappingInterface
{
    /**
     * Retrieve mapping in next format
     *
     * [
     *   day_of_week => 'HH,mm'
     * ]
     *
     * @return array
     */
    public function get(): array ;
}
