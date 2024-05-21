/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({

        defaults: {
            isCartEmpty: 0
        },

        /**
         * @inheritdoc
         */
        initialize: function () {
            this._super();
            this.shippingRemainingCost = customerData.get('shipping-remaining-cost');
        },

        /**
         * Get remaining message
         *
         * @return {String}
         */
        getRemainingMessage: function () {
            return this.shippingRemainingCost().message;
        },

        /**
         * Get default remaining message
         *
         * @return {String}
         */
        getDefaultRemainingMessage: function () {
            return this.defaultMessage;
        },

        /**
         * Check to show message if cart is empty
         *
         * @return {Number}
         */
        showIfCartEmpty: function () {
            if (parseInt(this.isShowIfCartEmpty)) {
                this.isCartEmpty = 1;
            }

            return this.isCartEmpty;
        }
    });
});
