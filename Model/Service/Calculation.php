<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service;

use Space\FreeShippingRemainingCost\Api\CalculationInterface;
use Magento\Checkout\Model\Session;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote;

class Calculation implements CalculationInterface
{
    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var CalculationHelper
     */
    private CalculationHelper $calculationHelper;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param Session $checkoutSession
     * @param ConfigInterface $config
     * @param CalculationHelper $calculationHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Session $checkoutSession,
        ConfigInterface $config,
        CalculationHelper $calculationHelper,
        LoggerInterface $logger
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->config = $config;
        $this->calculationHelper = $calculationHelper;
        $this->logger = $logger;
    }

    /**
     * Get remaining cost message
     *
     * @return array
     */
    public function getRemainingCostMessage(): array
    {
        $remainingCost = [];
        try {
            $quote = $this->checkoutSession->getQuote();
            $subtotal = $quote->getSubtotalWithDiscount();
            $remainingCostValue = $this->getRemainingCostValue($quote, (float)$subtotal);
            $remainingCost['message'] = $this->getMessage($remainingCostValue, (float)$subtotal);
            $remainingCost['value'] = $remainingCostValue;
        } catch (LocalizedException|NoSuchEntityException $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $remainingCost;
    }

    /**
     * Get remaining cost value
     *
     * @param Quote $quote
     * @param float $subtotal
     * @return float
     */
    private function getRemainingCostValue(Quote $quote, float $subtotal): float
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
    private function getMessage(float $remainingCost, float $subtotal): string
    {
        if (!$subtotal && $this->config->isShowIfCartEmpty()) {
            return $this->calculationHelper->getFormattedMessage($remainingCost);
        } elseif (!$subtotal && !$this->config->isShowIfCartEmpty()) {
            return '';
        }

        return $remainingCost > 0 && $remainingCost > $subtotal
            ? $this->calculationHelper->getFormattedMessage($remainingCost)
            : $this->config->getSuccessMessage();
    }
}
