<?php
	include_once ('../app/Mage.php');
	umask(0);
	Mage::app('default');
	
	class AjaxHandler {
		private $_resource = NULL;
		private $_request;
		private $_response;
		public function __construct () {
			$this->_resource = Mage::getSingleton('core/resource');
			$this->_request = array(
				'method' 	=> strtoupper($_SERVER['REQUEST_METHOD']),
				'params'	=> $_REQUEST,
				'allowed'	=> array()
			);
			if (!$this->_isValidRequest()) {	
				print Zend_Json::encode(array(
					'error' 	=> true,
					'message'	=> 'Invalid Reqeust !!'
				));
				return;
			}
			$this->handler();
		}
		private function _isValidRequest () {
			$action = $this->getParam('action');
			if (isset($action)) {
				if ($this->_request['method'] == 'GET') {
					return in_array($action, $this->_request['allowed']);
				}
				return in_array($action, get_class_methods($this));
			}
		}
		public function getParam ($param = '') {
			if (empty($param)) {
				return $this->_request['params'];
			}
			return (isset($this->_request['params'][$param])? $this->_request['params'][$param]: NULL);
		}
		public function handler () {
			call_user_method($this->getParam('action'), $this);
		}
		public function loadproduct () {
			echo $catId = $this->getParam('catId');
			
			//$html = 'Test';
			//echo $this->getLayout()->createBlock('catalog/product_list')->setTemplate('catalog/product/store-list.phtml')->setCategoryId($category_id)->toHtml();
			
			$html = Mage::app()->getLayout()->createBlock('core/template')->setTemplate('page/productslidecontent.phtml')->toHtml(); 
			
			
			
		 print Zend_Json::encode(array(
				'error' 			=> false,
				'html'				=> $html
			));
		}		
	}
	$ajax = new AjaxHandler();
?>