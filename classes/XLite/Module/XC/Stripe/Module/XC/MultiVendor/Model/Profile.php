<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Module\XC\MultiVendor\Model;

/**
 * The "profile" model class
 *
 * @Decorator\Depend ("XC\MultiVendor")
 */
class Profile extends \XLite\Model\Profile implements \XLite\Base\IDecorator
{
    /**
     * Stripe AccountID
     *
     * @var string
     *
     * @Column (type="string", length=128)
     */
    protected $stripeSellerAccountId = '';

    /**
     * @return string
     */
    public function getStripeSellerAccountId()
    {
        return $this->stripeSellerAccountId;
    }

    /**
     * @param string $stripeSellerAccountId
     */
    public function setStripeSellerAccountId($stripeSellerAccountId)
    {
        $this->stripeSellerAccountId = $stripeSellerAccountId;
    }
}
