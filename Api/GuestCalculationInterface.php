<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api;

use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

/**
 * Remaining cost calculation interface for guest carts
 * @api
 * @since 1.0.0
 */
interface GuestCalculationInterface
{
    /**
     * Get remaining cost by cart ID for web api
     *
     * @param string $cartId
     * @return \Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface
     */
    public function get(string $cartId): RemainingCostInterface;
}
