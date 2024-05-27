/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

define([
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (ko, Component, customerData) {
    'use strict';

    return Component.extend({
        /**
         * @inheritdoc
         */
        initialize: function () {
            this._super();
            this.shippingRemainingCost = customerData.get('shipping-remaining-cost');
            this.shippingRemainingCost.subscribe(this._getCurrentMessage, this);
        },

        /**
         * Get current message
         *
         * @return {String}
         * @private
         */
        _getCurrentMessage: function () {
            return this.shippingRemainingCost().message;
        },

        /**
         * Get remaining message
         *
         * @return {String}
         */
        getNotification: function () {
            if (typeof this._getCurrentMessage() !== "undefined"
                && this._getCurrentMessage() === ''
                && parseInt(this.isShowIfCartEmpty)
            ) {
                return this.defaultMessage;
            }

            return this._getCurrentMessage();
        }
    });
});
