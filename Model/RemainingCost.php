<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Model;

use Magento\Framework\Model\AbstractModel;
use Space\FreeShippingRemainingCost\Api\Data\RemainingCostInterface;

class RemainingCost extends AbstractModel implements RemainingCostInterface
{
    /**
     * Get remaining cost message
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Get remaining cost value
     *
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->getData(self::VALUE);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return RemainingCostInterface
     */
    public function setMessage(string $message): RemainingCostInterface
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Set remaining cost value
     *
     * @param float $value
     * @return RemainingCostInterface
     */
    public function setValue(float $value): RemainingCostInterface
    {
        return $this->setData(self::VALUE, $value);
    }
}
