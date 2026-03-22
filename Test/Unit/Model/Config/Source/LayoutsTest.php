<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Config\Source;

use PHPUnit\Framework\TestCase;
use Space\FreeShippingRemainingCost\Model\Config\Source\Layouts;

class LayoutsTest extends TestCase
{
    /**
     * @var Layouts
     */
    private Layouts $model;

    protected function setUp(): void
    {
        $this->model = new Layouts();
    }

    public function testToOptionArray(): void
    {
        $options = $this->model->toOptionArray();

        $this->assertCount(3, $options);

        $expected = [
            [
                'value' => Layouts::LAYOUT_CATEGORY_PAGE,
                'label' => 'Category Page'
            ],
            [
                'value' => Layouts::LAYOUT_PRODUCT_PAGE,
                'label' => 'Product Page'
            ],
            [
                'value' => Layouts::LAYOUT_CART_PAGE,
                'label' => 'Cart'
            ]
        ];

        foreach ($expected as $index => $expectedOption) {
            $this->assertEquals($expectedOption['value'], $options[$index]['value']);

            $this->assertEquals($expectedOption['label'], (string)$options[$index]['label']);
        }
    }
}
