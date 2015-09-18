<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('productqa')};
CREATE TABLE {$this->getTable('productqa')} (
  `productqa_id` int(11) unsigned NOT NULL auto_increment,
  `product_sku` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `cutomer_email_status` smallint(6) NOT NULL DEFAULT '2',
  `status` smallint(6) NOT NULL DEFAULT '2',
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,  
  PRIMARY KEY (`productqa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
