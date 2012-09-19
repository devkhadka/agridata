<?php

include("../include/database.php");

//    session_start();

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$ids = $_GET['id'];
//echo $ids;
$llimit = $_GET['llimit'];
$ulimit = $_GET['ulimit'];

if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'del') {

    if ($_REQUEST['oper'] == 'del') {
        $id = $_REQUEST['id'];
        require_once('../include/class.regex.php');
        if (isset($id) && $reg->isDigit($id)) {
            $database->delPartyStock($id);
            echo true;
        } else {
            echo 'no no ';
        }
    }
} else {

    if (!$sidx)
        $sidx = "";
    if (!$sord)
        $sord = "ASC";

    if (!$limit)
        $limit = 10;
//    echo $ids;
    $count = $database->getViewPartyStockCount($llimit, $ulimit, $ids);
    // calculate the total pages for the query
    if ($count > 0 && $limit > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages)
        $page = $total_pages;

    // calculate the starting position of the rows
    $start = $limit * $page - $limit;

    if ($start < 0)
        $start = 0;

    $data = $database->viewPartyStock($sidx, $sord, $start, $limit, $llimit, $ulimit, $ids);
//    print_r($data);
    //die();
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");

    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";

    $i = 1;
    foreach ($data as $row) {

        $edit = "";
        $delete = "";
        $dummy = "";

        if (time() - strtotime($row['created_date']) < 43200) {
            $edit = "<![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]>";
            $delete = "<![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]>";
            $dummy = 1;
        }
        $s .= "<row id='" . $row['id'] . "'>";
        $s .= "<cell>" . (($page - 1) * $limit + $i) . "</cell>";
        $s .= "<cell>" . $row['collected_date'] . "</cell>";
        $s .= "<cell>" . $row['created_date'] . "</cell>";
//        $s .= "<cell>" . $row['party_name'] . "</cell>";
        $s .= "<cell>" . $row['name'] . " (" . $row['quantity'] . " " . $row['unit_name'] . ")</cell>";
        $s .= "<cell>" . $row['no_of_case'] . "</cell>";
        $s .= "<cell>" . $row['indivisual'] . "</cell>";
        $s .= "<cell>" . $edit . "</cell>";
        $s .= "<cell>" . $delete . "</cell>";
        $s .= "<cell>" . $dummy . "</cell>";
        $s .= "</row>";
        $i++;
    }

    $s .= "</rows>";
    echo $s;
}
?>
