<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private Config $model;

    /**
     * @var ScopeConfigInterface|MockObject
     */
    private ScopeConfigInterface|MockObject $scopeConfigMock;

    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);

        $this->model = new Config($this->scopeConfigMock);
    }

    /**
     * @dataProvider booleanFlagProvider
     */
    public function testBooleanFlags(string $method, string $xmlPath, bool $expected): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with($xmlPath, ScopeInterface::SCOPE_STORE)
            ->willReturn($expected);

        $this->assertEquals($expected, $this->model->$method());
    }

    public function testGetCustomAmountCastsToFloat(): void
    {
        $xmlPath = ConfigInterface::XML_PATH_CUSTOM_AMOUNT;

        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with($xmlPath, ScopeInterface::SCOPE_STORE)
            ->willReturn("49.90");

        $result = $this->model->getCustomAmount();

        $this->assertIsFloat($result);
        $this->assertEquals(49.90, $result);
    }

    public function testGetSuccessMessageReturnsEmptyIfDisabled(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->willReturn(false);

        $this->scopeConfigMock->expects($this->never())
            ->method('getValue');

        $this->assertEquals('', $this->model->getSuccessMessage());
    }

    public function testGetPagesToShowExplodesString(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->willReturn('checkout_index_index,catalog_product_view');

        $expected = ['checkout_index_index', 'catalog_product_view'];
        $this->assertEquals($expected, $this->model->getPagesToShow());
    }

    public static function booleanFlagProvider(): array
    {
        return [
            'Is Enabled' => [
                'isEnabled',
                ConfigInterface::XML_PATH_ENABLED,
                true
            ],
            'Show if Cart Empty' => [
                'isShowIfCartEmpty',
                ConfigInterface::XML_PATH_SHOW_IF_CART_EMPTY,
                false
            ],
            'Show Success Message' => [
                'isShowSuccessMessage',
                ConfigInterface::XML_PATH_DISPLAY_SHOW_SUCCESS_MESSAGE,
                true
            ]
        ];
    }
}
