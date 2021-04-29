<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\View\Checkout;

use XLite\Module\XC\Stripe\Main;

/**
 * Payment template
 */
abstract class Payment extends \XLite\Module\XPay\XPaymentsCloud\View\Checkout\Payment implements \XLite\Base\IDecorator
{
    /**
     * Get JS files 
     * 
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $isStripeEnabled = Main::getStripeMethod() ? Main::getStripeMethod()->isEnabled() : false;
        $isStripeConnectEnabled = Main::getStripeConnectMethod() ? Main::getStripeConnectMethod()->isEnabled() : false;

        if ($isStripeEnabled || $isStripeConnectEnabled) {
            $list[] = 'modules/XC/Stripe/payment.js';
            $list[] = ['url' => 'https://checkout.stripe.com/checkout.js'];
            $list[] = ['url' => 'https://js.stripe.com/v3/'];
        }

        return $list;
    }

}
