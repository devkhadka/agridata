<?php
include("../include/database.php");
$name = $_GET['party_id'];

$data = $database->getPartyDue($name);

if(is_array($data)){
    echo $data[0]['amount'];
}else{
    echo $data;
}
?>
