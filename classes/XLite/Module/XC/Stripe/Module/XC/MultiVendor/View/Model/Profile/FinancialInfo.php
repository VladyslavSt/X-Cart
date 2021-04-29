<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Module\XC\MultiVendor\View\Model\Profile;

use XLite\Module\XC\Stripe\Main;

/**
 * Administrator profile model widget. This widget is used in the admin interface
 *
 * @Decorator\Depend ("XC\MultiVendor")
 */
class FinancialInfo extends \XLite\Module\XC\MultiVendor\View\Model\Profile\FinancialInfo implements \XLite\Base\IDecorator
{
    const SECTION_STRIPE_CONNECT_ACCOUNT = 'stripeConnectAccount';

    /**
     * @return array
     */
    protected function getFinancialInfoSections()
    {
        $sections = parent::getFinancialInfoSections();

        $stripeConnectMethod = Main::getStripeConnectMethod();
        if (
            $stripeConnectMethod->getAdded()
            && $stripeConnectMethod->getProcessor()
            && $stripeConnectMethod->getProcessor()->isConfigured($stripeConnectMethod)
        ) {
            $sections[static::SECTION_STRIPE_CONNECT_ACCOUNT] = static::t('Stripe Connect Account');
        }

        return $sections;
    }

    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function getFormFieldsForSectionStripeConnectAccount()
    {
        $schema = $this->defineStripeConnectAccountSchema();

        return $this->getFieldsBySchema($schema);
    }

    /**
     * @return array
     */
    protected function defineStripeConnectAccountSchema()
    {
        $fields['stripeSellerAccountId'] = array(
            static::SCHEMA_CLASS       => 'XLite\Module\XC\Stripe\View\FormField\ConnectAccount',
            static::SCHEMA_LABEL       => 'Stripe Account ID',
            static::SCHEMA_REQUIRED    => false,
        );

        return $fields;
    }
}
