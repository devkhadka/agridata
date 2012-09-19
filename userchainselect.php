<?php
include("./include/database.php");

$database = new MySQLDB; 
//
//global $database;
/*
if($_GET['_value'] != "Others")
{

        if($db->query("SELECT id,name FROM `pm_model` where `manufacturerid` =".$_GET['_value']." AND `other` = \"rec\"",SQL_ALL,SQL_ASSOC))
                $routerModel = $db->record;

        foreach($routerModel as $key)
        {
                $array[] = array($key['id'] => $key['name']);
        }

        $array[] = array("Others" => "Others...");
}
else
{
        $array[] = array("Others" => "Others...");
}
*/
echo json_encode( $database->getUserListInHeadquater($_GET['_value']));

?>
