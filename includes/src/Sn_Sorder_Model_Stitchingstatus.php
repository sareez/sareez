<?php

function _construct(){

   $this->_init("stitchingstatus/stitchingstatus");

}

 function getTitle() {

    $statesArray = array();
    foreach($this->getCollection() as $state){
    $statesArray[$state->getStitchingstatusId()] = $state->getTitle();

    }
    return $statesArray;

}