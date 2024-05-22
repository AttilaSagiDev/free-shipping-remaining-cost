<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;
use Magento\Framework\Serialize\Serializer\Json;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;

class ContentMessage implements ArgumentInterface
{
    /**
     * @var CalculationHelper
     */
    private CalculationHelper $calculationHelper;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor
     *
     * @param CalculationHelper $calculationHelper
     * @param Json $json
     * @param ConfigInterface $config
     */
    public function __construct(
        CalculationHelper $calculationHelper,
        Json $json,
        ConfigInterface $config
    ) {
        $this->calculationHelper = $calculationHelper;
        $this->json = $json;
        $this->config = $config;
    }

    /**
     * Show if cart is empty
     *
     * @return int
     */
    public function isShowIfCartEmpty(): int
    {
        return (int)$this->config->isShowIfCartEmpty();
    }

    /**
     * Get default message
     *
     * @param string $defaultMessage
     * @return string
     */
    public function getDefaultMessage(string $defaultMessage): string
    {
        return $this->json->serialize($defaultMessage);
    }

    /**
     * Show base message if cart is empty
     *
     * @return string
     */
    public function getBaseMessage(): string
    {
        if ($this->config->isShowIfCartEmpty()) {
            $remainingCostValue = $this->config->getCustomAmount();

            if ($this->config->isUseFreeShippingAmount()
                && $this->config->isFreeShippingMethodEnabled()
                && $this->config->getFreeShippingMethodAmount() > 0
            ) {
                $remainingCostValue = $this->config->getFreeShippingMethodAmount();
            }

            return $this->calculationHelper->getFormattedMessage($remainingCostValue);
        }

        return '';
    }
}
