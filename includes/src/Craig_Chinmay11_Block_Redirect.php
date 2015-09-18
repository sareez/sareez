<?php

/*
 * Magento
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
 * @category   Craig Christenson
 * @package    Chinmay (2Checkout.com)
 * @copyright  Copyright (c) 2010 Craig Christenson
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */



class Craig_Chinmay_Block_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $Chinmay = Mage::getModel('Chinmay/checkout');

        $form = new Varien_Data_Form();
        $form->setAction($Chinmay->getUrl())
            ->setId('Chinmaypay')
            ->setName('Chinmaypay')
            ->setMethod('POST')
            ->setUseContainer(true);
        $Chinmay->getFormFields();
        foreach ($Chinmay->getFormFields() as $field=>$value) {
           $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value, 'size'=>200));
        }
        $form->addField('Chinmaysubmit', 'submit', array('name'=>'Chinmaysubmit'));

        $html = '<style> #Chinmaysubmit {display:none;} </style>';
        $html .= $form->toHtml();

        return $html;
    }
}

?>
