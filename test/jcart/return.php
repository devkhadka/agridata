<?php
    include('logging.php');
        
    $log = new Logging();
        
    foreach( $_REQUEST as $key=>$value){
        $log->lwrite($key." : ".$value,'Request'); 
    }

    foreach( $_POST as $key=>$value){
        $log->lwrite($key." : ".$value,'Post'); 
    }
?>
