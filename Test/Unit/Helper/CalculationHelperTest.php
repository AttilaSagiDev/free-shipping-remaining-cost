<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Helper;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;

class CalculationHelperTest extends TestCase
{
    /**
     * @var CalculationHelper
     */
    private CalculationHelper $model;

    /**
     * @var PriceCurrencyInterface|MockObject
     */
    private PriceCurrencyInterface|MockObject $priceCurrencyMock;

    /**
     * @var ConfigInterface|MockObject
     */
    private ConfigInterface|MockObject $configMock;

    protected function setUp(): void
    {
        $this->priceCurrencyMock = $this->createMock(PriceCurrencyInterface::class);
        $this->configMock = $this->createMock(ConfigInterface::class);

        $this->model = new CalculationHelper(
            $this->priceCurrencyMock,
            $this->configMock
        );
    }

    public function testGetFormattedMessage()
    {
        $remainingAmount = 15.50;
        $formattedPrice = "$15.50";
        $configMessage = "Spend %s more for free shipping!";
        $expectedResult = "Spend $15.50 more for free shipping!";

        $this->priceCurrencyMock->expects($this->once())
            ->method('format')
            ->with($remainingAmount)
            ->willReturn($formattedPrice);

        $this->configMock->expects($this->once())
            ->method('getNotificationMessage')
            ->willReturn($configMessage);

        $result = $this->model->getFormattedMessage($remainingAmount);

        $this->assertEquals($expectedResult, $result);
    }
}
