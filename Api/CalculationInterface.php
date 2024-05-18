<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api;

interface CalculationInterface
{
    /**
     * Get remaining cost message
     *
     * @return array
     */
    public function getRemainingCostMessage(): array;
}
