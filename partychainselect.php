<?php
include("./include/database.php");

$database = new MySQLDB; 
echo json_encode( $database->getPartyListInHeadquater($_GET['_value']));

