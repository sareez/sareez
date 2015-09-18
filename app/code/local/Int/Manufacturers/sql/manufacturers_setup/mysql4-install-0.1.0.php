<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('manufacturers')};
CREATE TABLE {$this->getTable('manufacturers')} (
	`manufacturers_id` int(11) unsigned NOT NULL auto_increment,  
	 `manufacturers_name` varchar(255) NOT NULL default '', 
     `manufacturers_email` varchar(255) default '',   	 
	 `manufacturers_phone` varchar(255) default '',                
     `manufacturers_address` varchar(255) default '',
	 `manufacturers_image` varchar(255) default '',	
	 `manufacturers_url` varchar(255) default NULL,
	 `url_clicked` varchar(255) default '',  	
     `date_last_click` datetime default NULL, 
	 `manufacturers_htc_title_tag` varchar(255) default NULL,
     `manufacturers_htc_description` text,	 
     `manufacturers_htc_keywords_tag` text,    
	 `status` tinyint(11) default NULL,  
	 `date_added` datetime default NULL,                         
	 `last_modified` datetime default NULL,
	 PRIMARY KEY  (`manufacturers_id`)                             
	) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;");
	

$installer->endSetup(); 
