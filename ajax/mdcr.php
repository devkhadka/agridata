<?php
include("../include/database.php");
//$database = new MYSQLDB();
$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord']; 
$id = $_GET['id'];
$ulimit = $_GET['ulimit'];
$llimit = $_GET['llimit'];
if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->approveDcr($id);
                echo true;
            }
            else{
                echo 'no no ';
            }
        }

} else {

	if(!$sidx) $sidx =2; 
	if(!$sord) $sord  = "DESC"; 

	if(!$limit) $limit = 10;
	$count = $database->getViewDcrCount($llimit,$ulimit,$id);
//        var_dump($count);
	// calculate the total pages for the query 
	if( $count > 0 && $limit > 0) { 
				  $total_pages = ceil($count/$limit); 
	} else { 
				  $total_pages = 0; 
	} 
	if ($page > $total_pages) $page=$total_pages;
	 
	// calculate the starting position of the rows 
	$start = $limit*$page - $limit;

	if($start <0) $start = 0; 
	 
	$data = $database->viewDcr($sidx,$sord,$start,$limit,$llimit,$ulimit,$id);
//        print_r($data);
	// we should set the appropriate header information. Do not forget this.
	header("Content-type: text/xml;charset=utf-8");
	 
	$s = "<?xml version='1.0' encoding='utf-8'?>";
	$s .=  "<rows>";
	$s .= "<page>".$page."</page>";
	$s .= "<total>".$total_pages."</total>";
	$s .= "<records>".$count."</records>";


	$i=1;
	$approved;
	foreach($data as $row){
		if($row['approved'] > 0){
			$approved = "<cell><![CDATA[<img src='approved.png' border='0'>]]></cell>";				
		}else{
			$approved = "<cell><![CDATA[<img src='b_drop.png' border='0'>]]></cell>";
		}
		$s .= "<row id='". $row['id']."'>";            
		$s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
		$s .= "<cell>". $row['collected_date']."</cell>";
                $s .= "<cell>". $row['created_date']."</cell>";
		$s .= "<cell>". $row['name']."</cell>";
		$s .= "<cell>". $row['title']."</cell>";  
		$s .= "<cell>". $row['remark']."</cell>"; 
		$s .= $approved;
		$s .= "<cell>".$row['approved']."</cell>";
		$s .= "</row>";
		$i++;
	}

	$s .= "</rows>"; 
	echo $s;
}
?>
