<?php
    require_once 'app/Mage.php';
    $app = Mage::app('admin');
    umask(0);
    $indexingProcesses = Mage::getSingleton('index/indexer')->getProcessesCollection(); 
foreach ($indexingProcesses as $process) {
    $process->reindexEverything();
}
 ?>