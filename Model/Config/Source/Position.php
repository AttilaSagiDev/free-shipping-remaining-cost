<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Position implements OptionSourceInterface
{
    /**
     * Show notification in content top
     */
    public const SHOW_ON_TOP = 0;

    /**
     * Show notification in sidebar
     */
    public const SHOW_IN_SIDEBAR = 1;

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::SHOW_ON_TOP,
                'label' => __('Show in content top as message')
            ],
            [
                'value' => self::SHOW_IN_SIDEBAR,
                'label' => __('Show in sidebar as block')
            ]
        ];
    }
}
