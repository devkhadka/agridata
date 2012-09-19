<?php
include("../include/database.php");
$database = new MYSQLDB();
global $user,$database;
//session_start();
$sidx = "";
$sord = "DESC";
$start = 0;
$limit = 10;
$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];
$ids = $_GET['id'];
$str = '';

if($ids > 0){
    $data = $database->viewPartyStock($sidx,$sord,$start,$limit,$llimit,$ulimit,$ids);
    if (count($data)) {
        foreach ($data as $count=>$key) {
            $str .= "<div>";
            $str .= "<row id='" . $count['id'] . "'>";
            $str.= "<div class='row'><div id='partyStockLabel'>Date :</div><div id='partyStockValue'>" . $key['collected_date'] . "</div></div><br>";
            $str.= "<div class='row'><div id='partyStockLabel'>Product :</div><div id='partyStockValue'>" . $key['name'] . " " . $key['quantity'] . " " . $key['unit_name'] . "</div></div><br>";
            $str.= "<div class='row'><div id='partyStockLabel'>Stock :</div>
                    <div id='partyStockValue'>" . $key['no_of_case']."  case";
            $str.= " / " . $key['indivisual'] . " Pcs.</div></div><br>";
            $str .="<div class='row'><a href='?id=" . $key['id'] . "&mpage=editpartystock'><img src='b_edit.png' border='0' title='Edit'>Edit</a></div>";
            $str.= "</row>";
            if($count < count($data)-1)
                $str .= "<div class='line-separator'></div>";
            $str.="</div>";
        }
    } else {
        $str .= "Record not found for Party Stock";
    }
    echo $str;
}else{

    echo "Please select party to view Stocks";
}



?>