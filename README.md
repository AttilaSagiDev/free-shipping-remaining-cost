# **Magento 2 Free Shipping Remaining Cost Extension** #

[![M2 Coding Standard](https://github.com/AttilaSagiDev/free-shipping-remaining-cost/actions/workflows/codesniffer-actions.yml/badge.svg?branch=develop)](https://github.com/AttilaSagiDev/free-shipping-remaining-cost/actions/workflows/codesniffer-actions.yml)

## Description ##

The extension adds functionality to show the remaining amount that must be spent by the customer to gain free shipping. The extension will display the notification in a block if the free shipping method is enabled, and it has the appropriate minimum order amount (not zero). The module can be configured to set custom amount for calculation, and this will be used instead of the default free shipping order value in this case. If the customer adds products to the cart, the notification will refresh automatically (without page reload). The update also happens for any other interactions if the user removes, modify or update items in the cart.

The administrator can customize the notification text and the block title at the extension’s configuration panel. The extension can be configured to display the message on the cart page automatically. The administrator can setup the module to show the information box automatically in custom positions like in the sidebar area, content area or almost anywhere on the frontend.

The extension has widget option too with two templates, so it's easy to place the notification block or only the message on cms pages or static blocks. Using the Magento 2 widgets functionality, it's very simple to display the block in different areas. If free shipping available for the customer there is an option to show a customizable success message. This promotional tool will attract more attention.

## Features ##

- Module enable / disable
- Automatically display notification block or only the message in different areas on the frontend
- Customize notification text and the block title as well
- All currency support
- Setup custom amount for calculation to use instead of the default free shipping order amount
- Widget support. The widget(s) can be placed anywhere easily on the store frontend in Magento 2
- Custom success message
- Multistore support
- Supported languages: English

It is a separate module that does not change the default Magento files.

Support:
- Magento Community Edition 2.4.x
- Adobe Commerce 2.4.x

## Installation ##

** Important! Always install and test the extension in your development environment, and not on your live or production server. **

1. Backup your store database and the whole Magento 2 directory

2. Enable extension Please use the following commands in your Magento 2 console:

   ```
    bin/magento module:enable Space_FreeShippingRemainingCost

    bin/magento setup:upgrade
    ```

## Configuration ##

Login to Magento backend (admin panel). You can find the module configuration here: Stores / Configuration, in the left menu Space Extensions / Free Shipping Remaining Cost.

Settings:

### Configuration ###

Enable Extension: Here you can enable the extension.

### Common Settings ###

Use built-in free shipping method amount: Enable to use Magento free shipping method amount. Note: the free shipping method has to be enabled and set.

Custom amount: Custom amount for free shipping calculation.

Show if Cart is Empty: Enable to show free shipping information text if the cart is empty.

### Display ###

Block Title: The title of the sidebar's free shipping notification block.

Notification Text: The notification text which will be displayed. Please note that the "%s" will be replaced with the price, so you have to add it in the proper place within the text. You can use HTML tags also.

Show Success Message: Enable to show the success message.

Success Message: The success message if free shipping is available.

### Pages ###

Pages to Show notification: Category page, Product page, Cart page

Category Page Position: Show in content top as message or Show in sidebar as block

## Change Log ##

Version 1.1.1 - Sep 25, 2024
- Read me fix

Version 1.1.0 - Jun 5, 2024
- Compatibility with Magento Community Edition 2.4.x
- Compatibility with Adobe Commerce 2.4.x
- Full refactor
- PHP 8.3 support

Version 1.0.4 - Apr 2, 2018
- Compatibility with Magento 2.2.x
- Compatibility with Magento 2.1.x
- Layout handle fix
- Success message fix

Version 1.0.3 - Feb 4, 2018
- Compatibility with Magento 2.2.x
- Compatibility with Magento 2.1.x
- Code Sniffer fixes

Version 1.0.2 - May 9, 2017
- Add success message and progress indicator.

Version 1.0.1 - Feb 21, 2017
- Compatibility with Magento 2.1.x
- Compatibility with Magento 2.0.x

Version 1.0.0 - Sep 10, 2016
- Compatibility with Magento 2.0.x

## Support ##

If you have any questions about the extension, please get in touch with me.

## License ##

MIT License.
