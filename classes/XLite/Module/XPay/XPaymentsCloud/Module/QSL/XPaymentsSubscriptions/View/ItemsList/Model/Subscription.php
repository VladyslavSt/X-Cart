<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\View\ItemsList\Model;

use XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * @Decorator\Depend("QSL\XPaymentsSubscriptions")
 */
class Subscription extends \XLite\Module\QSL\XPaymentsSubscriptions\View\ItemsList\Model\Subscription implements \XLite\Base\IDecorator
{
    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        if (
            XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()
            && isset($columns['card'])
        ) {
            unset($columns['card']);
        }

        return $columns;
    }

}
