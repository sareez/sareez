<?php

class Qualityunit_Liveagent_Model_Settings extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('liveagent/settings');
	}
}