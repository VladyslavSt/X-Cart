<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Model\Payment;

use XLite\Model\Payment\BackendTransaction;
use XLite\Module\XC\Stripe\Main;

/**
 * Payment transaction
 */
 class Transaction extends \XLite\Module\XPay\XPaymentsCloud\Model\Payment\Transaction implements \XLite\Base\IDecorator
{
    /**
     * Get charge value modifier
     *
     * @return float
     */
    public function getChargeValueModifier()
    {
        if (
            $this->isStripeConnect()
            && $this->type === BackendTransaction::TRAN_TYPE_GET_INFO
        ) {
            return 0;
        }

        return parent::getChargeValueModifier();
    }

    /**
     * @param $vendorId
     * @return int|mixed|null
     */
    public function getStripeTransferId($vendorId)
    {
        $transferId = null;
        $transactions = $this->getBackendTransactions();

        foreach ($transactions as $bt) {
            if ($bt->getType() !== BackendTransaction::TRAN_TYPE_SC_TRANSFER) {
                continue;
            }

            $btVendorId = $bt->getDataCell('vendor_id')
                ? $bt->getDataCell('vendor_id')->getValue()
                : null;

            if ($vendorId == $btVendorId) {
                $transferId = $bt->getDataCell('transfer_id')
                    ? $bt->getDataCell('transfer_id')->getValue()
                    : null;
            }
        }

        return $transferId;
    }

    /**
     * @return string|null
     */
    public function getStripeChargeId()
    {
        $value = null;
        foreach ($this->getData() as $cell) {
            if ($cell->getName() == 'sc_charge_id') {
                $value = $cell->getValue();
                break;
            }
        }
        return $value;
    }

    /**
     * @return bool
     */
    public function isStripeConnect()
    {
        return $this->getMethodName() === Main::STRIPE_CONNECT_SERVICE_NAME;
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order
     */
    public function getOrder()
    {
        if (
            $this->isStripeConnect()
            && ($childOrderId = $this->getDetail('sc_order_id'))
        ) {
            $order = \XLite\Core\Database::getRepo('XLite\Model\Order')->find($childOrderId);

            if ($order) {
                return $order;
            }
        }

        return parent::getOrder();
    }
}
