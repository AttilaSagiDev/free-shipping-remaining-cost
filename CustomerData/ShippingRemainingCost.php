<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Psr\Log\LoggerInterface;

class ShippingRemainingCost implements SectionSourceInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        return [
            'message' => __('Test message'),
            'value' => rand(10, 100)
        ];
    }
}
