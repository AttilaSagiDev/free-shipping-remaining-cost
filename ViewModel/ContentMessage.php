<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Space\FreeShippingRemainingCost\Helper\CalculationHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;
use Space\FreeShippingRemainingCost\Model\Config\Source\Layouts;
use Space\FreeShippingRemainingCost\Model\Config\Source\Position;

class ContentMessage implements ArgumentInterface
{
    /**
     * @var CalculationHelper
     */
    private CalculationHelper $calculationHelper;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

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
     * @param RequestInterface $request
     * @param Json $json
     * @param ConfigInterface $config
     */
    public function __construct(
        CalculationHelper $calculationHelper,
        RequestInterface $request,
        Json $json,
        ConfigInterface $config
    ) {
        $this->calculationHelper = $calculationHelper;
        $this->request = $request;
        $this->json = $json;
        $this->config = $config;
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isEnabled();
    }

    /**
     * Is show notification
     *
     * @return bool
     */
    public function isShow(): bool
    {
        if (!empty($this->config->getPagesToShow())
            && (in_array($this->request->getFullActionName(), $this->config->getPagesToShow())
                || $this->checkIfCartConfigurePage()
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Is sidebar position
     *
     * @return bool
     */
    public function isSidebarPosition(): bool
    {
        if ($this->request->getFullActionName() === Layouts::LAYOUT_CATEGORY_PAGE
            && $this->config->getPositionToShow() === Position::SHOW_IN_SIDEBAR
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get sidebar block title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->config->getBlockTitle();
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

    /**
     * Check if cart configuration page
     *
     * @return bool
     */
    private function checkIfCartConfigurePage(): bool
    {
        if ($this->request->getFullActionName() === Layouts::LAYOUT_CART_CONFIGURE_PAGE
            && in_array(Layouts::LAYOUT_PRODUCT_PAGE, $this->config->getPagesToShow())
        ) {
            return true;
        }

        return false;
    }
}
