<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api\Data;

interface ConfigInterface
{
    /**
     * Enabled config path
     */
    public const XML_PATH_ENABLED = 'free_shipping_remaining_cost_settings/base_config/enabled';

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool;
}
