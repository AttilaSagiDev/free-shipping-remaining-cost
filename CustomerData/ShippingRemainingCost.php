<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Space\FreeShippingRemainingCost\Model\Service\Calculation;

class ShippingRemainingCost implements SectionSourceInterface
{
    /**
     * @var Calculation
     */
    private Calculation $calculation;

    /**
     * Constructor
     *
     * @param Calculation $calculation
     */
    public function __construct(
        Calculation $calculation
    ) {
        $this->calculation = $calculation;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        return $this->calculation->getRemainingCostMessage();
    }
}
