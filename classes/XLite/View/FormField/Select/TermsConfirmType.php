<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\View\FormField\Select;

/**
 * Terms and conditions agreement type
 */
class TermsConfirmType extends \XLite\View\FormField\Select\Regular
{
    const TYPE_CLICKWRAP  = 'Clickwrap';
    const TYPE_BROWSEWRAP = 'Browsewrap';

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
            static::TYPE_CLICKWRAP  => static::t('Clickwrap'),
            static::TYPE_BROWSEWRAP => static::t('Browsewrap'),
        ];
    }
}
