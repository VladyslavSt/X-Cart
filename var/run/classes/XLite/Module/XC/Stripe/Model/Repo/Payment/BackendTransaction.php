<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\Stripe\Model\Repo\Payment;

/**
 * Payment backend transaction repository
 */
 class BackendTransaction extends \XLite\Model\Repo\Payment\BackendTransactionAbstract implements \XLite\Base\IDecorator
{
    /**
     * Find transaction by data cell
     *
     * @param string $name  Name
     * @param string $value Value
     *
     * @return \XLite\Model\Payment\Transaction
     */
    public function scFindOneByCell($name, $value)
    {
        return $this->scDefineFindOneByCellQuery($name, $value)->getSingleResult();
    }

    /**
     * Define query for scFindOneByCell() method
     *
     * @param string $name  Name
     * @param string $value Value
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function scDefineFindOneByCellQuery($name, $value)
    {
        $qb = parent::createQueryBuilder('t');

        return $qb
            ->linkInner('t.data', 'dataCell')
            ->andWhere('dataCell.name = :name AND dataCell.value = :value')
            ->setParameter('name', $name)
            ->setParameter('value', $value)
            ->setMaxResults(1);
    }
}
