<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Helper;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;

class CalculationHelper
{
    /**
     * @var PriceCurrencyInterface
     */
    private PriceCurrencyInterface $priceCurrency;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor
     *
     * @param PriceCurrencyInterface $priceCurrency
     * @param ConfigInterface $config
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        ConfigInterface $config
    ) {
        $this->priceCurrency = $priceCurrency;
        $this->config = $config;
    }

    /**
     * Get formated message
     *
     * @param float $remainingCost
     * @return string
     */
    public function getFormattedMessage(float $remainingCost): string
    {
        $remainingCost = $this->priceCurrency->format($remainingCost);

        return str_replace('%s', $remainingCost, $this->config->getNotificationMessage());
    }
}
