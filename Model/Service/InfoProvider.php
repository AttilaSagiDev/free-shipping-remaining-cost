<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service;

use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\CartInterface;

class InfoProvider
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var CalculationHelper
     */
    private CalculationHelper $calculationHelper;

    /**
     * Constructor
     *
     * @param ConfigInterface $config
     * @param CalculationHelper $calculationHelper
     */
    public function __construct(
        ConfigInterface $config,
        CalculationHelper $calculationHelper
    ) {
        $this->config = $config;
        $this->calculationHelper = $calculationHelper;
    }

    /**
     * Get remaining cost value
     *
     * @param Quote|CartInterface $quote
     * @param float $subtotal
     * @return float
     */
    public function getRemainingCostValue(Quote|CartInterface $quote, float $subtotal): float
    {
        $remainingCostValue = $this->config->getCustomAmount();

        if ($this->config->isUseFreeShippingAmount()
            && $this->config->isFreeShippingMethodEnabled()
            && $this->config->getFreeShippingMethodAmount() > 0
        ) {
            $remainingCostValue = $this->config->getFreeShippingMethodAmount();
        }

        if ($subtotal > 0
            && !$quote->getShippingAddress()->getFreeShipping()
        ) {
            $remainingCostValue = $this->config->isUseFreeShippingAmount()
                ? $this->config->getFreeShippingMethodAmount() - $subtotal
                : $remainingCostValue - $subtotal;
        } elseif ($subtotal > 0 && $quote->getShippingAddress()->getFreeShipping()) {
            $remainingCostValue = 0;
        }

        return max($remainingCostValue, 0);
    }

    /**
     * Get message
     *
     * @param float $remainingCost
     * @param float $subtotal
     * @return string
     */
    public function getMessage(float $remainingCost, float $subtotal): string
    {
        if (!$subtotal && !$this->config->isShowIfCartEmpty()) {
            return '';
        }

        return $remainingCost > 0
            ? $this->calculationHelper->getFormattedMessage($remainingCost)
            : $this->config->getSuccessMessage();
    }
}
