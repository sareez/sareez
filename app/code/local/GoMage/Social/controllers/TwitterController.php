<?php
/**
 * GoMage Social Connector Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2013-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2.0
 * @since        Class available since Release 1.1.0
 */

require_once (Mage::getBaseDir('lib') . DS . 'GoMage' . DS . 'Twitter' . DS . 'twitteroauth.php');

class GoMage_Social_TwitterController extends GoMage_Social_Controller_SocialNoMail {

    public function getSocialType() {
        return GoMage_Social_Model_Type::TWITTER;
    }

    public function loginAction() {
        if ($this->getSession()->isLoggedIn()) {
            return $this->_redirectUrl();
        }

        $connection = new TwitterOAuth(Mage::getStoreConfig('gomage_social/twitter/id'), Mage::getStoreConfig('gomage_social/twitter/secret'));
        $callback_params = array('_secure' => true);
		
        if ($this->getRequest()->getParam('gs_url', '')) {
            $callback_params['gs_url'] = $this->getRequest()->getParam('gs_url');
        }
		
        $callback_url	= Mage::getUrl('gomage_social/twitter/callback', $callback_params);
        $request_token	= $connection->getRequestToken($callback_url);

        switch ($connection->http_code) {
            case 200 :
                Mage::getSingleton('core/session')->setData('oauth_token', $request_token['oauth_token']);
                Mage::getSingleton('core/session')->setData('oauth_token_secret', $request_token['oauth_token_secret']);

                $url = $connection->getAuthorizeURL($request_token['oauth_token']);
				
                return $this->_redirectUrl($url);
            break;
            default :
                $this->getSession()->addError($this->__('Could not connect to Twitter. Refresh the page or try again later.'));
        }

        return $this->_redirectUrl();
    }

    public function callbackAction() {
        $oauth_token	= $this->getRequest()->getParam('oauth_token');
        $oauth_verifier	= $this->getRequest()->getParam('oauth_verifier');

        if (!$oauth_token || !$oauth_verifier) {
            return $this->_redirectUrl();
        }
		
        if ($oauth_token != Mage::getSingleton('core/session')->getData('oauth_token')){
            return $this->_redirectUrl();
        }

        $connection		= new TwitterOAuth(
			Mage::getStoreConfig('gomage_social/twitter/id'), 
			Mage::getStoreConfig('gomage_social/twitter/secret'), 
			Mage::getSingleton('core/session')->getData('oauth_token'), 
			Mage::getSingleton('core/session')->getData('oauth_token_secret')
		);
        $access_token	= $connection->getAccessToken($oauth_verifier);

        Mage::getSingleton('core/session')->unsetData('oauth_token');
        Mage::getSingleton('core/session')->unsetData('oauth_token_secret');

        $profile = null;

        switch ($connection->http_code) {
            case 200:
                $profile =  $connection->get('account/verify_credentials');
            break;
            default:
                $this->getSession()->addError($this->__('Could not connect to Twitter. Refresh the page or try again later.'));
                
				return $this->_redirectUrl();
        }
		
        if ($profile) {
            if ($profile->id) {
                $social_collection = Mage::getModel('gomage_social/entity')
                    ->getCollection()
                    ->addFieldToFilter('social_id', $profile->id)
                    ->addFieldToFilter('type_id', GoMage_Social_Model_Type::TWITTER);
					
                if (Mage::getSingleton('customer/config_share')->isWebsiteScope()) {
                    $social_collection->addFieldToFilter('website_id', Mage::app()->getWebsite()->getId());
                }
				
                $social = $social_collection->getFirstItem();
                
				if ($social && $social->getId()) {		
					if ($social->social_id == $profile->id) {
						$customer = Mage::getModel('customer/customer');
						
						if (Mage::getSingleton('customer/config_share')->isWebsiteScope()) {
							$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
						}
						
						$customer->load($social->getData('customer_id'));
					
						if ($customer && $customer->getId()) {
							if (!$customer->getConfirmation()) {
								$this->getSession()->loginById($customer->getId());
							} else {
								$this->getSession()->addError($this->__('This account is not confirmed.'));
							}
						}
					}
                } else {
                    $profile->url			= Mage::getUrl('gomage_social/twitter/checkEmail', array('_secure' => true));
                    $profile->urlEmailClose	= Mage::getUrl('gomage_social/twitter/emailClose', array('_secure' => true));
                    $profile->type_id		= GoMage_Social_Model_Type::TWITTER;
                    
					Mage::getSingleton('core/session')->setGsProfile($profile);
                }
            }
        }

      return $this->_redirectUrl();
    }
}