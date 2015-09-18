<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Model_System_Config_Source_Category
{
    public function buildCategoriesMultiselectValues(Varien_Data_Tree_Node $node, $values, $level = 0)
    {
        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');

        $level++;
        $values[$node->getId()]['value'] = $node->getId();
        $values[$node->getId()]['label'] = str_repeat($nonEscapableNbspChar, ($level - 1) * 5).$node->getName();

        foreach ($node->getChildren() as $child) {
            $values = $this->buildCategoriesMultiselectValues($child, $values, $level);
        }

        return $values;
    }

    public function toOptionArray()
    {
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $store    = 1;
        $parentId = 1;

        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $root = $tree->getNodeById($parentId);

        if($root && $root->getId() == 1) {
            $root->setName(Mage::helper('catalog')->__('Root'));
        }

        $collection = Mage::getModel('catalog/category')->getCollection()
            ->setStoreId($store)
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');

        $tree->addCollectionData($collection, true);

        return $this->buildCategoriesMultiselectValues($root, array());
    }
}
