<?php 

    include("../include/database.php");

    if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->delProduct($id);
                echo true;
            }
            else{
                echo 'no no ';
            }
        }

    } else {

        $page = $_GET['page']; 
        $limit = $_GET['rows']; 
        $sidx = $_GET['sidx']; 
        $sord = $_GET['sord']; 

        if(!$sidx) $sidx =2; 
        if(!$sord) $sord  = "ASC"; 

        if(!$limit) $limit = 10;
        $count = $database->getProductCount();


        // calculate the total pages for the query 
        if( $count > 0 && $limit > 0) { 
                    $total_pages = ceil($count/$limit); 
        } else { 
                    $total_pages = 0; 
        } 

        if ($page > $total_pages) $page=$total_pages;
        
        $start = $limit*$page - $limit;

        if($start <0) $start = 0; 
        
        $data = $database->viewProduct($sidx,$sord,$start,$limit);

        
        header("Content-type: text/xml;charset=utf-8");
        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .=  "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";

        $i=1;
        foreach($data as $row){
            $active = "";
            if($row['active'] == 1)
                $active = "yes";
            else
                $active = "no";   
            $s .= "<row id='". $row['product_id']."'>";            
            $s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
            $s .= "<cell>". $row['name']."</cell>";
            $s .= "<cell>". $row['quantity']." ".$row['unit_name']."</cell>";
            $s .= "<cell>". $row['no_in_case']."</cell>";  
            $s .= "<cell>". $row['price']."</cell>";  
            $s .= "<cell>". $active ."</cell>";  
            $s .= "<cell><![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]></cell>";
            $s .= "<cell><![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]></cell>";
            $s .= "</row>";
            $i++;
        }

        $s .= "</rows>"; 
        echo $s;
    }
?>
