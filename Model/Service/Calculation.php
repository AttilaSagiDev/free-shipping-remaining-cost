<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Service;

use Space\FreeShippingRemainingCost\Api\CalculationInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Calculation implements CalculationInterface
{
    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * Constructor
     *
     * @param Session $checkoutSession
     */
    public function __construct(
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Get remaining cost message
     *
     * @return string
     */
    public function getRemainingCostMessage(): string
    {
        return 'CalculationInterface message';
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
        $quote = $this->checkoutSession->getQuote();

        return $quote->getSubtotal();
    }
}
