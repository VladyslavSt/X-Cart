<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\View\Tabs;

use XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * Tabs related to X-Payments Cloud settings page
 *
 * @ListChild (list="admin.center", zone="admin", weight="10")
 */
class Settings extends \XLite\View\Tabs\ATabs
{
    /**
     * @var \XLite\Model\Payment\Method
     */
    protected $paymentMethod = null;

    /**
     * Returns the list of targets where this widget is available
     *
     * @return string[]
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();

        $list[] = 'payment_method';
        $list[] = 'module';

        return $list;
    }

    /**
     * Check widget visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $request = \XLite\Core\Request::getInstance();

        switch ($this->getTarget()) {
            case 'module':
                $forXpayments = ('XPay-XPaymentsCloud' == $request->moduleId);
                break;
            case 'payment_method':
                $forXpayments = ($request->method_id == XPaymentsCloud::getPaymentMethod()->getMethodId());
                break;
            default:
                $forXpayments = true;
                break;
        }

        return $forXpayments
            && parent::isVisible();
    }

    /**
     * Returns tab URL
     *
     * @param string $target Tab target
     *
     * @return string
     */
    protected function buildTabURL($target)
    {
        switch ($target) {
            case 'module':
                $url = $this->buildUrl($target, '', array('moduleId' => 'XPay-XPaymentsCloud'));
                break;
            case 'payment_method':
                $url = $this->buildUrl($target, '', array('method_id' => XPaymentsCloud::getPaymentMethod()->getMethodId()));
                break;
            default:
                $url = parent::buildTabURL($target);
                break;
        }

        return $url;
    }

    /**
     * Define tabs
     *
     * @return array
     */
    protected function defineTabs()
    {
        return array( 
            'payment_method' => array(
                'weight' => 100,
                'title'  => static::t('Payment Method'),
                'template' => 'empty.twig',
            ),
            'module' => array( 
                'weight' => 200,
                'title'  => static::t('Store settings'),
                'template' => 'empty.twig',
            ),
        );
    }
}
