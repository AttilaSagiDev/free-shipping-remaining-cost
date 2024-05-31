<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api\Data;

interface RemainingCostInterface
{
    /**
     * Constants for keys of data array
     */
    public const MESSAGE = 'message';
    public const VALUE = 'value';

    /**
     * Get remaining cost message
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get remaining cost value
     *
     * @return float
     */
    public function getValue(): float;

    /**
     * Set message
     *
     * @param string $message
     * @return RemainingCostInterface
     */
    public function setMessage(string $message): RemainingCostInterface;

    /**
     * Set remaining cost value
     *
     * @param float $value
     * @return RemainingCostInterface
     */
    public function setValue(float $value): RemainingCostInterface;
}
