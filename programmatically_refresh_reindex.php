<?php
require_once 'app/Mage.php';
umask( 0 );
Mage :: app( "default" );
$ver = Mage :: getVersion();
$userModel = Mage :: getModel( 'admin/user' );
$userModel -> setUserId( 0 );
Mage :: getSingleton( 'admin/session' ) -> setUser( $userModel );

function refresh_cache() 
{    
    try {
        $allTypes = Mage::app()->useCache();
        foreach($allTypes as $type => $blah) {
          Mage::app()->getCacheInstance()->cleanType($type);
        }
      } catch (Exception $e) {
          echo $e->getMessage() . " <br>";
      }
    try{
        echo "<br>";
        $indexingProcesses = Mage::getSingleton('index/indexer')->getProcessesCollection(); 
        foreach ($indexingProcesses as $process) {
              $process->reindexEverything();
        }
    }
    catch (Exception $e){
        echo $e->getMessage() . " <br>";
    }
}

refresh_cache(); 
echo "<br>";  
echo "All cache types refreshed & all processes reindexed<br />";

?>