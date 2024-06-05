<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Space\FreeShippingRemainingCost\Api\RemainingCostCalculationInterface;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

class ShippingRemainingCost implements SectionSourceInterface
{
    /**
     * @var RemainingCostCalculationInterface
     */
    private RemainingCostCalculationInterface $remainingCostCalculation;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor
     *
     * @param RemainingCostCalculationInterface $remainingCostCalculation
     * @param ConfigInterface $config
     */
    public function __construct(
        RemainingCostCalculationInterface $remainingCostCalculation,
        ConfigInterface $config
    ) {
        $this->remainingCostCalculation = $remainingCostCalculation;
        $this->config = $config;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        $remainingCost = $this->remainingCostCalculation->getRemainingCost();
        $result = [
            RemainingCostInterface::MESSAGE => $remainingCost->getMessage(),
            RemainingCostInterface::VALUE => $remainingCost->getValue()
        ];

        return $this->config->isEnabled() ? $result : [];
    }
}
