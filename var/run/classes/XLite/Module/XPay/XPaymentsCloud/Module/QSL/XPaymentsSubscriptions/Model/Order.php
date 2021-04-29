<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\Model;

/**
 * @Decorator\After("QSL\XPaymentsSubscriptions")
 */
 class Order extends \XLite\Model\OrderAbstract implements \XLite\Base\IDecorator
{
    /**
     * Check if order has paid subscriptions
     *
     * @return boolean
     */
    public function hasPaidSubscriptions()
    {
        $result = false;

        foreach ($this->getItems() as $item) {
            if ($item->getSubscription()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

}
