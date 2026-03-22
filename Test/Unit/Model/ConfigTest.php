<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Space\FreeShippingRemainingCost\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigTest extends TestCase
{
    /** @var Config */
    private $model;

    /** @var ScopeConfigInterface|MockObject */
    private $scopeConfigMock;

    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new Config($this->scopeConfigMock);
    }

    /**
     * Test boolean flag retrieval
     * * @dataProvider booleanFlagProvider
     */
    public function testBooleanFlags(string $method, string $xmlPath, bool $expected): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with($xmlPath, ScopeInterface::SCOPE_STORE)
            ->willReturn($expected);

        $this->assertEquals($expected, $this->model->$method());
    }

    /**
     * Test float value retrieval and casting using the real interface constant
     */
    public function testGetCustomAmountCastsToFloat(): void
    {
        // Use the constant from your Interface to ensure the XML path matches exactly
        $xmlPath = \Space\FreeShippingRemainingCost\Api\Data\ConfigInterface::XML_PATH_CUSTOM_AMOUNT;

        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with($xmlPath, ScopeInterface::SCOPE_STORE)
            ->willReturn("49.90");

        $result = $this->model->getCustomAmount();

        // Verify both the value and the type casting (string "49.90" -> float 49.9)
        $this->assertIsFloat($result);
        $this->assertEquals(49.90, $result);
    }

    /**
     * Test the conditional success message logic
     */
    public function testGetSuccessMessageReturnsEmptyIfDisabled(): void
    {
        // First call checks isShowSuccessMessage
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->willReturn(false);

        //getValue should never be called if isShowSuccessMessage is false
        $this->scopeConfigMock->expects($this->never())
            ->method('getValue');

        $this->assertEquals('', $this->model->getSuccessMessage());
    }

    /**
     * Test comma-separated string conversion to array
     */
    public function testGetPagesToShowExplodesString(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->willReturn('checkout_index_index,catalog_product_view');

        $expected = ['checkout_index_index', 'catalog_product_view'];
        $this->assertEquals($expected, $this->model->getPagesToShow());
    }

    /**
     * Data provider for simple flag methods
     */
    public function booleanFlagProvider(): array
    {
        // Use the Constants from your Interface instead of hardcoded strings
        return [
            [
                'isEnabled',
                \Space\FreeShippingRemainingCost\Api\Data\ConfigInterface::XML_PATH_ENABLED,
                true
            ],
            [
                'isShowIfCartEmpty',
                \Space\FreeShippingRemainingCost\Api\Data\ConfigInterface::XML_PATH_SHOW_IF_CART_EMPTY,
                false
            ],
            [
                'isShowSuccessMessage',
                \Space\FreeShippingRemainingCost\Api\Data\ConfigInterface::XML_PATH_DISPLAY_SHOW_SUCCESS_MESSAGE,
                true
            ]
        ];
    }
}
