<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\CustomerData;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\CustomerData\ShippingRemainingCost;
use Space\FreeShippingRemainingCost\Api\RemainingCostCalculationInterface;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

class ShippingRemainingCostTest extends TestCase
{
    /**
     * @var ShippingRemainingCost
     */
    private ShippingRemainingCost $model;

    /**
     * @var RemainingCostCalculationInterface|MockObject
     */
    private RemainingCostCalculationInterface|MockObject $calculationMock;

    /**
     * @var ConfigInterface|MockObject
     */
    private ConfigInterface|MockObject $configMock;

    protected function setUp(): void
    {
        $this->calculationMock = $this->createMock(RemainingCostCalculationInterface::class);
        $this->configMock = $this->createMock(ConfigInterface::class);

        $this->model = new ShippingRemainingCost(
            $this->calculationMock,
            $this->configMock
        );
    }

    public function testGetSectionDataWhenEnabled(): void
    {
        $message = "You are $10 away from free shipping!";
        $value = 10.0;

        $remainingCostMock = $this->createMock(RemainingCostInterface::class);
        $remainingCostMock->method('getMessage')->willReturn($message);
        $remainingCostMock->method('getValue')->willReturn($value);

        $this->calculationMock->expects($this->once())
            ->method('getRemainingCost')
            ->willReturn($remainingCostMock);

        $this->configMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $expectedResult = [
            RemainingCostInterface::MESSAGE => $message,
            RemainingCostInterface::VALUE => $value
        ];

        $this->assertEquals($expectedResult, $this->model->getSectionData());
    }

    public function testGetSectionDataWhenDisabled(): void
    {
        $remainingCostMock = $this->createMock(RemainingCostInterface::class);
        $this->calculationMock->method('getRemainingCost')->willReturn($remainingCostMock);

        $this->configMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(false);

        $this->assertEquals([], $this->model->getSectionData());
    }
}
