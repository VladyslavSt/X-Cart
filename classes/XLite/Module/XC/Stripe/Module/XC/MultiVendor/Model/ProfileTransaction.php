<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Module\XC\MultiVendor\Model;


/**
 * @Decorator\Depend ("XC\MultiVendor")
 */
class ProfileTransaction extends \XLite\Module\XC\MultiVendor\Model\ProfileTransaction implements \XLite\Base\IDecorator
{
    const PROVIDER_STRIPE_CONNECT = 'SC';

    /**
     * Get provider image url
     *
     * @return string
     */
    public function getProviderImageUrl()
    {
        if (static::PROVIDER_STRIPE_CONNECT === $this->getProvider()) {
            return \XLite\Core\Layout::getInstance()->getResourceWebPath('modules/XC/Stripe/method_icon.png');
        }

        return parent::getProviderImageUrl();
    }
}
