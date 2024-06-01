<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api;

use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

/**
 * Remaining cost calculation interface for customer cart
 * @api
 * @since 1.0.0
 */
interface CustomerCalculationInterface
{
    /**
     * Get customer remaining cost for web api
     *
     * @param int $customerId
     * @return \Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface
     */
    public function get(int $customerId): RemainingCostInterface;
}
