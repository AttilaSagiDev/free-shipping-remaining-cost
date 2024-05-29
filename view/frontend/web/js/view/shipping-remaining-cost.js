/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

define([
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'domReady!'
], function (ko, Component, customerData) {
    'use strict';

    return Component.extend({

        defaults: {
            isReady: ko.observable(false),
            notificationMessage: ko.observable('')
        },

        /**
         * @inheritdoc
         */
        initialize: function () {
            this._super();
            this.shippingRemainingCost = customerData.get('shipping-remaining-cost');
            this.shippingRemainingCost.subscribe(this._getNotification, this);
            this._getNotification();
        },

        /**
         * Get remaining message
         *
         * @private
         * return {void}
         */
        _getNotification: function () {
            if (typeof this.shippingRemainingCost().message === "undefined"
                && parseInt(this.isShowIfCartEmpty)
            ) {
                this.notificationMessage(this.defaultMessage);
            } else if (typeof this.shippingRemainingCost().message !== "undefined") {
                this.notificationMessage(this.shippingRemainingCost().message);
            }

            if (this.notificationMessage() !== ''
                && typeof this.notificationMessage() !== "undefined"
            ) {
                this.isReady(true);
            }
        }
    });
});
