<?php

include("../include/database.php");
session_start();
$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];
$data = $database->viewSalesPlan($ulimit, $llimit,$_SESSION['userid']);
//var_dump($data);
$str = '';

if (count($data)) {
    foreach ($data as $key) {
        $str .= "<div>";
        $str .="<row id='" . $count['id'] . "'>";
        $str.= "<div class='row'><div id='partyStockLabel'>Party :</div><div id='partyStockValue'>" . $key['party_name'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>Date :" . "</div></div><br><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>From :</div><div id='partyStockValue'>" . $key['from_date'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>To :</div><div id='partyStockValue'>" . $key['to_date'] . "</div></div><br>";
        $str.="<div class='row'><a href='?mpage=editsalesplan&id=" . $key['id'] . "'><img src='b_edit.png' border='0' title='Edit'>Edit</a>  ";
        $str.="<a href='?mpage=viewsalesplandetail&id=" . $key['id'] . "'>Details</a></div>";
        $str.= "</row>";
        if($count < count($data)-1)
                $str .= "<div class='line-separator'></div>";
        $str.="</div>";
        }
} else {
    $str .= "Record not found for sales plan";
}
echo $str;
?>
