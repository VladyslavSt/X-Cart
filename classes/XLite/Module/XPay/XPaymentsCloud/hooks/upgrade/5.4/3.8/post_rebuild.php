<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

/**
 * @param array|null $status
 *
 * @return array|null
 */
return function ($status = null) {

    if (null === $status) {
        // Loading data to the database from yaml file - only on the first iteration

        if (null === \XLite\Core\Config::getInstance()->XPay->XPaymentsCloud->card_number_display_format) {
            // Check one of the settings that were added in 5.4.3.6
            // If it's missing the upgrade hook was not executed

            $yamlFile = __DIR__ . LC_DS . '..' . LC_DS . '3.6'. LC_DS . 'post_rebuild.yaml';
            if (\Includes\Utils\FileManager::isFileReadable($yamlFile)) {
                \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);
            }
        }

        // Jsut in case apply hook from 5.4.3.5 upgrade
        $yamlFile = __DIR__ . LC_DS . '..' . LC_DS . '3.5'. LC_DS . 'post_rebuild.yaml';
        if (\Includes\Utils\FileManager::isFileReadable($yamlFile)) {
            \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);
        }

        \XLite\Core\Database::getEM()->flush();
    }
};
