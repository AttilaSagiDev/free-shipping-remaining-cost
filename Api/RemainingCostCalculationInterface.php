<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api;

use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

/**
 * Remaining cost calculation interface for carts
 * @api
 * @since 1.0.0
 */
interface RemainingCostCalculationInterface
{
    /**
     * Get remaining cost
     *
     * @return \Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface
     */
    public function getRemainingCost(): RemainingCostInterface;
}
