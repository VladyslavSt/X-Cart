<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\Model;

use XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * @Decorator\Depend("QSL\XPaymentsSubscriptions")
 */
class Subscription extends \XLite\Module\QSL\XPaymentsSubscriptions\Model\Subscription implements \XLite\Base\IDecorator
{
    /**
     * Get possible cards based on profile
     *
     * @return array
     */
    public function getPossibleSavedCards()
    {
        return XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()
            ? []
            : parent::getPossibleSavedCards();
    }

}
