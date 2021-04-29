<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\FastLaneCheckout\View\Checkout;

/**
 * @ListChild (list="checkout_fastlane.sections.place-order.after", weight="50")
 */
class ToSConsent extends \XLite\View\AView
{
    protected function getDefaultTemplate()
    {
        return 'modules/XC/FastLaneCheckout/sections/tos_consent.twig';
    }

    public function getJSFiles()
    {
        $list   = parent::getJSFiles();
        $list[] = 'modules/XC/FastLaneCheckout/sections/tos_consent.js';

        return $list;
    }

    /**
     * @return bool
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Core\Config::getInstance()->General->terms_conditions_confirm_type == 'Clickwrap';
    }
}
