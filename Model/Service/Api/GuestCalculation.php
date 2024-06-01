<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service\Api;

use Space\FreeShippingRemainingCost\Api\GuestCalculationInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GuestCalculation implements GuestCalculationInterface
{
    /**
     * @var RemainingCostInterfaceFactory
     */
    private RemainingCostInterfaceFactory $remainingCostCalculationFactory;

    /**
     * @var GuestCartRepositoryInterface
     */
    private GuestCartRepositoryInterface $guestCartRepository;

    /**
     * @var InfoProvider
     */
    private InfoProvider $infoProvider;

    /**
     * Constructor
     *
     * @param RemainingCostInterfaceFactory $remainingCostCalculationFactory
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param InfoProvider $infoProvider
     */
    public function __construct(
        RemainingCostInterfaceFactory $remainingCostCalculationFactory,
        GuestCartRepositoryInterface $guestCartRepository,
        InfoProvider $infoProvider
    ) {
        $this->remainingCostCalculationFactory = $remainingCostCalculationFactory;
        $this->guestCartRepository = $guestCartRepository;
        $this->infoProvider = $infoProvider;
    }

    /**
     * Get remaining cost by cart ID for web api
     *
     * @param string $cartId
     * @return RemainingCostInterface
     * @throws NoSuchEntityException
     */
    public function get(string $cartId): RemainingCostInterface
    {
        $remainingCost = $this->remainingCostCalculationFactory->create();

        $quote = $this->guestCartRepository->get($cartId);
        $subtotal = $quote->getShippingAddress()->getSubtotalWithDiscount();
        $remainingCostValue = $this->infoProvider->getRemainingCostValue($quote, $subtotal);
        $remainingCost->setMessage($this->infoProvider->getMessage($remainingCostValue, $subtotal));
        $remainingCost->setValue($remainingCostValue);

        return $remainingCost;
    }
}
