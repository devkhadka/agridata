<?php
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 */
include("constants.php");

class MySQLDB
{
    var $connection;         //The MySQL database connection


    /* Class constructor */
    function MySQLDB(){


        /* Make connection to database */
        $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
        mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());

    }

    /**
     * confirmUserPass - Checks whether or not the given
     * username is in the database, if so it checks if the
     * given password is the same password in the database
     * for that user. If the user doesn't exist or if the
     * passwords don't match up, it returns an error code
     * (1 or 2). On success it returns 0.
     */
    function confirmUserPass($username, $password){
        /* Add slashes if necessary (for query) */
        if(!get_magic_quotes_gpc()) {
            $username = addslashes($username);
        }

        /* Verify that user is in database */
        $q = "SELECT password ,access_value FROM ".TBL_USERS." WHERE username = '$username'";
        // $result = mysql_query($q, $this->connection);
        $result= $this->query($q);
        if(!$result ){
            return 1; //Indicates username failure
        }

        /* Retrieve password from result, strip slashes */
        $dbarray = mysql_fetch_array($result);
        $dbpass = $dbarray['password'] = stripslashes($dbarray['password']);
        $password = stripslashes($password);
        $access=$dbarray['access_value'];
        if($access<=0){
            return -1;
        }
        /* Validate that password is correct */
        if($password == $dbpass){
            return 0; //Success! Username and password confirmed

        }
        else{
            return 2; //Indicates password failure
        }
    }
    /**
     * usernameTaken - Returns true if the username has
     * been taken by another user, false otherwise.
     */
    function usernameTaken($username){
        if(!get_magic_quotes_gpc()){
            $username = addslashes($username);
        }
        $q = "SELECT syn_user.id FROM  syn_user where syn_user.username =  '{$username}'";
        $result = mysql_query($q, $this->connection);
        return (mysql_numrows($result) > 0);
    }
    function getUserName($email){
        if(!get_magic_quotes_gpc()){
            $username = addslashes($email);
        }
        $q = "SELECT syn_user.username FROM syn_infoTitle Inner Join syn_infoValues ON syn_infoTitle.id = syn_infoValues.info_id Inner Join syn_user ON syn_infoValues.profile_id = syn_user.profile_id WHERE syn_infoTitle.title =  'email' AND syn_infoValues.value =  '{$email}'";
        $result = mysql_query($q, $this->connection);
        $ret= mysql_fetch_array($result);
        return $ret[0];
    }

    /**
     * usernameBanned - Returns true if the username has
     * been banned by the administrator.
     */
    function usernameBanned($username){
        if(!get_magic_quotes_gpc()){
            $username = addslashes($username);
        }
        $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
        $result = mysql_query($q, $this->connection);
        return (mysql_numrows($result) > 0);
    }

    /**
     * addNewUser - Inserts the given (username, password, email)
     * info into the database. Appropriate user level is set.
     * Returns true on success, false otherwise.
     */
    function addUser($args){
        //first insert name in the profile table
        $sql = "INSERT INTO `syn_profile` (`name`) VALUES ( '{$args['name']}');";
        if(!$this->query($sql)){
            return false;
        }
        $profileId= mysql_insert_id();
        $args['pass']=md5($args['pass']);
        $sql = "INSERT INTO `syn_user` (`username`, `password`, `access_value`, `profile_id`) VALUES ( '{$args['username']}', '{$args['pass']}', '1', '{$profileId}');";      
        if(!$this->query($sql)){
            return false;
        }
        if(!$this->insertInfoValues($profileId,$args['phone'],'phone')) return false;
        if(!$this->insertInfoValues($profileId,$args['addl1'],'addl1')) return false;
        if(!$this->insertInfoValues($profileId,$args['email'],'email')) return false;
        if(!$this->insertInfoValues($profileId,$args['addl2'],'addl2')) return false;
        
        return true;
    }

    /**
     * updateUserField - Updates a field, specified by the field
     * parameter, in the user's row of the database.
     */
    function updateUserField($userid, $field, $value){
        $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE id = '$userid'";
        return mysql_query($q, $this->connection);
    }
    function updateUserFieldByName($userid, $field, $value){
        $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$userid'";
        return mysql_query($q, $this->connection);
    }

    /**
     * getUserInfo - Returns the result array from a mysql
     * query asking for all information stored regarding
     * the given username. If query fails, NULL is returned.
     */
    function getUserInfo($username){
        $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
        
        $result = mysql_query($q, $this->connection);
        /* Error occurred, return given name by default */
        if(!$result || (mysql_numrows($result) < 1)){
            return NULL;
        }
        /* Return result array */
        $dbarray = mysql_fetch_array($result);
        return $dbarray;
    }

    /**
     * query - Performs the given query on the database and
     * returns the result, which may be false, true or a
     * resource identifier.
     */
    function query($query){
        return mysql_query($query, $this->connection);
    }

    function getUserList(){

        $data = array();
        $query = "SELECT id,username FROM syn_user";
        $result = mysql_query($query,$this->connection);

        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }
    function getManagerUserList(){

        $data = array();
        $query = "SELECT id,username FROM syn_user where access_value=4";
        $result = mysql_query($query,$this->connection);

        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }
    function addTASetting($args){

        //print_r($args);
        //die();
        $query = "INSERT INTO syn_TASetting (user_id,amount,effective_date) values (".$args['user_id'].",".$args['amount'].",'".$args['effective_date']."')";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
        return false;   
    }

    function editTASetting($args){

        //print_r($args);
        //die();
        $query = "UPDATE syn_TASetting SET syn_TASetting.amount = {$args['amount']}, syn_TASetting.effective_date = '{$args['effective_date']}',syn_TASetting.user_id = {$args['user_id']} where syn_TASetting.id = {$args['id']}";
        //echo $query;
        $result = mysql_query($query,$this->connection);

        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
        return false;   
    }

    function delTASetting($id){
        $query = "DELETE FROM syn_TASetting WHERE syn_TASetting.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;
    }

    function getTASettingById($id){
        
        $query ="SELECT syn_TASetting.id,syn_TASetting.amount,syn_TASetting.effective_date,syn_TASetting.user_id FROM syn_TASetting WHERE syn_TASetting.id = {$id}";
        //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }

    function getTASetting($sidx,$sord,$start,$limit){
        $data = array();
        $query = "SELECT syn_TASetting.id as id, username, amount, max(effective_date) as date "
                ."FROM syn_TASetting, syn_user "
                ."WHERE syn_TASetting.user_id = syn_user.id "
                ."GROUP BY user_id "
                ."ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";

        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getTASettingCount(){

        $query = "SELECT syn_TASetting.id as id, username, amount, max(effective_date) as date "
                ."FROM syn_TASetting, syn_user "
                ."WHERE syn_TASetting.user_id = syn_user.id "
                ."GROUP BY user_id ";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }
    //--------party-----------------------
    
    function addParty($args){
        //print_r($args);
        //die();
        $id;
        $query = "INSERT INTO syn_profile (name) values ('".addslashes($args['name'])."')";
        $result = mysql_query($query,$this->connection);
        if(!$result)    
            die("Could not enter data:".mysql_error());
        if($result){
            $id = mysql_insert_id();
            $query = "INSERT INTO syn_infoValues (info_id,profile_id,value) values ((SELECT id FROM syn_infoTitle WHERE title = 'address'),".$id.",'".addslashes($args['address'])."'),((SELECT id FROM syn_infoTitle WHERE title = 'phone'),".$id.",'".addslashes($args['phone'])."')";
            $result = mysql_query($query,$this->connection);

            if(!$result)
                die("Could not enter data:".mysql_error());
            if($result){
                $query = "INSERT INTO syn_party (profile_id) values (".$id.")";
                $result = mysql_query($query,$this->connection);

                if(!$result)
                    die("Could not enter data:".mysql_error());
                else
                    return true;
                 //This part commented to remove relationship between party and 
                 //headquarter.
               /* if($result){
                    $query = "INSERT INTO syn_party_headquater (party_id,headquater_id) values (".mysql_insert_id().",".$args['headquater_id'].")"; 
                    $result = mysql_query($query,$this->connection);

                    if(!$result)
                        die("Could not enter data:".mysql_error());
                    if($result){
                        return true;
                    }
                }*/
            }

        }
        return false;
    }
    
    function editParty($args){
        $query = "UPDATE syn_profile SET syn_profile.name = '{$args['name']}' WHERE syn_profile.id = {$args['profile_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());

        $query = "UPDATE syn_infoValues SET value = '{$args['address']}' WHERE id={$args['address_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        $query = "UPDATE syn_infoValues SET value = '{$args['phone']}' WHERE id={$args['phone_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        
        $query = "UPDATE syn_party_user SET user_id = {$args['MR_id']} WHERE id = {$args['party_user_relation_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
        return false;
    }
    
    function delParty($id){

        $query = "DELETE FROM syn_profile WHERE syn_profile.id = {$id}";
        $result = mysql_query($query,$this->connection);
        $query = "DELETE FROM syn_party WHERE syn_party.profile_id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result){
          //  die("Could not delete data:".mysql_error());
          return false;
        }else
        return true;

    }
    function getHeadquaterList(){
        
        $data = array();
        $query = "SELECT syn_headquater.id,syn_profile.name FROM syn_headquater INNER JOIN syn_profile ON syn_headquater.profile_id = syn_profile.id";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getPartyById($id){
       $query="SELECT
            syn_profile.name,
            t1.value AS address,
            t2.value AS phone,
            syn_party.id as party_id,
            syn_profile.id as profile_id,
            syn_party_user.id as party_user_relation_id,
            syn_party_user.user_id,
            t1.id as address_id,
            t2.id as phone_id 
                FROM 
                syn_infoValues AS t1 ,syn_infoValues AS t2 ,syn_profile ,syn_party, syn_party_user 
                where (t1.info_id = (select id from syn_infoTitle where title = 'address') and  t2.info_id = 
                       (select id from syn_infoTitle where title = 'phone')) and t1.profile_id ={$id} and syn_profile.id = 
                t1.profile_id and syn_party.profile_id = syn_profile.id AND syn_party.id= syn_party_user.party_id group by t1.value";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_fetch_array($result);
    }

    function viewParty($sidx,$sord,$start,$limit){
        $data = array();
                $query="SELECT 
                    p1.id as profile_id,
                    p1.name as name,
                    t1.value AS address,
                    syn_party.id as party_id
                    FROM syn_infoValues AS t1 ,syn_profile as p1,syn_party
                    WHERE (t1.info_id = (select id from syn_infoTitle where title = 'address') ) and p1.id = t1.profile_id and syn_party.profile_id = p1.id 
                    group by t1.value "
                ."ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";

        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }

        $phone = array();
        foreach($data as $value){
            $query = "SELECT value as phone FROM syn_infoValues WHERE info_id = (SELECT id FROM syn_infoTitle WHERE title = 'phone') AND profile_id={$value['profile_id']}";
            $result = mysql_query($query,$this->connection);
            if(!$result)
                die("error".mysql_error());
            array_push($phone, mysql_fetch_assoc($result));
        }
        
        $party_view = array();
        $sn = 0;
        foreach($data as $value){
            $sql="SELECT syn_user.username FROM `syn_party_user`, syn_user WHERE syn_party_user.party_id= {$value['party_id']} && syn_user.id=syn_party_user.user_id ";
            $result=$this->query($sql);
            $row= mysql_fetch_row($result);
            $username=$row[0];
            $party_view[] = array("profile_id"=>$value['profile_id'],"name"=>$value['name'],"address"=>$value['address'],"phone"=>$phone[$sn++]['phone'],"username"=>$username);
        }


        return $party_view;
    }

    function getPartyCount(){

        $query = "SELECT "
                ."p1.id as profile_id,"
                ."p1.name as name,"
                ."t1.value AS address,"
                ."t2.value AS phone,"
                ."p2.name as headquater "
                ."FROM syn_infoValues AS t1 ,syn_infoValues AS t2 ,syn_profile as p1,syn_profile as p2,syn_party_headquater,syn_party,syn_headquater "
                ."WHERE (t1.info_id = (select id from syn_infoTitle where title = 'address') and t2.info_id = (select id from syn_infoTitle where title = 'phone')) and p1.id = t1.profile_id and syn_party.profile_id = p1.id AND syn_party.id = syn_party_headquater.party_id and syn_party_headquater.headquater_id = syn_headquater.id and p2.id = syn_headquater.profile_id "
                ."group by t1.value";

        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    //---------------------product-------------------
    function viewProduct($sidx,$sord,$start,$limit){

        $data = array();
        $query = "select t2.id,t2.product_id,t2.price,t2.effective_date,syn_product.name,syn_product.quantity,syn_product.no_in_case,syn_product.active,syn_unit.unit_name\n"
                ."from syn_NDPrice as t2,( SELECT t1.product_id,max(t1.effective_date) as max_date FROM syn_NDPrice as t1 GROUP BY t1.product_id) as t3, syn_product,syn_unit\n"
                ."where t2.product_id = t3.product_id and t2.effective_date = t3.max_date and syn_product.id = t2.product_id and syn_product.unit_id = syn_unit.id "
                ."ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";
        $result = mysql_query($query,$this->connection);
        
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;

    }

    function addProduct($args){
        $active = "";
        if($args['active'] == 'y')
            $active = 1;
        else
            $active= 0;

        $query = "INSERT INTO syn_product (name,quantity,unit_id,no_in_case,active) values ('".$args['name']."','".$args['quantity']."',".$args['unit_id'].",'".$args['no_in_case']."',".$active.")";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result){
           $query = "INSERT INTO syn_NDPrice (product_id,price,effective_date) values (".mysql_insert_id().",'".$args['price']."','".$args['effective_date']."')";
            $result = mysql_query($query,$this->connection);
            if(!$result)
                die("Could not enter data:".mysql_error());
            if($result)
                return true;
        }
        return false;   
    }
    
    function editProduct($args){
        $active = "";
        if($args['active'] == 'y')
            $active = 1;
        else
            $active= 0;

        $query = "UPDATE syn_product SET name = '{$args['name']}', quantity = '{$args['quantity']}', unit_id = {$args['unit_id']}, no_in_case = '{$args['no_in_case']}', active = {$active} WHERE id = {$args['product_id']}";  
        //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not query 1 :".mysql_error());

        $query = "SELECT effective_date FROM syn_NDPrice WHERE id = {$args['id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not query 2:".mysql_error());

        $date =  mysql_fetch_array($result);
        //echo $date['effective_date'];
        if($date['effective_date'] == $args['effective_date']){
            $query = "UPDATE syn_NDPrice SET price = '{$args['price']}' WHERE id = {$args['id']}";  
        }
        else{
            $query = "INSERT INTO syn_NDPrice (product_id,price,effective_date) values ({$args['product_id']},'{$args['price']}','{$args['effective_date']}')";
        }

        $result = mysql_query($query,$this->connection)  or  die("Could not query 3:".mysql_error());
        if(!$result)
            return false;
            return true;
    }

    function delProduct($id){
        
        $query = "DELETE FROM syn_product WHERE syn_product.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;

    }

    function getUnit(){
        $data = array();
        $query = "SELECT id,unit_name FROM syn_unit";

        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getProductById($id){
        $data = array();
        $query = "select t2.id,t2.product_id,t2.price,t2.effective_date,syn_product.name,syn_product.quantity,syn_product.no_in_case,syn_product.active,syn_product.unit_id\n"
                ."from syn_NDPrice as t2,( SELECT t1.product_id,max(t1.effective_date) as max_date FROM syn_NDPrice as t1 GROUP BY t1.product_id) as t3, syn_product\n"
                . "where t2.product_id = t3.product_id and t2.effective_date = t3.max_date and t2.product_id =".$id." and syn_product.id = t2.product_id";

        $result = mysql_query($query,$this->connection);
        
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }

    function getProductCount(){


        $query = "select t2.id,t2.product_id,t2.price,t2.effective_date,syn_product.name,syn_product.quantity,syn_product.no_in_case,syn_product.active,syn_unit.unit_name\n"
                ."from syn_NDPrice as t2,( SELECT t1.product_id,max(t1.effective_date) as max_date FROM syn_NDPrice as t1 GROUP BY t1.product_id) as t3, syn_product,syn_unit\n"
                . "where t2.product_id = t3.product_id and t2.effective_date = t3.max_date and syn_product.id = t2.product_id and syn_product.unit_id = syn_unit.id";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    //--------------------------tada-----------------------------

    function addTada($args){
        
        global $user;
        $userid= $user->userid;
        $query = "INSERT INTO syn_TADA (visited_date,visit_place,distance,da,other,remark,user_id,created_date) values ('".$args['visited_date']."','".addslashes($args['visit_place'])."','".$args['distance']."','".$args['da']."','".$args['other']."','".addslashes($args['remark'])."','".$userid."',NOW())";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editTada($args){
        
        $query = "UPDATE syn_TADA SET visited_date  = '{$args['visited_date']}', visit_place = '".addslashes($args['visit_place'])."', distance = '{$args['distance']}', da = '{$args['da']}', other = '{$args['other']}',remark ='".addslashes($args['remark'])."' WHERE id = {$args['id']}";  
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function delTada($id){
        
        $query = "DELETE FROM syn_TADA WHERE syn_TADA.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;

    }

    function viewTada($sidx,$sord,$start,$limit,$llimit,$ulimit){
        global $user;
        $data = array();
        $userid = $_SESSION['uid'];//$user->userid;
        //unset($_SESSION['uid']);
        //$datelimit = $this->getLimit($interval);
       // $userid = 7;
        $query = "SELECT syn_TADA.id,syn_TADA.visited_date,syn_TADA.visit_place,syn_TADA.distance,syn_TADA.da,syn_TADA.other,syn_TADA.remark,syn_TADA.created_date FROM syn_TADA WHERE syn_TADA.user_id ={$userid} AND syn_TADA.visited_date BETWEEN '{$llimit}' AND '{$ulimit}' ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";
		//echo $query;
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }   

    function getTadaCount($llimit,$ulimit){

        //$datelimit = $this->getLimit($interval);
        $userid = $_SESSION['uid'];
        $query = "SELECT syn_TADA.id,syn_TADA.visited_date,syn_TADA.created_date,syn_TADA.visit_place,syn_TADA.distance,syn_TADA.da,syn_TADA.other,syn_TADA.remark from syn_TADA where syn_TADA.user_id = {$userid} AND syn_TADA.visited_date BETWEEN '{$llimit}' AND '{$ulimit}'";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);
    }

    function getTadaById($id){

        $data = array();
        $query = "SELECT syn_TADA.id,syn_TADA.visited_date,syn_TADA.visit_place,syn_TADA.distance,syn_TADA.da,syn_TADA.other,syn_TADA.remark,syn_TADA.created_date from syn_TADA where syn_TADA.id = ".$id;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }


    function managerViewTada($sidx,$sord,$start,$limit,$userid,$llimit,$ulimit){
        //$userid = 3;
        $data = array();
        //$datelimit = $this->getLimit($interval);
        $query = "SELECT id,visited_date,visit_place,distance,da,other,remark FROM syn_TADA where user_id = {$userid} AND syn_TADA.visited_date BETWEEN '{$llimit}' AND '{$ulimit}' ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";
              
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
              
        $retData = array();
        foreach($data as $key){
            
            $query = "SELECT amount FROM syn_TASetting WHERE effective_date = (SELECT Max(effective_date) FROM syn_TASetting WHERE DATEDIFF(effective_date,'".$key['visited_date']."') < 0 AND user_id = {$userid}) AND user_id = {$userid}"; 
            $result = mysql_query($query,$this->connection);
            if(!$result)
               echo  die("Could not enter data:".mysql_error());
            $rate = mysql_fetch_row($result);			
            $retData[] = array('id'=>$key['id'],'visited_date'=>$key['visited_date'],'visit_place'=>$key['visit_place'],'distance'=>$key['distance'],'rate'=>$rate[0],'da'=>$key['da'],'other'=>$key['other'],'remark'=>$key['remark']);
            
        }
             
        //print_r($retData);
        //die();

        return $retData;


    }

    function getMViewTadaCount($userid,$llimit,$ulimit){

        //$userid = 3;
        //$datelimit = $this->getLimit($interval);
        $query = "SELECT id,visited_date,created_date,visit_place,distance,da,other,remark FROM syn_TADA where user_id = {$userid} AND syn_TADA.visited_date BETWEEN '{$llimit}' AND '{$ulimit}'";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }
    //---------------------------dcr--------------------

    function getTitle(){

        $data = array();
        $query = "SELECT id,title FROM syn_customerTitle";

        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    
    function addDcr($args){

        global $user;
        $userid=$user->userid;
        $query = "INSERT INTO syn_DCR (collected_date,name,customer_title_id,remark,user_id,created_date) values ('".$args['collected_date']."','".addslashes($args['name'])."',".$args['customer_title_id'].",'".addslashes($args['remark'])."','".$userid."',CURDATE())";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editDcr($args){
        //print_r($args);        
        $query = "UPDATE syn_DCR SET collected_date  = '{$args['collected_date']}', name= '".addslashes($args['name'])."', customer_title_id = '{$args['customer_title_id']}', remark = '".addslashes($args['remark'])."' WHERE id = {$args['id']}";  
        //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }
    
    function delDcr($id){
                
        $query = "DELETE FROM syn_DCR WHERE syn_DCR.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;

    }

    function getDcrById($id){

        $data = array();
        $query = "SELECT syn_DCR.collected_date,syn_DCR.name,syn_DCR.customer_title_id,syn_DCR.remark FROM syn_DCR where syn_DCR.id = ".$id;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }

    function viewDcr($sidx,$sord,$start,$limit,$llimit,$ulimit,$user='s'){
        $data = array();
		 $userid;
        if($user == 's'){
         
            $userid = $_SESSION['userid'];
            //unset($_SESSION['userid']);
        }else{
            $userid = $user;
        }
		//echo $userid;
        //$datelimit = $this->getLimit($interval);
        $query = "SELECT syn_customerTitle.title,syn_DCR.name,syn_DCR.collected_date,syn_DCR.id,syn_DCR.remark \n"
               . "FROM syn_DCR \n"
               . "Inner Join syn_customerTitle ON syn_DCR.customer_title_id = syn_customerTitle.id \n"
               . "where syn_DCR.customer_title_id = syn_customerTitle.id AND syn_DCR.user_id = {$userid} AND syn_DCR.collected_date BETWEEN '{$llimit}' AND '{$ulimit}' ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";
			  //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }   

    function getViewDcrCount($llimit,$ulimit,$user='s'){
                  
         $userid;
        if($user == 's'){
         
            $userid = $_SESSION['userid'];
            //unset($_SESSION['userid']);
        }else{
            $userid = $user;
        }

        $query = "SELECT syn_customerTitle.title,syn_DCR.name,syn_DCR.collected_date,syn_DCR.id,syn_DCR.remark \n"
               . "FROM syn_DCR \n"
               . "Inner Join syn_customerTitle ON syn_DCR.customer_title_id = syn_customerTitle.id \n"
               . "where syn_DCR.customer_title_id = syn_customerTitle.id AND syn_DCR.user_id = {$userid} AND syn_DCR.collected_date BETWEEN '{$llimit}' AND '{$ulimit}'";
               //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }
//---------------party stock------------------

    function getParty(){
        $data = array();

        $query = "SELECT syn_profile.name,syn_party.id FROM syn_profile INNER JOIN syn_party ON syn_profile.id = syn_party.profile_id ORDER BY syn_profile.name";
        
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    function getMyParty(){
        $data = array();
        global $user;
$query="SELECT
syn_profile.`name`,
syn_party.id
FROM
syn_profile
Inner Join syn_party ON syn_profile.id = syn_party.profile_id
Inner Join syn_party_user ON syn_party_user.party_id = syn_party.id
where syn_party_user.user_id={$user->userid}
ORDER BY syn_profile.name";

        
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getProduct(){
        
        $data = array();

        $query = "SELECT syn_product.id,syn_product.name,syn_product.quantity,syn_unit.unit_name FROM syn_product INNER JOIN syn_unit ON syn_product.unit_id = syn_unit.id WHERE syn_product.active = 1 ORDER BY syn_product.name";
        
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function addPartyStock($args){
        //$userid = 3;
        global $user;
        //$zero = 0;
        $userid = $user->userid;
        $query = "INSERT INTO syn_partyStock (collected_date,party_id,product_id,no_of_case,indivisual,user_id,created_date) values ";
        for($i=1;$i<=$args['count'];$i++){
            if($args['no_of_case'.$i] != null || $args['indv'.$i] != null){

                $no_of_case = 0;
                $indv = 0;

                if($args['no_of_case'.$i] != null)
                    $no_of_case = $args['no_of_case'.$i];
                if($args['indv'.$i] != null)
                    $indv = $args['indv'.$i];

                if($i<2)
                    $query .= "('{$args['collected_date']}',{$args['party_id']},".$args['pid'.$i].",".$no_of_case.",".$indv.",{$userid},NOW())";
                else
                    $query .= ",('{$args['collected_date']}',{$args['party_id']},{$args['pid'.$i]},".$no_of_case.",".$indv.",{$userid},NOW())";
            }
        }
        //echo $query;
        //die();
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editPartyStock($args){
        $userid = 3;
        $query = "UPDATE syn_partyStock  SET collected_date  = '{$args['collected_date']}', party_id = {$args['party_id']}, product_id = {$args['product_id']}, no_of_case = {$args['no_of_case']}, indivisual = {$args['indivisual']} WHERE id = {$args['id']}";  
        //$query = "INSERT INTO syn_partyStock (collected_date,party_id,product_id,no_of_case,user_id,created_date) values ('{$args['collected_date']}',{$args['party_id']},{$args['product_id']},{$args['no_of_case']},{$userid},CURDATE())";
        //echo($query);
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function delPartyStock($id){
                
        $query = "DELETE FROM syn_partyStock WHERE syn_partyStock.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;

    }

    function getPartyStockById($id){

        $query = "SELECT\n"
             . "syn_partyStock.collected_date,\n"
             . "syn_partyStock.party_id,\n"
             . "syn_partyStock.product_id,\n"
             . "syn_partyStock.no_of_case,\n"
             . "syn_partyStock.indivisual,\n"
             . "syn_partyStock.created_date\n"
             . "FROM\n"
             . "syn_partyStock\n"
             . "WHERE syn_partyStock.id = ".$id;

        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);

    }

    function viewPartyStock($sidx,$sord,$start,$limit,$llimit,$ulimit){
        //$userid = 3; 
//        $userid = $_SESSION['userid'];
        //$query = "SELECT ADDDATE( SUBDATE( ADDDATE( CURDATE( ) , INTERVAL ".($interval-1)." MONTH ) , INTERVAL DAYOFMONTH( CURDATE( ) ) DAY ) , 1) AS FIRST_DAY_MONTH, SUBDATE( ADDDATE( CURDATE(), INTERVAL {$interval} MONTH), INTERVAL DAYOFMONTH( CURDATE() ) DAY) AS LAST_DAY_MONTH";
        //$result = mysql_query($query,$this->connection);
        //if(!$result)
            //die("Could not enter data:".mysql_error());
        //$date = mysql_fetch_array($result);
        //unset($_SESSION['userid']); 
        
		$data = array();
        $query = "SELECT syn_partyStock.id,syn_partyStock.collected_date,syn_partyStock.no_of_case,syn_partyStock.indivisual,syn_partyStock.created_date,syn_product.name,syn_product.quantity,syn_unit.unit_name,syn_profile.name as party_name "
                ."FROM syn_partyStock "
                ."Inner Join syn_product ON syn_product.id = syn_partyStock.product_id "
                ."Inner Join syn_unit ON syn_unit.id = syn_product.unit_id "
                ."Inner Join syn_party ON syn_partyStock.party_id = syn_party.id "
                ."Inner Join syn_profile ON syn_profile.id = syn_party.profile_id "
                ."where syn_partyStock.user_id = {$userid} AND syn_partyStock.collected_date BETWEEN '{$llimit}' AND '{$ulimit}' "
                ."ORDER BY syn_profile.name ASC,{$sidx} {$sord} LIMIT  {$start} , {$limit}";
				
              //echo $query;
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getViewPartyStockCount($llimit,$ulimit){
        //$userid = 3;
        $userid = $_SESSION['userid'];
	//$query = "SELECT ADDDATE( SUBDATE( ADDDATE( CURDATE( ) , INTERVAL ".($interval-1)." MONTH ) , INTERVAL DAYOFMONTH( CURDATE( ) ) DAY ) , 1) AS FIRST_DAY_MONTH, SUBDATE( ADDDATE( CURDATE(), INTERVAL {$interval} MONTH), INTERVAL DAYOFMONTH( CURDATE() ) DAY) AS LAST_DAY_MONTH";
        //$result = mysql_query($query,$this->connection);
        //if(!$result)
            //die("Could not enter data:".mysql_error());
        //$date = mysql_fetch_array($result);
        //unset($_SESSION['userid']); 
        
		$data = array();
        $query = "SELECT syn_partyStock.id,syn_partyStock.collected_date,syn_partyStock.no_of_case,syn_partyStock.created_date,syn_product.name,syn_product.quantity,syn_unit.unit_name,syn_profile.name as party_name "
                ."FROM syn_partyStock "
                ."Inner Join syn_product ON syn_product.id = syn_partyStock.product_id "
                ."Inner Join syn_unit ON syn_unit.id = syn_product.unit_id "
                ."Inner Join syn_party ON syn_partyStock.party_id = syn_party.id "
                ."Inner Join syn_profile ON syn_profile.id = syn_party.profile_id "
                ."where syn_partyStock.user_id = {$userid} AND syn_partyStock.collected_date BETWEEN '{$llimit}' AND '{$ulimit}' "
                ."ORDER BY syn_profile.name";
        
	$result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    function mViewPartyStock($sidx,$sord,$start,$limit,$party_id,$llimit,$ulimit){

        //$interval = 0;
        //$party_id = 1;
        $data = array();
        //$query = "SELECT ADDDATE( SUBDATE( ADDDATE( CURDATE( ) , INTERVAL ".($interval-1)." MONTH ) , INTERVAL DAYOFMONTH( CURDATE( ) ) DAY ) , 1) AS FIRST_DAY_MONTH, SUBDATE( ADDDATE( CURDATE(), INTERVAL {$interval} MONTH), INTERVAL DAYOFMONTH( CURDATE() ) DAY) AS LAST_DAY_MONTH";
        //$result = mysql_query($query,$this->connection);
        //if(!$result)
            //die("Could not enter data:".mysql_error());
        //$date = mysql_fetch_array($result);
        //echo $date['FIRST_DAY_MONTH']."\n";
        //echo $date['LAST_DAY_MONTH']."\n";
        
        $query = "SELECT syn_partyStock.collected_date,syn_product.id,syn_product.name,syn_product.quantity,syn_unit.unit_name,syn_product.no_in_case,syn_partyStock.no_of_case,syn_partyStock.indivisual,syn_user.username "
                ."FROM syn_partyStock "
                ."Inner Join syn_product ON syn_product.id = syn_partyStock.product_id "
                ."Inner Join syn_unit ON syn_unit.id = syn_product.unit_id "
                ."Inner Join syn_user ON syn_partyStock.user_id = syn_user.id "
                ."WHERE syn_partyStock.collected_date BETWEEN '{$llimit}' AND '{$ulimit}' AND syn_partyStock.party_id = {$party_id}";

        $result = mysql_query($query,$this->connection);

        if(!$result)
            die("Could not enter data:".mysql_error());
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }

        //print_r($data);
            
        $retData = array();
        foreach($data as $key){
            
            $query = "SELECT price\n "
                . "FROM syn_NDPrice\n "
                . "WHERE effective_date = (\n"
                . "SELECT Max( effective_date ) FROM syn_NDPrice WHERE DATEDIFF( effective_date, '{$key['collected_date']}')<0 AND product_id = {$key['id']} ) ";
            //echo $query;
            $result = mysql_query($query,$this->connection);
            if(!$result)
	        echo  die("Could not enter data:".mysql_error());
	    $rate = mysql_fetch_row($result);			
	    $retData[] = array('collected_date'=>$key['collected_date'],'name'=>$key['name'],'quantity'=>$key['quantity'],'unit_name'=>$key['unit_name'],'no_in_case'=>$key['no_in_case'],'no_of_case'=>$key['no_of_case'],'indivisual'=>$key['indivisual'],'username'=>$key['username'],'price'=>$rate[0]);
        }
        return $retData;
    }

    function getmViewPartyStockCount($party_id,$llimit,$ulimit){
        $userid = 3;
        //$party_id = 1;
        //$interval = 0;

        $data = array();
        //$query = "SELECT ADDDATE( SUBDATE( ADDDATE( CURDATE( ) , INTERVAL ".($interval-1)." MONTH ) , INTERVAL DAYOFMONTH( CURDATE( ) ) DAY ) , 1) AS FIRST_DAY_MONTH, SUBDATE( ADDDATE( CURDATE(), INTERVAL {$interval} MONTH), INTERVAL DAYOFMONTH( CURDATE() ) DAY) AS LAST_DAY_MONTH";
        //$result = mysql_query($query,$this->connection);
        //if(!$result)
            //die("Could not enter data:".mysql_error());
        //$date = mysql_fetch_array($result);
        //echo $date['FIRST_DAY_MONTH']."\n";
        //echo $date['LAST_DAY_MONTH']."\n";
        
        $query = "SELECT syn_partyStock.collected_date,syn_product.id,syn_product.name,syn_product.quantity,syn_unit.unit_name,syn_product.no_in_case,syn_partyStock.no_of_case,syn_user.username "
                ."FROM syn_partyStock "
                ."Inner Join syn_product ON syn_product.id = syn_partyStock.product_id "
                ."Inner Join syn_unit ON syn_unit.id = syn_product.unit_id "
                ."Inner Join syn_user ON syn_partyStock.user_id = syn_user.id "
                ."WHERE syn_partyStock.collected_date BETWEEN '{$llimit}' AND '{$ulimit}' AND syn_partyStock.party_id = {$party_id}";

        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }
    function insertInfoValues($profileId, $array,$fieldName){
        if(is_array($array)){

        }
        else{
                $sql = "INSERT INTO `syn_infoValues` (`info_id`, `profile_id`, `value`) VALUES ((select `id` from syn_infoTitle where title='{$fieldName}'), '{$profileId}', '$array')";
        }

    }
    function getUserListInHeadquater($id){
        
        $data = array();
        $query = "select syn_user.id,syn_user.username from syn_user,syn_user_headquater,syn_headquater where syn_user.id = syn_user_headquater.user_id and syn_headquater.id = syn_user_headquater.headquater_id and syn_headquater.id ={$id}";        
        //$query = "SELECT syn_headquater.id,syn_profile.name FROM syn_headquater INNER JOIN syn_profile ON syn_headquater.profile_id = syn_profile.id";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = array($row['id']=>$row['username']);
        }
        return $data;
    }
    function getPartyListInHeadquater($id){
        
        $data = array();
        $query = "SELECT syn_party.id,syn_profile.name from syn_party,syn_profile,syn_party_headquater,syn_headquater where syn_party.profile_id = syn_profile.id and syn_party.id = syn_party_headquater.party_id and syn_headquater.id = syn_party_headquater.headquater_id and syn_headquater.id = {$id} ";
        //$query = "select syn_party.id,syn_.name from syn_,syn_user_headquater,syn_headquater where syn_.id = syn_user_headquater.and syn_headquater.id = syn_user_headquater.headquater_id and syn_headquater.id ={$id}";        
        //$query = "SELECT syn_headquater.id,syn_profile.name FROM syn_headquater INNER JOIN syn_profile ON syn_headquater.profile_id = syn_profile.id";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = array($row['id']=>$row['name']);
        }
        return $data;
    }
    //------------------------materials--------------
    //
    function addMaterial($args){
        $query = "INSERT INTO syn_material (name,unit) values ('{$args['name']}','{$args['unit']}')";
        //echo($query);
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editMaterial($args){
        $query = "UPDATE syn_material  SET name = '{$args['name']}', unit = '{$args['unit']}' WHERE id = {$args['id']}";  
        //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function delMaterial($id){
        
        $query = "DELETE FROM syn_material WHERE syn_material.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;
    }

    function getMaterialById($id){

        $data = array();
        $query = "SELECT syn_material.name,syn_material.unit FROM syn_material where syn_material.id = ".$id;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }

    function viewMaterial($sidx,$sord,$start,$limit){
        $data = array();
        $query = "SELECT syn_material.id,syn_material.name,syn_material.unit FROM syn_material "
                ."ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";

        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getViewMaterialCount(){
        $query = "SELECT syn_material.id,syn_material.name,syn_material.unit FROM syn_material";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    //-----------Stock----------------
    function getMaterial(){

        $data = array();
        $query = "SELECT syn_material.id,syn_material.name,syn_material.unit FROM syn_material ORDER BY syn_material.name";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    function addStock($args){

        $qty = $args['action']*$args['qty'];

        $query = "SELECT SUM(syn_stock.qty) as qty FROM syn_stock WHERE syn_stock.material_id = {$args['material_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("could not enter data:".mysql_error());
        
        $row = mysql_fetch_assoc($result);

        if($args['action'] < 0 && $args['qty'] > $row['qty']){
            return "<div class='notice'>Error : Stock is not sufficient to deduct from total amount ".$row['qty']." unit</div>";
        }     

        $query = "INSERT INTO syn_stock (material_id,ri_date,qty,created_date) values ({$args['material_id']},'{$args['ri_date']}',{$qty},NOW())";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editStock($args){

        $qty = $args['action']*$args['qty'];

        $query = "SELECT SUM(syn_stock.qty) as qty FROM syn_stock WHERE syn_stock.material_id = {$args['material_id']}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("could not enter data:".mysql_error());
        
        $row = mysql_fetch_assoc($result);

        if($args['action'] < 0 && $args['qty'] > $row['qty']){
            return "<div class='notice'>Error : Stock is not sufficient to deduct from total amount ".$row['qty']." unit</div>";
        }     
        $query = "UPDATE syn_stock SET material_id={$args['material_id']}, ri_date = '{$args['ri_date']}', qty = {$qty} WHERE id = {$args['id']}";  
        //echo($query);
        //die();
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function delStock($id){
        
        $query = "DELETE FROM syn_stock WHERE syn_stock.id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;
    }

    function viewStock($sidx,$sord,$start,$limit){
        $data = array();
        $query = "SELECT syn_material.id,syn_material.name,syn_material.unit,sum(syn_stock.qty) as qty\n "
               . "FROM syn_stock\n "
               . "Inner Join syn_material ON syn_stock.material_id = syn_material.id\n "
               . "group by syn_material.id "
               . "ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";

        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function getViewStockCount(){
        $query = "SELECT syn_material.id,syn_material.name,syn_material.unit,sum(syn_stock.qty) as qty\n "
               . "FROM syn_stock\n "
               . "Inner Join syn_material ON syn_stock.material_id = syn_material.id\n "
               . "group by syn_material.id ";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    function viewStockDetail($sidx,$sord,$start,$limit,$stock_id){
        //$stock_id = 1;
        $data = array();

              // . "ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";
        $query = "SELECT syn_stock.id,syn_stock.ri_date,syn_stock.qty,syn_stock.created_date\n "
               . "FROM syn_stock\n "
               . "WHERE syn_stock.material_id = '{$stock_id}'"
               . "ORDER BY syn_stock.ri_date DESC LIMIT {$start} , {$limit}";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }

        $retdata = array();

        foreach($data as $key){
            $receive_qty = "";
            $issue_qty = "";

            if($key['qty']>0)
                $receive_qty = $key['qty'];
            else
                $issue_qty = abs($key['qty']);

            $retdata[] = array('id'=>$key['id'],'ri_date'=>$key['ri_date'],'receive_qty'=>$receive_qty,'issue_qty'=>$issue_qty,'created_date'=>$key['created_date']);
        }
        return $retdata;
    }

    function getViewStockDetailCount($stock_id){
        //$stock_id = 1;

        $query = "SELECT syn_stock.id,syn_stock.ri_date,syn_stock.qty\n "
               . "FROM syn_stock\n "
               . "WHERE syn_stock.material_id = '{$stock_id}'";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }

    function viewStockTest(){
        $stock_id = 1;

        $query = "SELECT syn_stock.id,syn_stock.ri_date,syn_stock.qty\n "
               . "FROM syn_stock\n "
               . "WHERE syn_stock.material_id = '{$stock_id}'";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        //return $data;
        
        $retdata = array();

        foreach($data as $key){
            $receive_qty = "";
            $issue_qty = "";

            if($key['qty']>0)
                $receive_qty = $key['qty'];
            else
                $issue_qty = abs($key['qty']);

            $retdata[] = array('id'=>$key['id'],'ri_date'=>$key['ri_date'],'receive_qty'=>$receive_qty,'issue_qty'=>$issue_qty);
        }
        return $retdata;

    }
    
    function getStockById($id){

        $data = array();
        $query = "SELECT syn_stock.material_id,syn_stock.ri_date,syn_stock.qty,syn_stock.created_date FROM syn_stock where syn_stock.id = ".$id;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);

    }

    function getUserLevels(){
    $q= "SELECT name,access_value from syn_access";
     $res=$this->query($q);
    $data=array();
    while($r= mysql_fetch_assoc($res)){
        $data[]=$r;        
    }
    return $data;
    }
    function getHeadquarterList(){
       $q="SELECT syn_profile.name,syn_headquater.id FROM syn_profile Inner Join syn_headquater ON syn_profile.id = syn_headquater.profile_id";
 
     $res=$this->query($q);
    $data=array();
    while($r= mysql_fetch_assoc($res)){
        $data[]=$r;        
    }
    return $data;
    }

    function updateUserValues($args){

        global $user;
        //if($args['manager_name'] != 0){
            $q="update syn_user set access_value='{$args['level']}', manager_id='{$args['manager_name']}' where id='{$args['id']}'";
            $this->query($q);
        //}
		/**
		 *  @desc select headquater feature disabled 
		 */ 
        /*$q="SELECT * FROM `syn_user_headquater` WHERE `user_id`={$args['id']}";
        //echo $q;
        $res=$this->query($q);
        if(mysql_numrows($res)>0){
            $q="update syn_user_headquater set  headquater_id={$args[headquater_name]} where user_id='{$args[id]}'";
            if(!$this->query($q))
                return false;
        }
        else{
            $q="insert into syn_user_headquater (headquater_id,user_id) values({$args['headquater_name']},{$args['id']})";
            if(!$this->query($q))
                return false;
        }*/
        if(isset($args['passwd']) && strlen($args['passwd'] = trim($args['passwd'])) != 0){
            if($this->updateUserField($args['id'],"password",md5($args['passwd'])))
                return true;
            else
                return false;
        }
        else{
            return true;

        }
    }

   
    function getLimit($interval)
    {
        $curYear = date("Y");
        $curMonth = date("m");
        $curDay = date("d");
        if($curDay >= 16){
            if(($curMonth-$interval/2) > 0)
                $month = ceil($curMonth - $interval/2);
            else
                $month = ceil(13 +($curMonth - $interval/2)%13);
            $year = $curYear-floor((($interval/2-$curMonth)/13)+1); 
            if($interval%2 == 0){
                $day = "15";
                $lday = "31";
            }else{
                $day = "01";
                $lday= "15";
            }

        } else {

            if($interval == 0){
                $year = $curYear;
                $month = $curMonth;

            }else {

                if(($curMonth-ceil($interval/2)) > 0)
                    $month = ceil($curMonth - ceil($interval/2));
                else
                    $month = ceil(13 +($curMonth - ceil($interval/2))%13);

                $year = $curYear-floor(((ceil($interval/2)-$curMonth)/13)+1); 
            }           

            if($interval%2 == 0){
                $day = "01";
                $lday = "15";
            }
            else{
                $day = "15";
                $lday = "31";
            }
        }       

        $limit = array('lower'=>$year."-".$month."-".$day,'upper'=>$year."-".$month."-".$lday);
        return $limit;
    }
 
// news section
    function addNews($args){
        global $user;
        $userid= $user->userid;
        $query="INSERT INTO `syn_news` (`title` , `body` , `date` , `userid`) VALUES ('".addslashes($args['title'])."','".addslashes($args['body'])."', '{$args[entered_date]}', '$userid')";
 
        //$query = "INSERT INTO syn_TADA (visited_date,visit_place,distance,da,other,remark,user_id,created_date) values ('".$args['visited_date']."','".addslashes($args['visit_place'])."','".$args['distance']."','".$args['da']."','".$args['other']."','".addslashes($args['remark'])."','".$userid."',NOW())";
        $result = mysql_query($query,$this->connection);
        if(!$result){
            die("Could not enter data:".mysql_error());
            return false;
        }
        if($result)
            return true;
    }
    function getNews(){
        $query = "SELECT `title` ,`body`, date_format(`date`,'%b_%d') as date from syn_news order by date desc limit 4";
        $result=mysql_query($query,$this->connection) or die('couldnot run query get news');
        $data=array();
        while($r= mysql_fetch_assoc($result)){
            $data[]=$r;        
        }
        return $data;

    }
    function getNewsCount(){
        $query="SELECT count(id) as count FROM syn_news";
        $res=$this->query($query);
        $ret=mysql_fetch_array($res);
        return $ret['count'];
    }
    function viewNewsItem($sidx,$sord,$start,$limit){

        $data = array();
        $query = "SELECT `id`,`title`,`date`,`body` FROM `syn_news` "
                ."ORDER BY {$sidx} {$sord} LIMIT  {$start} , {$limit}";

        //echo($query);
        //die();
        $result = mysql_query($query,$this->connection);
        
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;

    }
    function delNews($id){
        $query = "DELETE FROM syn_news WHERE id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;
    }
    function getNewsByID($id){
        $query ="SELECT `title`,`body`,`date` FROM `syn_news` WHERE id=$id";
        $res=$this->query($query);
        if($res){
            return mysql_fetch_array($res);
        }
    }
    function editNews($args){
        $id=$_GET['id'];
        $query="update syn_news set date='".$args['entered_date']."',body='".addslashes($args['body'])."', title='".addslashes($args['title'])."' where id=$id";
        //echo $query;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;

    }

    //----------------product details------------
    function viewProductDetails($sidx,$sord,$start,$limit){
        $data = array();

        $query = "SELECT syn_productDetails.product_id,description,`order`,syn_product.name,syn_productDetails.active FROM syn_productDetails,syn_product WHERE syn_productDetails.product_id = syn_product.id ORDER BY syn_product.name {$sord} LIMIT {$start} , {$limit}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    function getProductName($id){

        $query = "SELECT syn_product.name FROM syn_product where syn_product.id = ".$id;
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }

    function addProductDetails($args){

        $active = "";
        if($args['active'] == 'y')
            $active = 1;
        else
            $active= 0;
        $query = "INSERT INTO syn_productDetails (product_id,description,image,active,`order`) values ({$args['product_id']},'{$args['description']}','{$args['path']}',{$active},{$args['order']})";
        //echo($query);
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }

    function editProductDetails($args){

        $active = "";
        if($args['active'] == 'y')
            $active = 1;
        else
            $active= 0;
        if($args['path']!= ""){
            $query = "UPDATE syn_productDetails SET description = '{$args['description']}', active = {$active}, image='{$args['path']}', `order` = {$args['order']} WHERE product_id = {$args['product_id']}";  
        }else{

            $query = "UPDATE syn_productDetails SET description = '{$args['description']}', active = {$active}, `order` = {$args['order']} WHERE product_id = {$args['product_id']}";  
        }
        //echo($query);
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        if($result)
            return true;
    }
    function delProductDetails($id){
        
        $query = "DELETE FROM syn_productDetails WHERE syn_productDetails.product_id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not delete data:".mysql_error());
        return true;
    }
    function getViewProductDetailCount(){
        $query = "SELECT count(*) FROM syn_productDetails";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("error".mysql_error());
        return mysql_num_rows($result);

    }
    function getProductDetailsById($id){
        $query = "SELECT product_id,description,active,`order` FROM syn_productDetails WHERE product_id = {$id}";
        $result = mysql_query($query,$this->connection);
        if(!$result)
            die("Could not enter data:".mysql_error());
        return mysql_fetch_array($result);
    }
    
    function checkDuplicateEntry($tblName,$fldName,$value){
    	$query = "SELECT {$fldName} FROM {$tblName} WHERE {$fldName} = '{$value}'";
    	$result = mysql_query($query,$this->connection);    	
    	if(mysql_num_rows($result) >0)
    		return true;
    	return false;
    }

    function getMRList(){
        $data = array();
        $query = "SELECT id,username FROM syn_user where access_value <= 4";
        $result = mysql_query($query,$this->connection);
        while($row = mysql_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
}


/* Create database connection */
$database = new MySQLDB;

?>
