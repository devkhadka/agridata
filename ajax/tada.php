<?php

    include("../include/database.php");

    $page = $_GET['page']; 
    $limit = $_GET['rows']; 
    $sidx = $_GET['sidx']; 
    $sord = $_GET['sord']; 
	session_start();
    $llimit = $_GET['llimit'];
    $ulimit = $_GET['ulimit'];

    if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
                $database->delTada($id);
                echo true;
            }
            else{
                echo 'no no ';
            }
        }

    } else {

        if(!$sidx) $sidx ="visited_date"; 
        if(!$sord) $sord  = "DESC"; 

        if(!$limit) $limit = 10;
        $count = $database->getTadaCount($llimit,$ulimit);

        // calculate the total pages for the query 
        if( $count > 0 && $limit > 0) { 
                    $total_pages = ceil($count/$limit); 
        } else { 
                    $total_pages =1; 
        } 
        if ($page > $total_pages) $page=$total_pages;
        
        // calculate the starting position of the rows 
        $start = $limit*$page - $limit;

        if($start <0) $start = 0; 
        
        $data = $database->viewTada($sidx,$sord,$start,$limit,$llimit,$ulimit);

        //print_r($data);
        //die();
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
            
            $edit="";
            $delete="";
            $dummy="";
            if(!($user->level == MMR_LEVEL)){

            if(time()-strtotime($row['created_date']) < 43200){
                $edit ="<![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]>";
                $delete = "<![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]>";
                $dummy = "1";
            }
            }
        
            
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
            $s .= "<cell>". $row['distance']."</cell>";  
            $s .= "<cell>". $row['da']."</cell>";  
            $s .= "<cell>". $row['other']."</cell>";  
            $s .= "<cell>". $row['remark']."</cell>"; 
            $s .= $approved; 
            $s .= "<cell>".$edit."</cell>";
            $s .= "<cell>".$delete."</cell>";
            $s .= "<cell>".$dummy."</cell>";
            $s .= "</row>";
            $i++;
        }

        $s .= "</rows>"; 
        echo $s;
    }
?>
