# Magento 2 Module - Checkout Message

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_CheckoutMessage` module allows administrators to add an editable message to the checkout process. The message can be used to communicate important store information to your customers. The message can be set to show during a specific time frame or always on/off.

## Installation

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://augustash.repo.repman.io
composer require augustash/module-checkout-message:~1.0.0
bin/magento module:enable --clear-static-content Augustash_CheckoutMessage
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstall

After all dependent modules have also been disabled or uninstalled, you can finally remove this module:

```bash
bin/magento module:disable --clear-static-content Augustash_CheckoutMessage
rm -rf app/code/Augustash/CheckoutMessage/
composer remove augustash/module-checkout-message
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for a Magento 2 module](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/build/module-file-structure.html).
