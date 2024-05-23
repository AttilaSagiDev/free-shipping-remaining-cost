<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Layouts implements OptionSourceInterface
{
    /**
     * Category page layout
     */
    public const LAYOUT_CATEGORY_PAGE = 'catalog_category_view';

    /**
     * Product page layout
     */
    public const LAYOUT_PRODUCT_PAGE = 'catalog_product_view';

    /**
     * Cart page layout
     */
    public const LAYOUT_CART_PAGE = 'checkout_cart_index';

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Category Page'),
                'value' => self::LAYOUT_CATEGORY_PAGE,
            ],
            [
                'label' => __('Product Page'),
                'value' => self::LAYOUT_PRODUCT_PAGE,
            ],
            [
                'label' => __('Cart'),
                'value' => self::LAYOUT_CART_PAGE,
            ]
        ];
    }
}
