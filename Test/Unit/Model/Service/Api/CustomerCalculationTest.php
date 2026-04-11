<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model\Service\Api;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Model\Service\Api\CustomerCalculation;
use Space\FreeShippingRemainingCost\Model\Service\InfoProvider;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterfaceFactory;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

class CustomerCalculationTest extends TestCase
{
    /**
     * @var CustomerCalculation
     */
    private CustomerCalculation $model;

    /**
     * @var RemainingCostInterfaceFactory|MockObject
     */
    private RemainingCostInterfaceFactory|MockObject $factoryMock;

    /**
     * @var CartManagementInterface|MockObject
     */
    private CartManagementInterface|MockObject $cartManagementMock;

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

        $this->cartManagementMock = $this->createMock(CartManagementInterface::class);
        $this->infoProviderMock = $this->createMock(InfoProvider::class);

        $this->model = new CustomerCalculation(
            $this->factoryMock,
            $this->cartManagementMock,
            $this->infoProviderMock
        );
    }

    public function testGetSuccess(): void
    {
        $customerId = 1;
        $subtotal = 75.0;
        $remainingValue = 25.0;
        $message = "Only $25.00 left for free shipping!";

        $remainingCostDataObjectMock = $this->createMock(RemainingCostInterface::class);
        $this->factoryMock->expects($this->once())
            ->method('create')
            ->willReturn($remainingCostDataObjectMock);

        $quoteMock = $this->createMock(Quote::class);
        $addressMock = $this->getMockBuilder(Address::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getSubtotalWithDiscount'])
            ->getMock();

        $this->cartManagementMock->expects($this->once())
            ->method('getCartForCustomer')
            ->with($customerId)
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

        $result = $this->model->get($customerId);
        $this->assertSame($remainingCostDataObjectMock, $result);
    }
}
