<?php 


    include("../include/database.php");

    $page = $_GET['page']; 
    $limit = $_GET['rows']; 
    $sidx = $_GET['sidx']; 
    $sord = $_GET['sord']; 
    $id = $_GET['id'];

    if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->delStock($id);
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
        $count = $database->getViewStockDetailCount($id);


        // calculate the total pages for the query 
        if( $count > 0 && $limit > 0) { 
                    $total_pages = ceil($count/$limit); 
        } else { 
                    $total_pages = 0; 
        } 

        if ($page > $total_pages) $page=$total_pages;
        
        $start = $limit*$page - $limit;

        if($start <0) $start = 0; 
        
        $data = $database->viewStockDetail($sidx,$sord,$start,$limit,$id);

        
        header("Content-type: text/xml;charset=utf-8");
        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .=  "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";

        $i=1;
        foreach($data as $row){
            
            $edit="";
            $delete="";
        
            if(time()-strtotime($row['created_date']) < 43200){
                $edit ="<![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]>";
                $delete = "<![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]>";
            }

            $s .= "<row id='". $row['id']."'>";            
            $s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
            $s .= "<cell>". $row['ri_date']. "</cell>";
            $s .= "<cell>". $row['receive_qty']."</cell>";  
            $s .= "<cell>". $row['issue_qty']."</cell>";  
            $s .= "<cell>". $edit."</cell>";  
            $s .= "<cell>". $delete."</cell>";  
            $s .= "</row>";
            $i++;
        }

        $s .= "</rows>"; 
        echo $s;
    }
?>
