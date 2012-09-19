<?php 

    //global $database;

    include("../include/database.php");


    if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='del'){ 

        if($_REQUEST['oper']=='del'){
            $id=$_REQUEST['id'];
            require_once('../include/class.regex.php');
            if(isset($id) && $reg->isDigit($id)){
               if( $database->delParty($id))
                echo true;
               else
                   echo "no no";
            }
            else{
                echo 'no no ';
            }
        }

    } else {

        // Get the requested page. By default grid sets this to 1. 
        //if(isset($_GET['page']))
            $page = $_GET['page']; 
        //else
        // $page = 1;
        
        // get how many rows we want to have into the grid - rowNum parameter in the grid 
        $limit = $_GET['rows']; 
        
        // get index row - i.e. user click to sort. At first time sortname parameter -
        // after that the index from colModel 
        $sidx = $_GET['sidx']; 
        
        // sorting order - at first time sortorder 
        $sord = $_GET['sord']; 

        // if we not pass at first time index use the first column for the index or what you want 
        if(!$sidx) $sidx =2; 
        if(!$sord) $sord  = "ASC"; 

        if(!$limit) $limit = 10;
        $count = $database->getPartyCount();


        // calculate the total pages for the query 
        if( $count > 0 && $limit > 0) { 
                    $total_pages = ceil($count/$limit); 
        } else { 
                    $total_pages = 0; 
        } 
        // if for some reasons the requested page is greater than the total 
        // set the requested page to total page 
        if ($page > $total_pages) $page=$total_pages;
        
        // calculate the starting position of the rows 
        $start = $limit*$page - $limit;
        // if for some reasons start position is negative set it to 0 // typical case is that the user type 0 for the requested page 

        if($start <0) $start = 0; 
        
        // the actual query for the grid data 
        //$SQL = "SELECT id, username, password, created_date FROM syn_user ORDER BY $sidx $sord LIMIT  $start , $limit"; 
        //$SQL = "SELECT id, username, password, created_date FROM syn_user  LIMIT  0,10";//$start , $limit";

        //echo $SQL;
        $data = $database->viewParty($sidx,$sord,$start,$limit);

        //$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
        
        // we should set the appropriate header information. Do not forget this.
        header("Content-type: text/xml;charset=utf-8");
        
        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .=  "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";



        //$data = $database->viewParty();

        //print_r($data);
        //die();

        // be sure to put text data in CDATA
        $i=1;
        foreach($data as $row){

            $s .= "<row id='". $row['profile_id']."'>";            
            $s .= "<cell>". (($page-1)*$limit+$i)."</cell>";
            $s .= "<cell>". $row['name']."</cell>";
            $s .= "<cell>". $row['username']."</cell>";  
            $s .= "<cell>". $row['address']."</cell>";
            $s .= "<cell>". $row['phone']."</cell>";  
            $s .= "<cell><![CDATA[<img src='b_edit.png' border='0' title='Edit'>]]></cell>";
            $s .= "<cell><![CDATA[<img src='b_drop.png' border='0' title='Delete'>]]></cell>";
            $s .= "</row>";
            $i++;
        }

        $s .= "</rows>"; 
        //echo $data;
        echo $s;
        //die();
    }
?>
