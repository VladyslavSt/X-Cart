<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\View;

/**
 * Config 
 */
class StripeConnectConfig extends \XLite\View\AView
{
    /**
     * Get CSS files 
     * 
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/Stripe/settings/config.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/Stripe/settings/config.js';

        return $list;
    }

    /**
     * Register files from common repository
     *
     * @return array
     */
    protected function getCommonFiles()
    {
        $list = parent::getCommonFiles();

        $list[static::RESOURCE_JS][] = array(
            'file'      => 'js/clipboard.min.js',
            'no_minify' => true,
        );

        return $list;        
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/Stripe/settings/StripeConnect/config.twig';
    }

    /**
     * @return string
     */
    protected function getClientIdHelpLabel()
    {
        return static::t(
            'Stripe Connect Client ID help',
            ['link' => $this->buildFullURL('stripe_connect_vendor', 'stripe_connect_return', [], \XLite::CART_SELF)]
        );
    }
}

