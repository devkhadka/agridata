<?php
include("../include/database.php");
session_start();
$sidx = "visited_date";
$sord = "ASC";
$start = 0;
$limit = 10;

$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];

$data = $database->viewTada($sidx, $sord, $start, $limit, $llimit, $ulimit);
$str = '';

if (count($data)) {
    foreach ($data as $row) {

        if ($row['approved'] > 0) {
            $approved = "Yes";
        } else {
            $approved = "No";
        }
        $str .= "<div>";
        $str .= "<row id='" . $row['id'] . "'>";
        $str .= "<div class='row'><div id='partyStockLabel'>Date :</div><div id='partyStockValue'>" . $row['visited_date'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>Place :</div><div id='partyStockValue'>" . $row['visit_place'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>TA (km) :</div><div id='partyStockValue'>" . $row['distance'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>DA (Rs.) :</div><div id='partyStockValue'>" . $row['da'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>Others (Rs.) :</div><div id='partyStockValue'>" . $row['other'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>Remarks (Rs.) :</div><div id='partyStockValue'>" . $row['remark'] . "</div></div><br>";
        $str .= "<div class='row'><div id='partyStockLabel'>Approved (Rs.) :</div><div id='partyStockValue'>" . $approved . "</div></div><br>";
        $str .="<div class='row'><a href='?id=" . $row['id'] . "&mpage=edittada'><img src='b_edit.png' border='0' title='Edit'>Edit</a></div>";
        $str.= "</row>";
        if($count < count($data)-1)
                $str .= "<div class='line-separator'></div>";
        $str .="</div>";
    }
} else {
    $str .= "Record not found for tada plan";
}

echo $str;
?>
