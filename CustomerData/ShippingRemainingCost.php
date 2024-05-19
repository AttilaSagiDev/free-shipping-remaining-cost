<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Space\FreeShippingRemainingCost\Model\Service\Calculation;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;

class ShippingRemainingCost implements SectionSourceInterface
{
    /**
     * @var Calculation
     */
    private Calculation $calculation;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor
     *
     * @param Calculation $calculation
     * @param ConfigInterface $config
     */
    public function __construct(
        Calculation $calculation,
        ConfigInterface $config
    ) {
        $this->calculation = $calculation;
        $this->config = $config;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        return $this->config->isEnabled() ? $this->calculation->getRemainingCostMessage() : [];
    }
}
