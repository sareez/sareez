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
ALTER TABLE `{$this->getTable('menu/item')}`   
    CHANGE `attr` `attr` longtext NOT NULL;
");
$installer->endSetup();