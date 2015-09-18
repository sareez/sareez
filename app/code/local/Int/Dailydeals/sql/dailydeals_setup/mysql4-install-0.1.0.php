<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('dailydeals')};
CREATE TABLE {$this->getTable('dailydeals')} (
	`dailydeals_id` int(11) unsigned NOT NULL auto_increment,
	`title` varchar(255) NOT NULL ,
	`deal_price` varchar(255) NOT NULL ,
	`deal_qty` varchar(255) NOT NULL ,
	`date_start` timestamp NULL,
	`status` int(11) NOT NULL default '0',
	`date_end` timestamp NULL,
	`store_id` varchar(255) NOT NULL ,
	`product_disable` int(11) NOT NULL,
	`position` int(11) NOT NULL , 
	`related_product` varchar(255) NOT NULL ,
	`qty_sold` varchar(255) NOT NULL ,
	`deal_status` varchar(255) NOT NULL ,
	PRIMARY KEY (`dailydeals_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 ");
 
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('dealviewer')};
CREATE TABLE {$this->getTable('dealviewer')} (
	`id` int(11) unsigned NOT NULL auto_increment,	
	`deal_id` int(11) NOT NULL , 
	`ipaddress` varchar(255) NOT NULL ,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 