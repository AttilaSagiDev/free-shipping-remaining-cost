<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api;

use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

interface RemainingCostCalculationInterface
{
    /**
     * Get remaining cost
     *
     * @return RemainingCostInterface
     */
    public function getRemainingCost(): RemainingCostInterface;
}
