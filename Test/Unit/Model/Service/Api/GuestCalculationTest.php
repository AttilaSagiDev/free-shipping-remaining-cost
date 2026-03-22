<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Service\Api;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Model\Service\Api\GuestCalculation;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

class GuestCalculationTest extends TestCase
{
    /**
     * @var GuestCalculation
     */
    private GuestCalculation $model;

    /**
     * @var RemainingCostInterfaceFactory|MockObject
     */
    private RemainingCostInterfaceFactory|MockObject $factoryMock;

    /**
     * @var GuestCartRepositoryInterface|MockObject
     */
    private GuestCartRepositoryInterface|MockObject $guestCartRepositoryMock;

    /**
     * @var InfoProvider|MockObject
     */
    private InfoProvider|MockObject $infoProviderMock;

    protected function setUp(): void
    {
        $this->factoryMock = $this->getMockBuilder(RemainingCostInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();

        $this->guestCartRepositoryMock = $this->createMock(GuestCartRepositoryInterface::class);
        $this->infoProviderMock = $this->createMock(InfoProvider::class);

        $this->model = new GuestCalculation(
            $this->factoryMock,
            $this->guestCartRepositoryMock,
            $this->infoProviderMock
        );
    }

    public function testGetSuccess(): void
    {
        $cartId = 'guest_masked_id_123';
        $subtotal = 30.0;
        $remainingValue = 20.0;
        $message = "Add $20.00 more to qualify for free shipping!";

        $remainingCostDataObjectMock = $this->createMock(RemainingCostInterface::class);
        $this->factoryMock->expects($this->once())
            ->method('create')
            ->willReturn($remainingCostDataObjectMock);

        $quoteMock = $this->createMock(Quote::class);
        $addressMock = $this->getMockBuilder(Address::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getSubtotalWithDiscount'])
            ->getMock();

        $this->guestCartRepositoryMock->expects($this->once())
            ->method('get')
            ->with($cartId)
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

        $result = $this->model->get($cartId);
        $this->assertSame($remainingCostDataObjectMock, $result);
    }
}
