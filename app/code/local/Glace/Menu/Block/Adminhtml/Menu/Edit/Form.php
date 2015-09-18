<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Menu_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected $_additionalButtons = array();

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('glace/menu/edit/form.phtml');
    }

    protected function _prepareLayout()
    {
        $menuId = $this->getMenuId();

        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('menu')->__('Save Menu'),
                    'onclick' => "menuSubmit('" . $this->getSaveUrl() . "', true)",
                    'class'   => 'save'
                ))
        );

        if ($menuId) {
            $this->setChild('delete_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'   => Mage::helper('menu')->__('Delete Menu'),
                        'onclick' => "menuDelete('" . $this->getUrl('*/*/delete', array('_current' => true)) . "', true, {$menuId})",
                        'class'   => 'delete'
                    ))
            );
        }

        $this->setChild('tabs',
            $this->getLayout()->createBlock('menu/adminhtml_menu_tabs', 'tabs')
        );
        return parent::_prepareLayout();
    }

    public function getSaveUrl(array $args = array())
    {
        $params = array('_current'=>true);
        $params = array_merge($params, $args);
        return $this->getUrl('*/*/save', $params);
    }

    public function getTabsHtml()
    {
        return $this->getChildHtml('tabs');
    }

    public function getMenu()
    {
        return Mage::registry('current_menu');
    }

    public function getMenuId()
    {
        if ($this->getMenu()) {
            return $this->getMenu()->getId();
        }
    }

    public function getHeader()
    {
        if ($this->getMenuId()) {
            return $this->getMenu()->getName();
        } else {
            return Mage::helper('menu')->__('New Menu');
        }
    }

    public function getDeleteUrl(array $args = array())
    {
        $params = array('_current'=>true);
        $params = array_merge($params, $args);
        return $this->getUrl('*/*/delete', $params);
    }

    /**
     * Return URL for refresh input element 'path' in form
     *
     * @param array $args
     * @return string
     */
    public function getRefreshPathUrl(array $args = array())
    {
        $params = array('_current'=>true);
        $params = array_merge($params, $args);
        return $this->getUrl('*/*/refreshPath', $params);
    }

    public function getProductsJson()
    {
        $products = $this->getCategory()->getProductsPosition();
        if (!empty($products)) {
            return Mage::helper('core')->jsonEncode($products);
        }
        return '{}';
    }

    public function isAjax()
    {
        return Mage::app()->getRequest()->isXmlHttpRequest() || Mage::app()->getRequest()->getParam('isAjax');
    }
}
