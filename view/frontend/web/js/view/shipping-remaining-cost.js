/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'jquery',
    'underscore',
    'mage/mage',
    'mage/decorate'
], function (Component, customerData, $, _) {
    'use strict';

    /*var sidebarInitialized = false,
        compareProductsReloaded = false;*/

    /**
     * Initialize sidebar
     */
    /*function initSidebar() {
        if (sidebarInitialized) {
            return;
        }

        sidebarInitialized = true;
        $('[data-role=compare-products-sidebar]').decorate('list', true);
    }*/

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.shippingRemainingCost = customerData.get('shipping-remaining-cost');

            console.log(this.shippingRemainingCost());

            /*if (!compareProductsReloaded
                && !_.isEmpty(this.shippingRemainingCost())
                //Expired section names are reloaded on page load
                && _.indexOf(customerData.getExpiredSectionNames(), 'shipping-remaining-cost') === -1
                && window.checkout
                && window.checkout.websiteId
                && window.checkout.websiteId !== this.compareProducts().websiteId
            ) {
                //set count to 0 to prevent "compared products" blocks and count to show with wrong count and items
                this.compareProducts().count = 0;
                customerData.reload(['compare-products'], false);
                compareProductsReloaded = true;
            }
            initSidebar();*/
        }
    });
});
