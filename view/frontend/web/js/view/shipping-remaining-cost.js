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
            console.log('Object');
            console.log(this.shippingRemainingCost());

            console.log('Message');
            console.log(typeof this.shippingRemainingCost().message);
            return this.shippingRemainingCost().message;
        },

        isCartEmpty: function () {
            console.log(typeof this.shippingRemainingCost().value);
        }
    });
});
