<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Model\Service\RemainingCostCalculation;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Magento\Checkout\Model\Session;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;

class RemainingCostCalculationTest extends TestCase
{
    /**
     * @var RemainingCostCalculation
     */
    private RemainingCostCalculation $model;

    /**
     * @var Session|MockObject
     */
    private Session|MockObject $checkoutSessionMock;

    /**
     * @var RemainingCostInterfaceFactory|MockObject
     */
    private RemainingCostInterfaceFactory|MockObject $factoryMock;

    /**
     * @var InfoProvider|MockObject
     */
    private InfoProvider|MockObject $infoProviderMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private LoggerInterface|MockObject $loggerMock;

    protected function setUp(): void
    {
        $this->checkoutSessionMock = $this->createMock(Session::class);

        $this->factoryMock = $this->getMockBuilder(RemainingCostInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();

        $this->infoProviderMock = $this->createMock(InfoProvider::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->model = new RemainingCostCalculation(
            $this->checkoutSessionMock,
            $this->factoryMock,
            $this->infoProviderMock,
            $this->loggerMock
        );
    }

    public function testGetRemainingCostSuccess(): void
    {
        $subtotal = 45.00;
        $remainingValue = 5.00;
        $message = "Spend $5.00 more for free shipping!";

        $remainingCostDataObjectMock = $this->createMock(RemainingCostInterface::class);
        $this->factoryMock->expects($this->once())
            ->method('create')
            ->willReturn($remainingCostDataObjectMock);

        $quoteMock = $this->createMock(Quote::class);

        $addressMock = $this->getMockBuilder(Address::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getSubtotalWithDiscount'])
            ->getMock();

        $this->checkoutSessionMock->expects($this->once())
            ->method('getQuote')
            ->willReturn($quoteMock);

        $quoteMock->expects($this->once())
            ->method('getShippingAddress')
            ->willReturn($addressMock);

        $addressMock->expects($this->once())
            ->method('getSubtotalWithDiscount')
            ->willReturn($subtotal);

        $this->infoProviderMock->expects($this->once())
            ->method('getRemainingCostValue')
            ->with($quoteMock, $subtotal)
            ->willReturn($remainingValue);

        $this->infoProviderMock->expects($this->once())
            ->method('getMessage')
            ->with($remainingValue, $subtotal)
            ->willReturn($message);

        $remainingCostDataObjectMock->expects($this->once())
            ->method('setMessage')
            ->with($message);
        $remainingCostDataObjectMock->expects($this->once())
            ->method('setValue')
            ->with($remainingValue);

        $result = $this->model->getRemainingCost();
        $this->assertSame($remainingCostDataObjectMock, $result);
    }

    public function testGetRemainingCostHandlesException(): void
    {
        $exceptionMessage = 'Something went wrong';
        $remainingCostDataObjectMock = $this->createMock(RemainingCostInterface::class);

        $this->factoryMock->method('create')->willReturn($remainingCostDataObjectMock);

        $this->checkoutSessionMock->expects($this->once())
            ->method('getQuote')
            ->willThrowException(new LocalizedException(__($exceptionMessage)));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $result = $this->model->getRemainingCost();
        $this->assertSame($remainingCostDataObjectMock, $result);
    }
}
