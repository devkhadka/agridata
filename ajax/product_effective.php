<?php

include("../include/database.php");
session_start();
$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
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
    $id = $_REQUEST['id'];
    //$llimit = "2011-07-01";
    //$ulimit = "2011-07-15";
    $id = $_GET['id'];

    $count = $database->getProductDetailCount($id);

    $data = $database->viewProductDetail($id);
//    var_dump($data);
    header("Content-type: text/xml;charset=utf-8");
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";

    $i = 1;
    foreach ($data as $row) {
        $s .= "<row id='" . $row['id'] . "'>";
        $s .= "<cell>" . (($page - 1) * $limit + $i) . "</cell>";
        $s .= "<cell>" . $row['effective_date'] . "</cell>";
        $s .= "<cell>" . $row['price'] . "</cell>";

        $s .= "</row>";
        $i++;
    }

    $s .= "</rows>";
    echo $s;
}
?>
