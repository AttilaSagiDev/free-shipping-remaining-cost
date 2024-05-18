<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model;

use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check using Magento free shipping delivery method for amount
     *
     * @return bool
     */
    public function isUseFreeShippingAmount(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_USE_FREE_SHIPPING_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get custom amount for calculation
     *
     * @return float
     */
    public function getCustomAmount(): float
    {
        return (float)$this->scopeConfig->getValue(
            self::XML_PATH_CUSTOM_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Show if cart is empty
     *
     * @return bool
     */
    public function isShowIfCartEmpty(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SHOW_IF_CART_EMPTY,
            ScopeInterface::SCOPE_STORE
        );
    }
}
