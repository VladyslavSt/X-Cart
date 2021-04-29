<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\Controller\Customer;

use XLite\Core\TopMessage;
use \XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * @Decorator\Depend("QSL\XPaymentsSubscriptions")
 */
class XPaymentsSubscription extends \XLite\Module\QSL\XPaymentsSubscriptions\Controller\Customer\XPaymentsSubscription implements \XLite\Base\IDecorator
{
    /**
     * Restarts active subscription
     *
     * @return void
     */
    protected function doActionRestartSubscription()
    {
        if (XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()) {
            TopMessage::addError(static::t('Unable to restart subscription. To restart it, please re-purchase the item.'));
            $this->setReturnURL($this->buildURL('x_payments_subscription'));
            $this->doRedirect();
        } else {
            parent::doActionRestartSubscription();
        }
    }

    /**
     * Changes card used for subscription
     *
     * @return void
     */
    protected function doActionChangeCard()
    {
        if (XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()) {
            TopMessage::addError(static::t('Unable to change card. To change it, please re-purchase the item.'));
            $this->setReturnURL($this->buildURL('x_payments_subscription'));
            $this->doRedirect();
        } else {
            parent::doActionChangeCard();
        }
    }

}
