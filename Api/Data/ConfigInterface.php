<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Api\Data;

interface ConfigInterface
{
    /**
     * Enabled config path
     */
    public const XML_PATH_ENABLED = 'free_shipping_remaining_cost_settings/base_config/enabled';

    /**
     * Magento free shipping amount config path
     */
    public const XML_PATH_USE_FREE_SHIPPING_AMOUNT
        = 'free_shipping_remaining_cost_settings/common_config/use_free_shipping_method';

    /**
     * Custom amount config path
     */
    public const XML_PATH_CUSTOM_AMOUNT = 'free_shipping_remaining_cost_settings/common_config/custom_amount';

    /**
     * Custom amount config path
     */
    public const XML_PATH_SHOW_IF_CART_EMPTY
        = 'free_shipping_remaining_cost_settings/common_config/show_if_cart_is_empty';

    /**
     * Free shipping delivery method active config path
     */
    public const XML_PATH_FREE_SHIPPING_METHOD_ENABLED = 'carriers/freeshipping/active';

    /**
     * Free shipping delivery method amount config path
     */
    public const XML_PATH_FREE_SHIPPING_METHOD_AMOUNT = 'carriers/freeshipping/free_shipping_subtotal';

    /**
     * Block title config path
     */
    public const XML_PATH_DISPLAY_BLOCK_TITLE = 'free_shipping_remaining_cost_settings/display_config/block_title';

    /**
     * Notification message config path
     */
    public const XML_PATH_DISPLAY_NOTIFICATION_MESSAGE
        = 'free_shipping_remaining_cost_settings/display_config/notification_message';

    /**
     * Show success message config path
     */
    public const XML_PATH_DISPLAY_SHOW_SUCCESS_MESSAGE
        = 'free_shipping_remaining_cost_settings/display_config/show_success_message';

    /**
     * Success message config path
     */
    public const XML_PATH_DISPLAY_SUCCESS_MESSAGE
        = 'free_shipping_remaining_cost_settings/display_config/success_message';

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Check using Magento free shipping delivery method for amount
     *
     * @return bool
     */
    public function isUseFreeShippingAmount(): bool;

    /**
     * Get custom amount for calculation
     *
     * @return float
     */
    public function getCustomAmount(): float;

    /**
     * Show if cart is empty
     *
     * @return bool
     */
    public function isShowIfCartEmpty(): bool;

    /**
     * Check if Magento free shipping delivery method enabled
     *
     * @return bool
     */
    public function isFreeShippingMethodEnabled(): bool;

    /**
     * Get Magento free shipping delivery method minimum order amount
     *
     * @return float
     */
    public function getFreeShippingMethodAmount(): float;

    /**
     * Get block title
     *
     * @return string
     */
    public function getBlockTitle(): string;

    /**
     * Get notification message
     *
     * @return string
     */
    public function getNotificationMessage(): string;

    /**
     * Check if show success message
     *
     * @return bool
     */
    public function isShowSuccessMessage(): bool;

    /**
     * Get success message
     *
     * @return string
     */
    public function getSuccessMessage(): string;
}
