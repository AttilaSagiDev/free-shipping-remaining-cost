<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Plugin\Config\Model;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Plugin\Config\Model\ValidateConfigPlugin;
use Magento\Config\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;

class ValidateConfigPluginTest extends TestCase
{
    /**
     * @var ValidateConfigPlugin
     */
    private ValidateConfigPlugin $plugin;

    /**
     * @var Config|MockObject
     */
    private Config|MockObject $subjectMock;

    protected function setUp(): void
    {
        $this->plugin = new ValidateConfigPlugin();

        $this->subjectMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->addMethods(['getSection'])
            ->onlyMethods(['getData', 'getConfigDataValue'])
            ->getMock();
    }

    public function testAroundSaveProceedsOnDifferentSection(): void
    {
        $this->subjectMock->method('getSection')->willReturn('some_other_section');

        $proceed = function () {
            return $this->subjectMock;
        };

        $result = $this->plugin->aroundSave($this->subjectMock, $proceed);
        $this->assertSame($this->subjectMock, $result);
    }

    public function testAroundSaveThrowsExceptionWhenMethodDisabled(): void
    {
        $this->subjectMock->method('getSection')->willReturn('free_shipping_remaining_cost_settings');
        $this->subjectMock->method('getData')->willReturn($this->getValidConfigData());

        $this->subjectMock->method('getConfigDataValue')
            ->with(ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_ENABLED)
            ->willReturn(false);

        $proceed = function () {
            return $this->subjectMock;
        };

        $this->expectException(LocalizedException::class);
        $this->expectExceptionMessage('Free Shipping delivery method disabled');

        $this->plugin->aroundSave($this->subjectMock, $proceed);
    }

    public function testAroundSaveThrowsExceptionWhenAmountEmpty(): void
    {
        $this->subjectMock->method('getSection')->willReturn('free_shipping_remaining_cost_settings');
        $this->subjectMock->method('getData')->willReturn($this->getValidConfigData());

        $this->subjectMock->method('getConfigDataValue')
            ->willReturnCallback(function ($path) {
                return match ($path) {
                    ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_ENABLED => true,
                    ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_AMOUNT => '',
                    default => null,
                };
            });

        $proceed = function () {
            return $this->subjectMock;
        };

        $this->expectException(LocalizedException::class);
        $this->expectExceptionMessage('Free Shipping delivery method minimum order amount cannot be empty or zero');

        $this->plugin->aroundSave($this->subjectMock, $proceed);
    }

    public function testAroundSaveSuccess(): void
    {
        $this->subjectMock->method('getSection')->willReturn('free_shipping_remaining_cost_settings');
        $this->subjectMock->method('getData')->willReturn($this->getValidConfigData());

        $this->subjectMock->method('getConfigDataValue')
            ->willReturnCallback(function ($path) {
                return match ($path) {
                    ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_ENABLED => true,
                    ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_AMOUNT => 100,
                    default => null,
                };
            });

        $called = false;
        $proceed = function () use (&$called) {
            $called = true;
            return $this->subjectMock;
        };

        $result = $this->plugin->aroundSave($this->subjectMock, $proceed);

        $this->assertTrue($called, 'The proceed closure was not called.');
        $this->assertSame($this->subjectMock, $result);
    }

    private function getValidConfigData(): array
    {
        return [
            'groups' => [
                'common_config' => [
                    'fields' => [
                        'use_free_shipping_method' => [
                            'value' => 1
                        ]
                    ]
                ]
            ]
        ];
    }
}
