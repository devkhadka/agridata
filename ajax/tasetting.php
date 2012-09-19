<?php 

    include("../include/database.php");


    $page = $_GET['page']; 
    $limit = $_GET['rows']; 
    $sidx = $_GET['sidx']; 
    $sord = $_GET['sord']; 

    if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->delTASetting($id);
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

        $count = $database->getTASettingCount();

        // calculate the total pages for the query 
        if( $count > 0 && $limit > 0) { 
                    $total_pages = ceil($count/$limit); 
        } else { 
                    $total_pages = 0; 
        } 
        // set the requested page to total page 
        if ($page > $total_pages) $page=$total_pages;
        
        // calculate the starting position of the rows 
        $start = $limit*$page - $limit;

        if($start <0) $start = 0; 

        //echo $SQL;
        $data = $database->getTASetting($sidx,$sord,$start,$limit);

        // we should set the appropriate header information. Do not forget this.
        header("Content-type: text/xml;charset=utf-8");
        
        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .=  "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";


        // be sure to put text data in CDATA
        $i=1;
        foreach($data as $row){
//            $active = "no";
//            if($row['active'] == '1')
//                $active = "yes";
            
            $s .= "<row id='". $row['id']."'>";            
            $s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
            $s .= "<cell>". $row['username']."</cell>";
//            $s .= "<cell>". $row['amount']." ".$row['unit_name']."</cell>";
            $s .= "<cell>". $row['amount']."</cell>";
            $s .= "<cell>". $row['date']."</cell>";  
            $s .= "<cell><![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]></cell>";
            $s .= "<cell><![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]></cell>";
            $s .= "</row>";
            $i++;
        }

        $s .= "</rows>"; 
        echo $s;
}
?>
