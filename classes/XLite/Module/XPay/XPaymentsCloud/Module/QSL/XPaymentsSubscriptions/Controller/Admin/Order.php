<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\Controller\Admin;

use XLite\Module\XPay\XPaymentsCloud\Main;

/**
 * @Decorator\After("QSL\XPaymentsSubscriptions")
 */
class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    /**
     * Add tab for subscriptions
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        $tabName = Main::isUseXpaymentsCloudForSubscriptions()
            ? static::t('Subscriptions (legacy)')
            : static::t('Subscriptions');

        if (null !== $this->getOrder() && $this->getOrder()->hasPaidSubscriptions()) {
            $list['x_payments_subscription'] = $tabName;
        }

        return $list;
    }

    /**
     * Add tab template for subscriptions
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        if ($this->getOrder()->hasPaidSubscriptions()) {
            $list['x_payments_subscription'] = 'modules/QSL/XPaymentsSubscriptions/order/page/subscriptions.twig';
        }

        return $list;
    }

}
