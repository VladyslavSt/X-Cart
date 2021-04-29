<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\View;

use XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * @Decorator\Depend("QSL\XPaymentsSubscriptions")
 */
class CustomerSubscription extends \XLite\Module\QSL\XPaymentsSubscriptions\View\CustomerSubscription implements \XLite\Base\IDecorator
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()
            ? 'modules/XPay/XPaymentsCloud/modules/QSL/XPaymentsSubscriptions/subscription/subscription.twig'
            : parent::getDefaultTemplate();
    }

}
