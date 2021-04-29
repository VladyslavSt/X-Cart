<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\View;

/**
 * Payment widget
 */
class Payment extends \XLite\View\AView
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/Stripe/checkout.twig';
    }

    /**
     * Get data attributes
     *
     * @return array
     */
    protected function getDataAttributes()
    {
        $method = $this->getCart()->getPaymentMethod();
        $suffix = $method->getProcessor()->isTestMode($method) ? 'Test' : '';

        $data = [
            'data-key' => $method->getSetting('publishKey' . $suffix),
        ];

        return $data;
    }
}

