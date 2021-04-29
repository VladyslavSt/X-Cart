<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Model\Payment;

use XLite\Core\Config;
use XLite\Module\XC\Stripe\Main;

/**
 * Stripe payment processor
 */
class Stripe extends \XLite\Module\XC\Stripe\Model\Payment\AStripe
{
    const API_VERSION = '2020-08-27';

    /**
     * Get URL of referral page
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getReferralPageURL(\XLite\Model\Payment\Method $method)
    {
        return '';
    }

    /**
     * Check - payment method connected to Stripe or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isSettingsConfigured(\XLite\Model\Payment\Method $method)
    {
        return ($method->getSetting('accessToken') && $method->getSetting('publishKey'))
            || ($method->getSetting('accessTokenTest') && $method->getSetting('publishKeyTest'));
    }

    /**
     * Check - payment method is configured or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isConfigured(\XLite\Model\Payment\Method $method)
    {
        return $this->isSettingsConfigured($method)
            && \XLite\Core\Config::getInstance()->Security->customer_security
            && !Main::getStripeConnectMethod()->getEnabled();
    }

    /**
     * @return string
     */
    public function getActualClientSecret(\XLite\Model\Payment\Method $method)
    {
        $suffix = $this->isTestMode($method) ? 'Test' : '';

        return $method->getSetting('accessToken' . $suffix);
    }

    /**
     * Get allowed backend transactions
     *
     * @return array Status codes
     */
    public function getAllowedTransactions()
    {
        return [
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE_PART,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_VOID,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_PART,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_MULTI,
        ];
    }

    /**
     * Get settings widget or template
     *
     * @return string Widget class name or template path
     */
    public function getSettingsWidget()
    {
        return '\XLite\Module\XC\Stripe\View\StripeConfig';
    }

    /**
     * Return true if payment method settings form should use default submit button.
     * Otherwise, settings widget must define its own button
     *
     * @return boolean
     */
    public function useDefaultSettingsFormButton()
    {
        return false;
    }

    /**
     * Get payment method admin zone icon URL
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getAdminIconURL(\XLite\Model\Payment\Method $method)
    {
        return true;
    }

    /**
     * @return array
     */
    protected function getCheckoutSessionParams()
    {
        $currency  = $this->transaction->getCurrency();
        $lineItems = [
            [
                'price_data' => [
                    'currency'     => strtolower($currency->getCode()),
                    'product_data' => [
                        'name' => Config::getInstance()->Company->company_name,
                    ],
                    'unit_amount'  => $this->formatCurrency($this->getOrder()->getTotal()),
                ],
                'quantity'   => 1,
            ],
        ];

        $params = [
            'success_url'          => $this->getReturnURL(null, true),
            'cancel_url'           => $this->getReturnURL(null, true, true),
            'mode'                 => 'payment',
            'payment_method_types' => ['card'],
            'client_reference_id'  => $this->getOrder()->getOrderId(),
            'customer_email'       => $this->getProfile()->getLogin(),
            'line_items'           => $lineItems,
            'payment_intent_data'  => [
                'capture_method' => $this->isCapture() ? 'automatic' : 'manual',
                'description'    => static::t('Payment transaction ID') . ': ' . $this->transaction->getPublicId(),
                'metadata'       => [
                    'txnId' => $this->transaction->getPublicTxnId(),
                ],
            ],
        ];

        $origProfile = $this->getOrder()->getOrigProfile();
        if ($origProfile && !$origProfile->getAnonymous()) {
            if ($origProfile->getStripeCustomerId()) {
                $params['customer'] = $origProfile->getStripeCustomerId();
                unset($params['customer_email']);

            } else {
                try {
                    $stripeCustomer     = \Stripe\Customer::create(
                        [
                            'email' => $origProfile->getLogin(),
                            'name'  => $origProfile->getName(),
                        ]
                    );
                    $params['customer'] = $stripeCustomer->id;
                    unset($params['customer_email']);

                } catch (\Stripe\Exception\ApiErrorException $e) {
                    static::log('Create customer error: ' . $e->getMessage());
                }
            }
        }

        return $params;
    }

    /**
     * Process return
     *
     * @param \XLite\Model\Payment\Transaction $transaction Return-owner transaction
     */
    public function processReturn(\XLite\Model\Payment\Transaction $transaction)
    {
        parent::processReturn($transaction);

        $transaction->setEntityLock(\XLite\Model\Payment\Transaction::LOCK_TYPE_IPN);

        $this->processCompleteCheckout($transaction);
    }

