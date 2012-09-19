<?php
include("../include/database.php");
session_start();
$sidx = 2;
$sord = "DESC";
$start = 0;
$limit = 10;

$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];

$data = $database->viewVisitplan($sidx, $sord, $start, $limit, $llimit, $ulimit);
$s = '';
$approved = '';
if (count($data)) {
    foreach ($data as $row) {

        if ($row['approved'] > 0) {
            $approved = "Yes";
        } else {
            $approved = "No";
        }
           $s.="<div>";
        $s .= "<row id='" . $row['id'] . "'>";
        $s.= "<div class='row'><div id='partyStockLabel'>Date :</div><div id='partyStockValue'>" . $row['collected_date'] . "</div></div><br>";
        $s.= "<div class='row'><div id='partyStockLabel'>Place :</div><div id='partyStockValue'>" . $row['place'] . "</div></div><br>";
        $s.= "<div class='row'><div id='partyStockLabel'>Remarks :</div><div id='partyStockValue'>" . $row['remark'] . "</div></div><br>";
        $s.= "<div class='row'><div id='partyStockLabel'>Approved :</div><div id='partyStockValue'>" . $approved . "</div></div><br>";
        $s .="<div class='row'><a href='?id=" . $row['id'] . "&mpage=editvisitplan'><img src='b_edit.png' border='0' title='Edit'>Edit</a></div>";
        $s .= "</row><hr>";
    }
} else {
    $s .= "Record not found for visit plan";
}

echo $s;
?>
