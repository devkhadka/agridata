<?php

include ("../include/database.php");
session_start();
$sidx = 2;
$sord = "DESC";
$start = 0;
$limit = 10;
$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];
$data = $database->viewDcr($sidx, $sord, $start, $limit, $llimit, $ulimit);
$str = '';

if (count($data)) {
    foreach ($data as $row) {
        if ($row['approved'] > 0) {
            $approved = "Yes";
        } else {
            $approved = "No";
        }
        $str.="<div>";
        $str .= "<row id='" . $row['id'] . "'>";
        $str.= "<div class='row'><div id='partyStockLabel'>Date : </div><div id='partyStockValue'>" . $row['collected_date'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>Customer : </div><div id='partyStockValue'>" . $row['name'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>Title : </div><div id='partyStockValue'>" . $row['title'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>Remarks : </div><div id='partyStockValue'>" . $row['remark'] . "</div></div><br>";
        $str.= "<div class='row'><div id='partyStockLabel'>Approved : </div><div id='partyStockValue'>" . $approved . "</div></div><br>";
        $str.="<div class='row'><a href='?id=" . $row['id'] . "&mpage=editdcr'><img src='b_edit.png' border='0' title='Edit'>Edit</a></div>";
        $str.= "</row>";
         if($count < count($data)-1)
                $str .= "<div class='line-separator'></div>";
            $str.="</div>";
    }
} else {
    $str.= "Record not found for DCR";
}
echo $str;
?>