    /**
     * @param \XLite\Model\Payment\Transaction $transaction
     */
    public function processCompleteCheckout(\XLite\Model\Payment\Transaction $transaction)
    {
        $this->includeStripeLibrary();

        try {
            $intentId = $transaction->getDetail('stripe_id');
            $intent   = \Stripe\PaymentIntent::retrieve($intentId);

            $status   = \XLite\Model\Payment\Transaction::STATUS_FAILED;
            $btStatus = \XLite\Model\Payment\BackendTransaction::STATUS_FAILED;
            $error    = '';
            if (in_array($intent->status, ['succeeded', 'requires_capture'])) {
                $status   = \XLite\Model\Payment\Transaction::STATUS_SUCCESS;
                $btStatus = \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS;
                $transaction->setNote('');

                $origProfile = $this->getOrder()->getOrigProfile();
                if (
                    $origProfile
                    && !$origProfile->getAnonymous()
                    && !$origProfile->getStripeCustomerId()
                    && $intent->customer
                ) {
                    $origProfile->setStripeCustomerId($intent->customer);
                }

                if (!$this->checkTotal($transaction->getCurrency()->convertIntegerToFloat($intent->amount))) {
                    $error = "Total amount doesn't match.";

                } elseif (!$this->checkCurrency(strtoupper($intent->currency))) {
                    $error = "Currency code doesn't match.";
                }

            } else {
                $error = 'Invalid PaymentIntent status';

                /** @var \Stripe\Charge $charge */
                $charge = $intent->charges->first();
                if ($charge && $charge->failure_message) {
                    $error = $charge->failure_message;
                    $transaction->setNote($error);
                }
            }

            if ($error) {
                $status   = \XLite\Model\Payment\Transaction::STATUS_FAILED;
                $btStatus = \XLite\Model\Payment\BackendTransaction::STATUS_FAILED;
                $transaction->setDataCell('Error', $error);
            }

            $transaction->setStatus($status);
            $bt = $transaction->getInitialBackendTransaction();
            if (!$bt) {
                $bt = $this->registerBackendTransaction($this->getInitialTransactionType(), $transaction);
            }
            $bt->setStatus($btStatus);

        } catch (\Exception $e) {
            static::log([
                'message'          => 'Error: ' . __FUNCTION__,
                'request'          => $this->request->getPostDataWithArrayValues(),
                'exceptionMessage' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Include Stripe library
     *
     * @return void
     */
    protected function includeStripeLibrary()
    {
        if (!$this->stripeLibIncluded) {
            require_once LC_DIR_MODULES . 'XC' . LC_DS . 'Stripe' . LC_DS . 'lib' . LC_DS . 'vendor' . LC_DS . 'autoload.php';

            if ($this->transaction) {
                $method = $this->transaction->getPaymentMethod();
                $key    = $this->getActualClientSecret($method);

            } else {
                $method = Main::getStripeMethod();
                $key    = $this->getActualClientSecret($method);
            }

            \Stripe\Stripe::setApiKey($key);
            \Stripe\Stripe::setApiVersion(static::API_VERSION);

            $module = \Includes\Utils\Module\Manager::getRegistry()->getModule('XC', 'Stripe');
            \Stripe\Stripe::setAppInfo(
                static::APP_NAME,
                $module->getVersion(),
                'https://market.x-cart.com/addons/stripe-payment-module.html',
                static::APP_PARTNER_ID
            );

            $this->stripeLibIncluded = true;
        }
    }

    // {{{ Secondary transactions

    /**
     * Capture
     *
     * @param \XLite\Model\Payment\BackendTransaction $transaction Backend transaction
     *
     * @return boolean
     */
    protected function doCapture(\XLite\Model\Payment\BackendTransaction $transaction)
    {
        $this->includeStripeLibrary();

        $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_FAILED;

        try {
            /** @var \Stripe\PaymentIntent $paymentIntent */
            $paymentIntent = \Stripe\PaymentIntent::retrieve(
                $transaction->getPaymentTransaction()->getDetail('stripe_id')
            );
            $paymentIntent->capture();

            if ($paymentIntent->status == 'succeeded') {
                $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS;

                static::log([
                    'message' => 'Success: ' . __FUNCTION__,
                    'id'      => $paymentIntent->id,
                    'amount'  => $paymentIntent->amount,
                    'status'  => $paymentIntent->status,
                ]);
            }

            if (!empty($paymentIntent->charges->data)) {
                $charge = reset($paymentIntent->charges->data);
                $transaction->setDataCell('stripe_b_txntid', $charge->balance_transaction);
            }

        } catch (\Exception $e) {
            $transaction->setDataCell('errorMessage', $e->getMessage());
            static::log(__FUNCTION__ . ' failed: ' . $e->getMessage());
            \XLite\Core\TopMessage::addError($e->getMessage());
        }

        $transaction->setStatus($backendTransactionStatus);

        return \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS == $backendTransactionStatus;
    }

    /**
     * Void
     *
     * @param \XLite\Model\Payment\BackendTransaction $transaction Backend transaction
     *
     * @return boolean
     */
    protected function doVoid(\XLite\Model\Payment\BackendTransaction $transaction)
    {
        $this->includeStripeLibrary();

        $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_FAILED;

        try {
            /** @var \Stripe\PaymentIntent $paymentIntent */
            $paymentIntent = \Stripe\PaymentIntent::retrieve(
                $transaction->getPaymentTransaction()->getDetail('stripe_id')
            );
            $paymentIntent->cancel();

            if ($paymentIntent->status == 'canceled') {
                $charge = reset($paymentIntent->charges->data);
                if ($charge && $charge->refunds->data) {
                    $refundTransaction = reset($charge->refunds->data);

                    if ($refundTransaction) {
                        $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS;

                        $transaction->setDataCell('stripe_date', $refundTransaction->created);
                        if ($refundTransaction->balance_transaction) {
                            $transaction->setDataCell('stripe_b_txntid', $refundTransaction->balance_transaction);
                        }
                    }
                }

                $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS;

                static::log([
                    'message' => 'Success: ' . __FUNCTION__,
                    'id'      => $paymentIntent->id,
                    'amount'  => $paymentIntent->amount,
                    'status'  => $paymentIntent->status,
                ]);
            }

        } catch (\Exception $e) {
            $transaction->setDataCell('errorMessage', $e->getMessage());
            static::log(__FUNCTION__ . ' failed: ' . $e->getMessage());
            \XLite\Core\TopMessage::addError($e->getMessage());
        }

        $paymentTransaction = $transaction->getPaymentTransaction();

        $transaction->setStatus($backendTransactionStatus);
        $paymentTransaction->setStatus(\XLite\Model\Payment\Transaction::STATUS_VOID);

        return \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS == $backendTransactionStatus;
    }

    /**
     * Refund
     *
     * @param \XLite\Model\Payment\BackendTransaction $transaction Backend transaction
     *
     * @return boolean
     */
    protected function doRefundMulti(\XLite\Model\Payment\BackendTransaction $transaction)
    {
        return $this->doRefund($transaction);
    }

    /**
     * Refund
     *
     * @param \XLite\Model\Payment\BackendTransaction $transaction Backend transaction
     *
     * @return boolean
     */
    protected function doRefund(\XLite\Model\Payment\BackendTransaction $transaction)
    {
        $this->includeStripeLibrary();

        $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_FAILED;

        try {
            /** @var \Stripe\PaymentIntent $paymentIntent */
            $paymentIntent = \Stripe\PaymentIntent::retrieve(
                $transaction->getPaymentTransaction()->getDetail('stripe_id')
            );

            $payment = !empty($paymentIntent->charges->data)
                ? reset($paymentIntent->charges->data)
                : null;

            if (!$payment) {
                throw new \Exception('No charges found for payment intent ' . $paymentIntent->id);
            }

            if ($transaction->getValue() != $transaction->getPaymentTransaction()->getValue()) {
                $payment->refunds->create([
                    'amount' => $this->formatCurrency($transaction->getValue()),
                ]);

                /** @var \Stripe\Refund $refundTransaction */
                $refundTransaction = null;

                if ($payment->refunds) {
                    foreach ($payment->refunds->all() as $r) {
                        if (!$this->isRefundTransactionRegistered($r)) {
                            $refundTransaction = $r;
                            break;
                        }
                    }
                }

            } else {
                $refundTransaction = $payment->refunds->create();
            }

            if ($refundTransaction) {
                $backendTransactionStatus = \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS;

                $transaction->setDataCell('stripe_date', $refundTransaction->created);
                if ($refundTransaction->balance_transaction) {
                    $transaction->setDataCell('stripe_b_txntid', $refundTransaction->balance_transaction);
                }

                static::log([
                    'message'             => 'Success: ' . __FUNCTION__,
                    'id'                  => $refundTransaction->id,
                    'amount'              => $refundTransaction->amount,
                    'balance_transaction' => $refundTransaction->balance_transaction,
                ]);
            }

        } catch (\Exception $e) {
            $transaction->setDataCell('errorMessage', $e->getMessage());
            static::log(__FUNCTION__ . ' failed: ' . $e->getMessage());
            \XLite\Core\TopMessage::addError($e->getMessage());
        }

        $transaction->setStatus($backendTransactionStatus);

        return \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS == $backendTransactionStatus;
    }

    /**
     * Check - specified rfund transaction is registered or not
     *
     * @param object $refund Refund transaction
     *
     * @return boolean
     */
    protected function isRefundTransactionRegistered($refund)
    {
        $result = null;
        $types  = [
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_PART,
            \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_MULTI,
        ];

        foreach ($this->transaction->getBackendTransactions() as $bt) {
            $txnid = $bt->getDataCell('stripe_b_txntid');
            if (
                in_array($bt->getType(), $types)
                && (!$txnid || $txnid->getValue() == $refund->balance_transaction)
                && ($bt->getDataCell('stripe_date') && $bt->getDataCell('stripe_date')->getValue() == $refund->created)
            ) {
                $result = $bt;
                break;
            }
        }

        return $result;
    }

    /**
     * @param \Stripe\Event $event
     *
     * @return \Stripe\Refund|null
     */
    protected function getRefundObject($event)
    {
        $refunds = $event->data->object->refunds instanceof \Stripe\Collection
            ? $event->data->object->refunds->data
            : $event->data->object->refunds;

        foreach ($refunds as $r) {
            if (!$this->isRefundTransactionRegistered($r)) {
                return $r;
            }
        }

        return null;
    }

    // }}}

    // {{{ Callback

    /**
     * Process event charge.refunded
     *
     * @param \Stripe\Event                    $event       Event
     * @param \XLite\Model\Payment\Transaction $transaction Callback-owner transaction
     *
     * @return void
     */
    protected function processEventChargeRefunded($event, $transaction)
    {
        $refundTransaction = $this->getRefundObject($event);

        if (
            $refundTransaction
            && !$this->isBackendTransactionSuccessful(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND)
        ) {
            $amount = $this->transaction->getCurrency()->convertIntegerToFloat($refundTransaction->amount);

            if ($amount != $this->transaction->getValue()) {
                $backendTransaction = $this->registerBackendTransaction(
                    \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_PART
                );
                $backendTransaction->setValue($amount);

            } else {
                $type = \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND;
                if (!$this->transaction->isCaptured()) {
                    $type = \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_VOID;
                    $this->transaction->setType($type);
                    $this->transaction->setStatus(\XLite\Model\Payment\Transaction::STATUS_VOID);
                }
                $backendTransaction = $this->registerBackendTransaction($type);
            }

            $backendTransaction->setDataCell('stripe_date', $refundTransaction->created);
            if ($refundTransaction->balance_transaction) {
                $backendTransaction->setDataCell('stripe_b_txntid', $refundTransaction->balance_transaction);
            }

            $backendTransaction->setStatus(\XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS);
            $backendTransaction->registerTransactionInOrderHistory('callback');

        } elseif ($this->isBackendTransactionSuccessful(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND)) {
            $this->transaction->setType(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND);
            $this->transaction->setStatus(\XLite\Model\Payment\Transaction::STATUS_SUCCESS);
        } else {
            static::log('Duplicate charge.refunded event # ' . $event->id);
        }
    }

    /**
     * Process event charge.captured
     *
     * @param \Stripe\Event                    $event       Event
     * @param \XLite\Model\Payment\Transaction $transaction Callback-owner transaction
     *
     * @return void
     */
    protected function processEventChargeCaptured($event, $transaction)
    {
        $refundTransaction = $this->getRefundObject($event);

        if (!$this->isBackendTransactionSuccessful(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE)) {
            $amount = $this->transaction->getValue();
            if ($refundTransaction) {
                $amountRefunded = $this->transaction->getCurrency()->convertIntegerToFloat($refundTransaction->amount);
                $amountFull     = $this->transaction->getCurrency()->convertIntegerToFloat($event->data->object->amount);
                $amount         = $amountFull - $amountRefunded;
                if ($amount != $this->transaction->getValue()) {
                    $backendTransaction = $this->registerBackendTransaction(
                        \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_MULTI
                    );
                    $backendTransaction->setValue($amountRefunded);
                    $backendTransaction->setStatus(\XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS);
                    $backendTransaction->registerTransactionInOrderHistory('callback');
                }
            }

            $type = \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE;
            if ($refundTransaction) {
                $type               = \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE_PART;
                $backendTransaction = $this->registerBackendTransaction($type);
                $backendTransaction->setValue($amount);

                $this->transaction->setType(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE_PART);
                $this->transaction->setValue($amount);
                $this->transaction->setStatus(\XLite\Model\Payment\Transaction::STATUS_SUCCESS);

            } else {
                $backendTransaction = $this->registerBackendTransaction($type);
                $this->transaction->setType(\XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE);
                $this->transaction->setStatus(\XLite\Model\Payment\Transaction::STATUS_SUCCESS);
            }
            $backendTransaction->setStatus(\XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS);
            $backendTransaction->registerTransactionInOrderHistory('callback');

        } else {
            static::log('Duplicate charge.captured event # ' . $event->id);
        }
    }

    /**
     * Check if event is already handled
     *
     * @param string $type
     *
     * @return bool
     */
    protected function isBackendTransactionSuccessful($type)
    {
        foreach ($this->transaction->getBackendTransactions() as $bt) {
            if (
                $bt->getType() == $type
                && $bt->getStatus() == \XLite\Model\Payment\BackendTransaction::STATUS_SUCCESS
            ) {
                return true;
            }
        }

        return false;
    }

    // }}}
}

