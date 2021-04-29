<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe;

use XLite\Core\Cache\ExecuteCached;

/**
 * Stripe module main class
 */
abstract class Main extends \XLite\Module\AModule
{
    const STRIPE_SERVICE_NAME             = 'Stripe';
    const STRIPE_CONNECT_SERVICE_NAME     = 'StripeConnect';

    /**
     * @deprecated use getStripeMethod() instead
     * @return Object|\XLite\Model\Payment\Method
     */
    public static function getMethod()
    {
        return static::getStripeMethod();
    }

    /**
     * @return Object|\XLite\Model\Payment\Method
     */
    public static function getStripeMethod()
    {
        return ExecuteCached::executeCachedRuntime(function () {
            return \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
                ->findOneBy(['service_name' => static::STRIPE_SERVICE_NAME]);
        }, [__CLASS__, __FUNCTION__]);
    }

    /**
     * @return Object|\XLite\Model\Payment\Method
     */
    public static function getStripeConnectMethod()
    {
        return ExecuteCached::executeCachedRuntime(function () {
            return \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
                ->findOneBy(['service_name' => static::STRIPE_CONNECT_SERVICE_NAME]);
        }, [__CLASS__, __FUNCTION__]);
    }
}