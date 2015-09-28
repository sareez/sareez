<?php
require_once 'app/Mage.php';
umask( 0 );
Mage :: app( "default" );

$processes = Mage::getSingleton('index/indexer')->getProcessesCollection();
$processes->walk('setMode', array(Mage_Index_Model_Process::MODE_MANUAL));
$processes->walk('save');
// Here goes your
// Importing process
// ................
$processes->walk('reindexAll');
$processes->walk('setMode', array(Mage_Index_Model_Process::MODE_REAL_TIME));
$processes->walk('save');
?>