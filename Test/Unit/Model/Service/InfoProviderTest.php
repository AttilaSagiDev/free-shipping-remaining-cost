<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

class InfoProviderTest extends TestCase
{
    /**
     * @var InfoProvider
     */
    private InfoProvider $model;

    /**
     * @var ConfigInterface|MockObject
     */
    private ConfigInterface|MockObject $configMock;

    /**
     * @var CalculationHelper|MockObject
     */
    private CalculationHelper|MockObject $calculationHelperMock;

    /**
     * @var Quote|MockObject
     */
    private Quote|MockObject $quoteMock;

    /**
     * @var Address|MockObject
     */
    private Address|MockObject $addressMock;

    protected function setUp(): void
    {
        $this->configMock = $this->createMock(ConfigInterface::class);
        $this->calculationHelperMock = $this->createMock(CalculationHelper::class);
        $this->quoteMock = $this->createMock(Quote::class);

        $this->addressMock = $this->getMockBuilder(Address::class)
            ->disableOriginalConstructor()
            ->addMethods(['getFreeShipping'])
            ->getMock();

        $this->quoteMock->method('getShippingAddress')->willReturn($this->addressMock);

        $this->model = new InfoProvider(
            $this->configMock,
            $this->calculationHelperMock
        );
    }

    /**
     * @dataProvider remainingCostDataProvider
     */
    public function testGetRemainingCostValue(
        float $subtotal,
        bool $isFreeShipping,
        array $configValues,
        float $expected
    ): void {
        $this->configMock->method('getCustomAmount')->willReturn($configValues['custom_amount']);
        $this->configMock->method('isUseFreeShippingAmount')->willReturn($configValues['use_free_shipping']);
        $this->configMock->method('isFreeShippingMethodEnabled')->willReturn($configValues['method_enabled']);
        $this->configMock->method('getFreeShippingMethodAmount')->willReturn($configValues['method_amount']);

        $this->addressMock->method('getFreeShipping')->willReturn($isFreeShipping);

        $result = $this->model->getRemainingCostValue($this->quoteMock, $subtotal);
        $this->assertEquals($expected, $result);
    }

    public static function remainingCostDataProvider(): array
    {
        return [
            'Standard custom amount calculation' => [
                'subtotal' => 20.0,
                'isFreeShipping' => false,
                'configValues' => [
                    'custom_amount' => 100.0,
                    'use_free_shipping' => false,
                    'method_enabled' => false,
                    'method_amount' => 0.0
                ],
                'expected' => 80.0
            ],
            'Free shipping already achieved' => [
                'subtotal' => 50.0,
                'isFreeShipping' => true,
                'configValues' => [
                    'custom_amount' => 100.0,
                    'use_free_shipping' => false,
                    'method_enabled' => false,
                    'method_amount' => 0.0
                ],
                'expected' => 0.0
            ],
            'Using Free Shipping Method Amount' => [
                'subtotal' => 30.0,
                'isFreeShipping' => false,
                'configValues' => [
                    'custom_amount' => 100.0,
                    'use_free_shipping' => true,
                    'method_enabled' => true,
                    'method_amount' => 50.0
                ],
                'expected' => 20.0
            ]
        ];
    }

    public function testGetMessageReturnsSuccessWhenCostIsZero(): void
    {
        $this->configMock->expects($this->once())
            ->method('getSuccessMessage')
            ->willReturn('Free Shipping Achieved!');

        $result = $this->model->getMessage(0.0, 10.0);
        $this->assertEquals('Free Shipping Achieved!', $result);
    }

    public function testGetMessageReturnsEmptyIfCartEmptyAndConfigDisabled(): void
    {
        $this->configMock->method('isShowIfCartEmpty')->willReturn(false);

        $result = $this->model->getMessage(100.0, 0.0);
        $this->assertEquals('', $result);
    }
}
