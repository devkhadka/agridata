<?php 

//global $database;

include("../include/database.php");

$database = new MYSQLDB();

$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord']; 
$id = $_GET['id'];
$ulimit = $_GET['ulimit'];
$llimit = $_GET['llimit'];

if(isset($_GET['inv']))
    $interval = $_GET['inv'];
else
    $interval = 0;
    
if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->approveTada($id);
                echo true;
            }
            else{
                echo 'no no ';
            }
        }

} else {    
    

	if(!$sidx) $sidx =2; 
	if(!$sord) $sord  = "ASC"; 

	if(!$limit) $limit = 10;
	$count = $database->getMViewTadaCount($id,$llimit,$ulimit);


	// calculate the total pages for the query 
	if( $count > 0 && $limit > 0) { 
				  $total_pages = ceil($count/$limit); 
	} else { 
				  $total_pages = 0; 
	} 

	if ($page > $total_pages) $page=$total_pages;
	 
	$start = $limit*$page - $limit;

	if($start <0) $start = 0; 
	 
	$data = $database->managerViewTada($sidx,$sord,$start,$limit,$id,$llimit,$ulimit);

//	$retData[] = array('id'=>$key['id'],'visited_date'=>$key['visited_date'],'visit_place'=>$key['visit_place'],'distance'=>$key['distance'],
//		'rate'=>$rate[0],'da'=>$key['da'],'other'=>$key['other'],'remark'=>$key['remark']);
		
//	var_dump($data);die();
	 
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
		$s .= "<cell>". $row['visited_date']."</cell>";
                $s .= "<cell>". $row['created_date']."</cell>";
		$s .= "<cell>". $row['visit_place']."</cell>";
		$s .= "<cell>". ($row['distance']*$row['rate'])."</cell>";  
		$s .= "<cell>". $row['da']."</cell>";  
		$s .= "<cell>". $row['other']."</cell>";  
		$s .= "<cell>". ($row['distance']*$row['rate']+$row['da']+$row['other'])."</cell>";  
		$s .= "<cell>". $row['remark']."</cell>";
		$s .= $approved;  
		$s .= "</row>";
		$i++;
	}

	$s .= "</rows>"; 
	echo $s;
}
?>
