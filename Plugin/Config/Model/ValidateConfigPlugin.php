<?php

namespace Space\FreeShippingRemainingCost\Plugin\Config\Model;

use Magento\Config\Model\Config;
use Magento\Framework\Exception\LocalizedException;

class ValidateConfigPlugin
{
    /**
     * Module's config section
     */
    private const SECTION = 'free_shipping_remaining_cost_settings';

    /**
     * @param Config $subject
     * @param \Closure $proceed
     * @return Config
     * @throws LocalizedException
     */
    public function aroundSave(
        Config $subject,
        \Closure $proceed
    ): Config {
        if ($subject->getSection() == self::SECTION) {
            $currentConfigData = $subject->getData();
            if ($this->checkUseFreeShippingMethodValue($currentConfigData, 'value')
                || $this->checkUseFreeShippingMethodValue($currentConfigData, 'inherit')
            ) {
                throw new LocalizedException(__('Use Free Shipping Method check'));
            }
        }

        return $proceed();
    }

    /**
     * Check value
     *
     * @param array $currentConfigData
     * @param string $key
     * @return bool
     */
    private function checkUseFreeShippingMethodValue(
        array $currentConfigData,
        string $key
    ): bool {
        return !empty($currentConfigData['groups']['common_config']['fields']['use_free_shipping_method'][$key])
            && (int)$currentConfigData['groups']['common_config']['fields']['use_free_shipping_method'][$key] === 1;
    }
}
