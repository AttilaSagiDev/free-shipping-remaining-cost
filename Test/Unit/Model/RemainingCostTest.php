<?php
/**
 * Copyright (c) 2026 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Space\FreeShippingRemainingCost\Model\RemainingCost;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class RemainingCostTest extends TestCase
{
    /**
     * @var RemainingCost
     */
    private RemainingCost $model;

    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->model = $objectManager->getObject(RemainingCost::class);
    }

    public function testSetGetMessage()
    {
        $message = "You are $5.00 away from free shipping!";

        $this->model->setMessage($message);
        $this->assertEquals($message, $this->model->getMessage());
    }

    public function testSetGetValue()
    {
        $value = 5.50;

        $this->model->setValue($value);

        $this->assertEquals($value, $this->model->getValue());
    }

    public function testGettersReturnNullWhenEmpty()
    {
        $this->assertNull($this->model->getMessage());
        $this->assertNull($this->model->getValue());
    }
}
