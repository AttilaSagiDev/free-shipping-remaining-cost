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
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param Session $checkoutSession
     * @param ConfigInterface $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        Session $checkoutSession,
        ConfigInterface $config,
        LoggerInterface $logger
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->config = $config;
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
            $remainingCostValue = $this->getRemainingCostValue();
            $remainingCost['message'] = $this->getMessage($remainingCostValue);
            $remainingCost['value'] = $remainingCostValue;
        } catch (LocalizedException|NoSuchEntityException $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $remainingCost;
    }

    /**
     * Get remaining cost value
     *
     * @return float
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getRemainingCostValue(): float
    {
        $remainingCostValue = 0;

        $this->logger->debug('Calculation INFO quote id: ' . $this->checkoutSession->getQuote()->getId());
        $quote = $this->checkoutSession->getQuote();
        $subtotal = $quote->getSubtotalWithDiscount();
        if ($this->config->isUseFreeShippingAmount()
            && $this->config->isFreeShippingMethodEnabled()
            && $this->config->getFreeShippingMethodAmount() > 0
            && $subtotal > 0
            && !$quote->getShippingAddress()->getFreeShipping()
        ) {
            $remainingCostValue = $this->config->getFreeShippingMethodAmount() - $subtotal;
        }

        return max($remainingCostValue, 0);
    }

    /**
     * Get message
     *
     * @param float $remainingCost
     * @return string
     */
    private function getMessage(float $remainingCost): string
    {
        return $remainingCost > 0
            ? str_replace('%s', (string)$remainingCost, $this->config->getNotificationMessage())
            : $this->config->getSuccessMessage();
    }
}
