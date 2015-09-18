<?php
/**
 * Outsource Online Captcha Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   Outsource Online
 * @package    OutsourceOnline_Captcha
 * @author     Sreekanth Dayanand
 * @copyright  Copyright (c) 2010 Outsource Online. (http://www.outsource-online.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 //include_once "Mage/Checkout/controllers/OnepageController.php";
require_once(Mage::getModuleDir('controllers', 'Mage_Checkout')."/OnepageController.php");
class OutsourceOnline_Captcha_OnepageController extends Mage_Checkout_OnepageController
{
	/**
     * save checkout billing address
     */
    public function saveBillingAction()
    {
		$saveBillingActionComplete = false;
		//die(Mage::getSingleton('core/session')->getSecuriyCode());
		if ($this->_expireAjax()) {
            return;
        }
		if( !(Mage::getStoreConfig("OutsourceOnline_Captcha/captcha/when_loggedin")  && (Mage::getSingleton('customer/session')->isLoggedIn()))  )
        {
            if (Mage::getStoreConfig("OutsourceOnline_Captcha/captcha/customer"))
            {
                
                // check response
                $resp = Mage::helper("outsourceonline_captcha")->validate();
				
                $data = $this->getRequest()->getPost();
				
				//validate botscout
				Mage::helper("outsourceonline_captcha")->validateBotScout(Mage::getSingleton('core/app')->getRequest()->getParam('nickname'));
                
				
                if ($resp == true)
                { // if captcha response is correct, use core functionality
                   //parent::saveBillingAction();
                }
                else
                { // if captcha response is incorrect, reload the page
                    Mage::getSingleton('core/session')->addError($this->__('Your CAPTCHA entry is incorrect. Please try again.'));
                    Mage::getSingleton('review/session')->setFormData($data);
                    $this->_redirectReferer();
					$saveBillingActionComplete = true;
                    return;
                }
            }
            /*else
            { // if captcha is not enabled, use core function alone
                parent::postAction();
            }*/
        }
        if(!$saveBillingActionComplete)
        { // if captcha is not enabled, use core function alone
            parent::saveBillingAction();
        }
	}
	
}
?>


