<?php
class Int_Manufacturers_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
    public function getAvailableOrders()
    {
        // return $this->_availableOrder;
        
        $t = array(
            'created_at'    => $this->__('Newest'),                // sort by Date option (default)
            'position'      => $this->__('Best Value'),
            'name'          => $this->__('Name'),
            'price'         => $this->__('Price')
        );
              
        return $t;
    }
    public function getCurrentDirection()
    {
        $dir = $this->_getData('_current_grid_direction');
        if ($dir) {
            return $dir;
        }

        $directions = array('asc', 'desc');
        $dir = strtolower($this->getRequest()->getParam($this->getDirectionVarName()));
        if ($dir && in_array($dir, $directions)) {
            if ($dir == $this->_direction) {
                Mage::getSingleton('catalog/session')->unsSortDirection();
            } else {
                $this->_memorizeParam('sort_direction', $dir);
            }
        } else {
            $dir = Mage::getSingleton('catalog/session')->getSortDirection();
        }
        // validate direction
        if (!$dir || !in_array($dir, $directions)) {
            $dir = $this->_direction;
        }
        if($this->_getData('_current_grid_order')=='created_at')
        {
            $dir = 'desc';
        }
        $this->setData('_current_grid_direction', $dir);
        return $dir;
    }
} 
?>