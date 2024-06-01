<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service\Api;

use Space\FreeShippingRemainingCost\Api\CustomerCalculationInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Magento\Quote\Api\CartManagementInterface;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomerCalculation implements CustomerCalculationInterface
{
    /**
     * @var RemainingCostInterfaceFactory
     */
    private RemainingCostInterfaceFactory $remainingCostCalculationFactory;

    /**
     * @var CartManagementInterface
     */
    private CartManagementInterface $cartManagement;

    /**
     * @var InfoProvider
     */
    private InfoProvider $infoProvider;

    /**
     * Constructor
     *
     * @param RemainingCostInterfaceFactory $remainingCostCalculationFactory
     * @param CartManagementInterface $cartManagement
     * @param InfoProvider $infoProvider
     */
    public function __construct(
        RemainingCostInterfaceFactory $remainingCostCalculationFactory,
        CartManagementInterface $cartManagement,
        InfoProvider $infoProvider
    ) {
        $this->remainingCostCalculationFactory = $remainingCostCalculationFactory;
        $this->cartManagement = $cartManagement;
        $this->infoProvider = $infoProvider;
    }

    /**
     * Get customer remaining cost for web api
     *
     * @param int $customerId
     * @return RemainingCostInterface
     * @throws NoSuchEntityException
     */
    public function get(int $customerId): RemainingCostInterface
    {
        $remainingCost = $this->remainingCostCalculationFactory->create();

        $quote = $this->cartManagement->getCartForCustomer($customerId);
        $subtotal = $quote->getShippingAddress()->getSubtotalWithDiscount();
        $remainingCostValue = $this->infoProvider->getRemainingCostValue($quote, $subtotal);
        $remainingCost->setMessage($this->infoProvider->getMessage($remainingCostValue, $subtotal));
        $remainingCost->setValue($remainingCostValue);

        return $remainingCost;
    }
}
