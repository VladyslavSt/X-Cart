<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Module\XC\MultiVendor\Model\Payment;

/**
 * Stripe payment processor
 * @Decorator\Depend ("XC\MultiVendor")
 */
abstract class AStripe extends \XLite\Module\XC\Stripe\Model\Payment\AStripe implements \XLite\Base\IDecorator
{
    /**
     * Checks if the order of transaction is already processed and is available for IPN receiving
     *
     * @param \XLite\Model\Payment\Transaction $transaction
     *
     * @return bool
     */
    protected function isOrderProcessed(\XLite\Model\Payment\Transaction $transaction)
    {
        $order          = $transaction->getOrder();
        $hasOrderNumber = $order->getOrderNumber()
            || $this->childrenHasNumber($order);

        return !$transaction->isOpen() && !$transaction->isInProgress() && $hasOrderNumber;
    }

    /**
     * @param \XLite\Model\Order $order
     *
     * @return bool
     */
    protected function childrenHasNumber(\XLite\Model\Order $order)
    {
        $result = false;

        if ($order->isParent()) {
            foreach ($order->getChildren() as $children) {
                if ($children->getOrderNumber()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
}

