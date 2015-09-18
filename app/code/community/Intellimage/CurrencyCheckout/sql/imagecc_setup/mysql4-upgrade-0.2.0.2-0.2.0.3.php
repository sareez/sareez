<?php
/**
 * Intellimage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mauricioprado00@gmail.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade your
 * Intellimage extension to newer versions in the future. 
 * If you wish to customize your Intellimage extension to your
 * needs please refer to mauricioprado00@gmail.com for more information.
 *
 * @package     Intellimage_CurrencyCheckout
 * @author      Hugo Mauricio Prado Macat
 * @copyright   2013
 * @email       mauricioprado00@gmail.com
 * @license     http://www.opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */



/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tables = array(
    $this->getTable('sales/order'),
);

$fields = array(
    array(
        'name' => 'imagecc_preserved_information',
        'define' => 'TEXT DEFAULT NULL COMMENT \'Preserved currency and price information\'',
    ),
    array(
        'name' => 'imagecc_currency_reversed',
        'define' => 'smallint(1) DEFAULT 0 COMMENT \'Determines if the order currency change was reversed\'',
    ),
);

foreach ($tables as $table) {
    foreach ($fields as $field) {
        /**
         * Add a column to the invoice table
         */
        $installer->getConnection()
            ->addColumn(
                $table, 
                $field['name'], 
                $field['define']
            );
    }
}

$installer->endSetup();
