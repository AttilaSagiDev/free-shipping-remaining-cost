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

    /**
     * Check if Magento free shipping delivery method enabled
     *
     * @return bool
     */
    public function isFreeShippingMethodEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_FREE_SHIPPING_METHOD_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Magento free shipping delivery method minimum order amount
     *
     * @return float
     */
    public function getFreeShippingMethodAmount(): float
    {
        return (float)$this->scopeConfig->getValue(
            self::XML_PATH_FREE_SHIPPING_METHOD_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get block title
     *
     * @return string
     */
    public function getBlockTitle(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_DISPLAY_BLOCK_TITLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get notification message
     *
     * @return string
     */
    public function getNotificationMessage(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_DISPLAY_NOTIFICATION_MESSAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if show success message
     *
     * @return bool
     */
    public function isShowSuccessMessage(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_DISPLAY_SHOW_SUCCESS_MESSAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get success message
     *
     * @return string
     */
    public function getSuccessMessage(): string
    {
        if ($this->isShowSuccessMessage()) {
            return (string)$this->scopeConfig->getValue(
                self::XML_PATH_DISPLAY_SUCCESS_MESSAGE,
                ScopeInterface::SCOPE_STORE
            );
        }

        return '';
    }

    /**
     * Get pages to show
     *
     * @return array
     */
    public function getPagesToShow(): array
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_PAGES_TO_SHOW,
            ScopeInterface::SCOPE_STORE
        );

        return $value ? explode(',', $value) : [];
    }

    /**
     * Get position to show on category pages
     *
     * @return int
     */
    public function getPositionToShow(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_POSITION_TO_SHOW,
            ScopeInterface::SCOPE_STORE
        );
    }
}
