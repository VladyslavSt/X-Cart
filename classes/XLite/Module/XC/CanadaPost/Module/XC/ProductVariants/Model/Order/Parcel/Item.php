<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\CanadaPost\Module\XC\ProductVariants\Model\Order\Parcel;

/**
 * Class represents a Canada Post parcel items
 *
 * @Decorator\Depend ("XC\ProductVariants")
 */
class Item extends \XLite\Module\XC\CanadaPost\Model\Order\Parcel\Item implements \XLite\Base\IDecorator
{
    /**
     * Get object weight (in store weight units)
     *
     * @return float
     */
    protected function getObjectWeight()
    {
        /** @var \XLite\Module\XC\ProductVariants\Model\ProductVariant $productVariant */
        $productVariant = $this->getOrderItem()->getVariant();

        return $productVariant
            ? $productVariant->getWeight()
            : parent::getObjectWeight();
    }
}
