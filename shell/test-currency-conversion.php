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



require_once 'abstract.php';

class Mage_Shell_Profiles extends Mage_Shell_Abstract
{


    /**
     * Run script
     *
     */
    public function run()
    {

        $fixedCurrencyCode = Mage::getStoreConfig('checkout/image_currency_checkout/fixed_currency');
        $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();

        $baseCurrency = Mage::getModel('directory/currency')->load($baseCurrencyCode);
        $fixedCurrency = Mage::getModel('directory/currency')->load($fixedCurrencyCode);

        try {
          var_dump($baseCurrencyCode, $fixedCurrencyCode, $baseCurrency->convert(1000, $fixedCurrency));
          var_dump(Mage::helper('imagecc')->calculateFixedCurrencyAmount(1000));
        } catch(Exception $e) {
          var_dump("cant convert");
        }

    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f test-currency-conversion.php -- [options]

USAGE;
    }
}

$shell = new Mage_Shell_Profiles();
$shell->run();
