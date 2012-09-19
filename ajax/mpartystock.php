<?php
//global $database;

include("../include/database.php");

$database = new MYSQLDB();

$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord']; 
$id = $_GET['id'];
//$inv = $_GET['inv'];
$ulimit = $_GET['ulimit'];
$llimit = $_GET['llimit'];
if(!$sidx) $sidx =2; 
if(!$sord) $sord  = "DESC"; 

//if(!$limit) $limit = 10;
$count = $database->getmViewPartyStockCount($id,$llimit,$ulimit);

// calculate the total pages for the query 
if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
} else { 
              $total_pages = 0; 
} 
if ($page > $total_pages) 
	$page=$total_pages;
 
// calculate the starting position of the rows 
$start = $limit*$page - $limit;

if($start <0) $start = 0; 

$limit = $count;
//$start = 0;

$data = $database->mViewPartyStock($sidx,$sord,$start,$limit,$id,$llimit,$ulimit);
//var_dump($data);
//die();

//print_r($data);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";

$i=1;
$total = 0;
foreach($data as $key=>$row){
//    echo $row['price'];
    $total+=$row['price']*$row['no_in_case']*$row['no_of_case']+($row['price']*$row['indivisual']);
//    $s .= "<row id='". $row['id']."'>";
    $s .= "<row id='". $key."'>";
    $s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
    $s .= "<cell>". $row['collected_date']."</cell>";
    $s .= "<cell>". $row['created_date']."</cell>";
    $s .= "<cell>". $row['name']." (".$row['quantity']." ".$row['unit_name'].")</cell>";
    $s .= "<cell>". $row['price']."</cell>";  
    $s .= "<cell>". $row['no_in_case']."</cell>";  
    $s .= "<cell>". $row['no_of_case']."</cell>";  
    $s .= "<cell>". $row['indivisual']."</cell>";  
    $s .= "<cell>". ($row['price']*$row['no_in_case']*$row['no_of_case']+($row['price']*$row['indivisual']))."</cell>";  
    $s .= "</row>";
    $i++;
}

$s .="<row id='0'><cell></cell><cell></cell><cell>Grand Total : </cell><cell></cell><cell></cell><cell></cell><cell></cell><cell>".$total."</cell></row>";

$s .= "</rows>"; 
echo $s;

 
/*
$response->page = $page;
$response->total = $total_pages;
$response->records = $count;
$i=0;
$total=0;


foreach($data as $row){
    $total+= ($row['price']*$row['no_in_case']*$row['no_of_case']);
    //$response->$rows[$i]['id'] = $i;
    $response->$rows[$i]['cell']=array((($page-1)*$limit+$i),$row[collected_date],$row[name]." (".$row[quantity]." ".$row[unit_name].")",$row[price],$row[no_in_case],$row[no_of_case],($row[price]*$row[no_in_case]*$row[no_of_case]));
    $i++;
}
$response->userData['product']='Totals :';
$response->userData['amount']=$total;

echo json_encode($response);
 */
?>
