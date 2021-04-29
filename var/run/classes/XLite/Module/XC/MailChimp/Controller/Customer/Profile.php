<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MailChimp\Controller\Customer;

use \XLite\Module\XC\MailChimp\Core;

/**
 * Top menu widget
 */
abstract class Profile extends \XLite\Controller\Customer\ProfileAbstract implements \XLite\Base\IDecorator
{
    /**
     * Postprocess register action (success)
     *
     * @return array
     */
    protected function postprocessActionRegisterSuccess()
    {
        $params = parent::postprocessActionRegisterSuccess();

        if (\XLite\Module\XC\MailChimp\Main::isMailChimpConfigured()) {
            $subscribeToAll = \XLite\Core\Request::getInstance()->{Core\MailChimp::SUBSCRIPTION_TO_ALL_FIELD_NAME};

            if ($subscribeToAll) {
                /** @var \XLite\Model\Profile $profile */
                $profile = $this->getModelForm()->getModelObject();

                if ($profile) {
                    try {
                        Core\MailChimp::processSubscriptionAll($profile);
                    } catch (Core\MailChimpException $e) {
                        \XLite\Core\TopMessage::addError(Core\MailChimp::getMessageTextFromError($e));
                    }
                }

                \XLite\Core\Session::getInstance()->{Core\MailChimp::SUBSCRIPTION_TO_ALL_FIELD_NAME} = null;
            }
        }

        return $params;
    }
}
