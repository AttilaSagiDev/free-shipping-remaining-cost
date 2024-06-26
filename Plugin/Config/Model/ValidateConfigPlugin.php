<?php

namespace Space\FreeShippingRemainingCost\Plugin\Config\Model;

use Magento\Config\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Space\FreeShippingRemainingCost\Api\Data\ConfigInterface;

class ValidateConfigPlugin
{
    /**
     * Module's config section
     */
    private const SECTION = 'free_shipping_remaining_cost_settings';

    /**
     * Around save
     *
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
                if (!$subject->getConfigDataValue(ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_ENABLED)) {
                    throw new LocalizedException(__('Free Shipping delivery method disabled'));
                }
                if (empty($subject->getConfigDataValue(ConfigInterface::XML_PATH_FREE_SHIPPING_METHOD_AMOUNT))) {
                    throw new LocalizedException(
                        __('Free Shipping delivery method minimum order amount cannot be empty or zero')
                    );
                }
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
