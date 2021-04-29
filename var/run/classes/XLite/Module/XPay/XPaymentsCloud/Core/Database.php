<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XPay\XPaymentsCloud\Core;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use XLite\Model\Order;

/**
 * Database
 */
 class Database extends \XLite\Core\DatabaseAbstract implements \XLite\Base\IDecorator
{
    /**
     * loadClassMetadata event handler
     *
     * @param \Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs Event arguments
     *
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        parent::loadClassMetadata($eventArgs);

        $classMetadata = $eventArgs->getClassMetadata();

        if (Order::class == $classMetadata->getName()) {
            if (!isset($classMetadata->table['indexes']['delayedPaymentSavedCardId'])) {
                $classMetadata->table['indexes']['delayedPaymentSavedCardId'] = [
                    'columns' => [
                        'delayedPaymentSavedCardId',
                    ],
                ];
            }
        }
    }

}
