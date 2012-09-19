<?php 
//include the information needed for the connection to MySQL data base server. 
// we store here username, database and password 
include ("../include/constants.php");
$dbhost=DB_SERVER;
$dbuser=DB_USER;
$dbpassword=DB_PASS;
$database=DB_NAME;
 
// connect to the MySQL database server 
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error()); 
//echo "dev"; 
// select the database 
mysql_select_db($database) or die("Error connecting to db."); 
if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='edituser'){ 
    if($_REQUEST['oper']=='del'){
        //print_r($_REQUEST);
        $id=$_REQUEST['id'];
        require_once('../include/class.regex.php');
        if(isset($id) && $reg->isDigit($id)){
            mysql_query("delete from syn_user where id=$id") or die(mysql_error());
            echo true;
        }
        else{
            echo 'no no ';
        }
    }
    else{
       // print_r($_REQUEST);
        require_once('../include/database.php');
                echo $database->updateUserValues($_REQUEST);
    }

}else{

// Get the requested page. By default grid sets this to 1. 
$page = $_GET['page']; 
 
// get how many rows we want to have into the grid - rowNum parameter in the grid 
$limit = $_GET['rows']; 
 
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
$sidx = $_GET['sidx']; 
 
// sorting order - at first time sortorder 
$sord = $_GET['sord']; 
 
// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1; 
 

$sql="select COUNT(tbl.username) as count from (SELECT
main_user.username AS username,
syn_profile.name,
manager.username AS manager_name,
syn_access.name AS level,
headquarter.name AS headquarter_name
FROM
syn_user AS main_user
Left Join syn_user AS manager ON main_user.manager_id = manager.id
Left Join syn_access ON main_user.access_value = syn_access.access_value
Inner Join syn_profile ON main_user.profile_id = syn_profile.id
Left Join syn_user_headquater ON syn_user_headquater.user_id = main_user.id
Left Join syn_headquater ON syn_user_headquater.headquater_id = syn_headquater.id
left Join syn_profile AS headquarter ON headquarter.id = syn_headquater.profile_id)  as tbl";
// calculate the number of rows for the query. We need this for paging the result 
$result = mysql_query($sql); 
$row = mysql_fetch_array($result,MYSQL_ASSOC); 
$count = $row['count']; 
 
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
 
// if for some reasons start position is negative set it to 0 
// typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 
 
// the actual query for the grid data 
//$SQL = "SELECT id, invdate, amount, tax,total, note FROM invheader ORDER BY $sidx $sord LIMIT  $start , $limit"; 
$SQL="SELECT
main_user.username AS username,
main_user.id AS uid,
syn_profile.name,
manager.username AS manager_name,
syn_access.name AS level,
headquarter.name AS headquarter_name
FROM
syn_user AS main_user
Left Join syn_user AS manager ON main_user.manager_id = manager.id
Left Join syn_access ON main_user.access_value = syn_access.access_value
Inner Join syn_profile ON main_user.profile_id = syn_profile.id
Left Join syn_user_headquater ON syn_user_headquater.user_id = main_user.id
Left Join syn_headquater ON syn_user_headquater.headquater_id = syn_headquater.id
left Join syn_profile AS headquarter ON headquarter.id = syn_headquater.profile_id";
//echo $SQL;
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
 
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $s .= "<row id='". $row['uid']."'>";
    $s .= "<cell>". $row['username']."</cell>";
    $s .= "<cell>". $row['name']."</cell>";
    $s .= "<cell>". $row['manager_name']."</cell>";
    $s .= "<cell>". $row['level']."</cell>";
    //$s .= "<cell>". $row[headquarter_name]."</cell>";
    $s .= "<cell><![CDATA[]]></cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
echo $s;
}
?>
