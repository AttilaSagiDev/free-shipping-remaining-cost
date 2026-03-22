<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Config\Source;

use PHPUnit\Framework\TestCase;
use Space\FreeShippingRemainingCost\Model\Config\Source\Position;

class PositionTest extends TestCase
{
    /**
     * @var Position
     */
    private Position $model;

    protected function setUp(): void
    {
        $this->model = new Position();
    }

    public function testToOptionArray(): void
    {
        $options = $this->model->toOptionArray();

        $this->assertCount(2, $options);

        $expected = [
            [
                'value' => Position::SHOW_ON_TOP,
                'label' => 'Show in content top as message'
            ],
            [
                'value' => Position::SHOW_IN_SIDEBAR,
                'label' => 'Show in sidebar as block'
            ]
        ];

        foreach ($expected as $index => $expectedOption) {
            $this->assertEquals($expectedOption['value'], $options[$index]['value']);

            $this->assertEquals($expectedOption['label'], (string)$options[$index]['label']);
        }
    }
}
