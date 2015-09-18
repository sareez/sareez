<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/




$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('menu/menu_store')}`;
CREATE TABLE `{$this->getTable('menu/menu_store')}` (
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `menu_id`  int(11) NOT NULL default '0',
    `store_id` int(11) NOT NULL default '0',
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_menu_menu` FOREIGN KEY (`menu_id`) REFERENCES {$this->getTable('menu/menu')} (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_menu_store` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Menu to Store';
");

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('menu/item_store')}`;
CREATE TABLE `{$this->getTable('menu/item_store')}` (
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `item_id`  int(11) NOT NULL default '0',
    `store_id` int(11) NOT NULL default '0',
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_menu_item_menu_item` FOREIGN KEY (`item_id`) REFERENCES {$this->getTable('menu/item')} (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_menu_item_store` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Menu Item to Store';
");

$installer->run("
ALTER TABLE `{$this->getTable('menu/item')}`
    ADD FOREIGN KEY (`menu_id`) REFERENCES {$this->getTable('menu/menu')} (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$installer->endSetup();