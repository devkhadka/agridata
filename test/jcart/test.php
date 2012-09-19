<?php
    include('logging.php');
        
    $log = new Logging();
        
    foreach( $_POST as $key=>$value){
        $log->lwrite($key." : ".$value,'Post'); 
    }
?>
