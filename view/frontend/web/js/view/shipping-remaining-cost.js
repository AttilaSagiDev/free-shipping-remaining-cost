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
            console.log('this');
            console.log(this);


            console.log('Object');
            console.log(this.shippingRemainingCost());
        },

        /**
         * Get remaining message
         *
         * @return {String}
         */
        getRemainingMessage: function () {
            console.log('Message');
            console.log(typeof this.shippingRemainingCost().message);
            return this.shippingRemainingCost().message;
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
