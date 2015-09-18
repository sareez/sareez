<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */

class Int_Dailydeals_Model_Related extends Mage_Core_Model_Abstract{

    const NOROUTE_PAGE_ID = 'no-route';

    public function _construct(){
        parent::_construct();
        $this->_init('dailydeals/related');
    }

    /*public function load($id, $field=null){
        return parent::load($id, $field);
    }
    */

    public function noRoutePage(){
        $this->setData($this->load(self::NOROUTE_PAGE_ID, $this->getIdFieldName()));
        return $this;
    }

}
