<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Block;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Space\FreeShippingRemainingCost\Block\Widget;
use Space\FreeShippingRemainingCost\ViewModel\ContentMessage;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class WidgetTest extends TestCase
{
    /**
     * @var Widget
     */
    private Widget $model;

    /**
     * @var ContentMessage|MockObject
     */
    private ContentMessage|MockObject $contentMessageMock;

    /**
     * @var Context|MockObject
     */
    private Context|MockObject $contextMock;

    protected function setUp(): void
    {
        $this->contentMessageMock = $this->createMock(ContentMessage::class);
        $this->contextMock = $this->createMock(Context::class);

        $this->model = new Widget(
            $this->contextMock,
            $this->contentMessageMock,
            []
        );
    }

    public function testViewModelIsSetInBeforeToHtml(): void
    {
        $reflection = new \ReflectionClass(Widget::class);
        $method = $reflection->getMethod('_beforeToHtml');
        $method->setAccessible(true);

        $method->invoke($this->model);

        $this->assertSame(
            $this->contentMessageMock,
            $this->model->getData('view_model'),
            'The View Model was not correctly assigned to the block data.'
        );
    }

    public function testImplementsWidgetInterface(): void
    {
        $this->assertInstanceOf(BlockInterface::class, $this->model);
    }
}
