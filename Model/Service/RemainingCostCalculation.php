<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service;

use Space\FreeShippingRemainingCost\Api\RemainingCostCalculationInterface;
use Magento\Checkout\Model\Session;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Psr\Log\LoggerInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class RemainingCostCalculation implements RemainingCostCalculationInterface
{
    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @var RemainingCostInterfaceFactory
     */
    private RemainingCostInterfaceFactory $remainingCostCalculationFactory;

    /**
     * @var InfoProvider
     */
    private InfoProvider $infoProvider;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param Session $checkoutSession
     * @param RemainingCostInterfaceFactory $remainingCostCalculationFactory
     * @param InfoProvider $infoProvider
     * @param LoggerInterface $logger
     */
    public function __construct(
        Session $checkoutSession,
        RemainingCostInterfaceFactory $remainingCostCalculationFactory,
        InfoProvider $infoProvider,
        LoggerInterface $logger
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->remainingCostCalculationFactory = $remainingCostCalculationFactory;
        $this->infoProvider = $infoProvider;
        $this->logger = $logger;
    }

    /**
     * Get remaining cost message
     *
     * @return RemainingCostInterface
     */
    public function getRemainingCost(): RemainingCostInterface
    {
        $remainingCost = $this->remainingCostCalculationFactory->create();
        try {
            $quote = $this->checkoutSession->getQuote();
            $subtotal = $quote->getShippingAddress()->getSubtotalWithDiscount();
            $remainingCostValue = $this->infoProvider->getRemainingCostValue($quote, $subtotal);
            $remainingCost->setMessage($this->infoProvider->getMessage($remainingCostValue, $subtotal));
            $remainingCost->setValue($remainingCostValue);
        } catch (LocalizedException|NoSuchEntityException $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $remainingCost;
    }
}
