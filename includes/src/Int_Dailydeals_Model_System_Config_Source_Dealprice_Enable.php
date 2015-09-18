<?php

class Int_Dailydeals_Model_System_Config_Source_Dealprice_Enable
{
       public function toOptionArray()
       {
               return array(
                       array('value' => 0, 'label' => 'No'),
                       array('value' => 1, 'label' => 'Yes'),
               );
       }
}