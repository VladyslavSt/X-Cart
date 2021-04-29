<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Module\QSL\XPaymentsSubscriptions\View\FormField\Select;

use XLite\Core\Database;
use XLite\Module\QSL\XPaymentsSubscriptions\Model\Subscription;
use XLite\Module\XPay\XPaymentsCloud\Main as XPaymentsCloud;

/**
 * @Decorator\Depend("QSL\XPaymentsSubscriptions")
 */
class SubscriptionStatus extends \XLite\Module\QSL\XPaymentsSubscriptions\View\FormField\Select\SubscriptionStatus implements \XLite\Base\IDecorator
{
    /** @var Subscription  */
    protected $subscription;

    /**
     * SubscriptionStatus constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        if (isset($params['nameParts'])) {
            $this->subscription = Database::getRepo(Subscription::class)->find($params['nameParts'][1]);
        }
        parent::__construct($params);
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = parent::getDefaultOptions();

        if (XPaymentsCloud::isUseXpaymentsCloudForSubscriptions()) {
            $options = [
                Subscription::STATUS_STOPPED => static::t('Stopped'),
            ];
            if (
                $this->subscription
                && Subscription::STATUS_ACTIVE == $this->subscription->getStatus()
            ) {
                $options[Subscription::STATUS_ACTIVE] = static::t('Active');
            }
        }

        return $options;
    }

}
