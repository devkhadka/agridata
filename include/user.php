<?
/**
 * User.php
 * 
 * The User class is meant to simplify the task of keeping
 * track of logged in users and also guests.
 *
 */
include("database.php");
include("mailer.php");
include("form.php");

class User
{
   var $username;     //Username given on sign-up
   var $userid;    //user id
   var $userprofileid;  //profileid
   var $level;    //The level to which the user pertains
   var $time;         //Time user was last active (page loaded)
   var $logged_in;    //True if user is logged in, false otherwise
   var $userinfo = array();  //The array holding all user info
   var $real_username;
   var $real_level;
   var $real_userid;
   /**
    * Note: referrer should really only be considered the actual
    * page referrer in process.php, any other time it may be
    * inaccurate.
    */

   /* Class constructor */
   function User(){
      $this->time = time();
      $this->startSession();
   }

   /**
    * startSession - Performs all the actions necessary to 
    * initialize this session object. Tries to determine if the
    * the user has logged in already, and sets the variables 
    * accordingly. Also takes advantage of this page load to
    * update the active visitors tables.
    */
   function startSession(){
      session_start();   //Tell PHP to start the session


      $this->logged_in = $this->checkLogin();
      /**
       * Set guest value to users not logged in, and update
       * active guests table accordingly.
       */
      if(!$this->logged_in){
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->level = GUEST_LEVEL;
      }
      /* Update users last active timestamp */
      
      
   }

   /**
    * checkLogin - Checks if the user has already previously
    * logged in, and a session with the user has already been
    * established. Also checks to see if user has been remembered.
    * If so, the database is queried to make sure of the user's 
    * authenticity. Returns true if the user has logged in.
    */
   function checkLogin(){
      global $database;  //The database connection
      /* Check if user has been remembered */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
      }
     /* Username and userid have been set and not guest */
      if(isset($_SESSION['username']) && $_SESSION['username'] != GUEST_NAME){
      /* Username and password correct, register session variables */
          $this->userinfo  = $database->getUserInfo($_SESSION['username']);
          $this->username  = $_SESSION['username'] = $this->userinfo['username'];
          $this->userid =  $_SESSION['userid'] = $this->userinfo['id'];
          $this->userprofileid = $this->userinfo['profile_id'];
          $this->level = $this->userinfo['access_value'];
          if(isset ($_SESSION['real_user_level']) && $_SESSION['real_user_level'] == ADMIN_LEVEL){
              $this->real_level=$_SESSION['real_user_level'];
              $this->real_username = $_SESSION['real_username'];
              $this->real_userid = $_SESSION['real_userid'];

          }
          

          $this->logged_in=true;
            return true;
         }
      /* User not logged in */
      else{
         return false;
      }
   }

   /**
    * login - The user has submitted his username and password
    * through the login form, this function checks the authenticity
    * of that information in the database and creates the session.
    * Effectively logging in the user if all goes well.
    */
   function login($subuser, $subpass){
      global $database, $form,$reg;  //The database and form object

      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered");
      }
      else{
         /* Check if username is not alphanumeric */
			if(!($subuser=='root')){
         		if(!$reg->isUsername($subuser)){
            		$form->setError($field, "* Username not valid");
         		}
			}
      }

      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "* Password not entered");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, md5($subpass));
      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username not found");
      }
      else if($result == 2){
         $field = "pass";
         $form->setError($field, "* Invalid password");
      }
      else if($result == -1){
		$field="user";
		$form->setError($field, " * User name is not active");
	}
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($subuser);
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid =   $this->userinfo['id'];
      $this->userprofileid =  $this->userinfo['profile_id'];
      $this->level = $this->userinfo['access_value'];
      if($this->level == ADMIN_LEVEL ){
              $this->real_level=$_SESSION['real_user_level'] = ADMIN_LEVEL;
              $this->real_username = $_SESSION['real_username'] = $this->username;
              $this->real_userid = $_SESSION['real_userid'] = $this->userid;
          }
      $this->logged_in=true;

      
      /* Insert userid into database and update active users table */
      $database->updateUserField($this->userid, "last_login", $this->time);
      return true;
   }

   public function switchUser($username) {
       global $database;
       if ($this->isAdmin()) {
            $this->userinfo = $database->getUserInfo($username);
            if (!empty($this->userinfo) || is_array($this->userinfo)) {
                $this->username = $_SESSION['username'] = $this->userinfo['username'];
                $this->userid = $this->userinfo['id'];
                $this->userprofileid = $this->userinfo['profile_id'];
                $this->level = $this->userinfo['access_value'];
                return true;
            } else {
                die("Cannot switch user, Either you dont have appropriate permission or supplied parameter is worng");
            }
        }else{
            die("You dont have permission for this action");
        }
    }

   /**
    * logout - Gets called when the user wants to be logged out of the
    * website. It deletes any cookies that were stored on the users
    * computer as a result of him wanting to be remembered, and also
    * unsets session variables and demotes his user level to guest.
    */
   function logout(){
      global $database;  //The database connection
      /**
       * Delete cookies - the time must be in the past,
       * so just negate what you added when creating the
       * cookie.
       */

      /* Unset PHP session variables */
      unset($_SESSION['username']);

      /* Reflect fact that user has logged out */
      $this->logged_in = false;
      
      /* Set user level to guest:w
       * */
      $this->username  = GUEST_NAME;
      $this->level = GUEST_LEVEL;
   }

   
   /**
    * isAdmin - Returns true if currently logged in user is
    * an administrator, false otherwise.
    */
   function isAdmin(){
      if ($this->level == ADMIN_LEVEL || $this->real_level ==ADMIN_LEVEL)  return true;
       return false;
   }
    
   /**
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    */
   function generateRandID(){
      return md5($this->generateRandStr(16));
   }
   
   /**
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    */
   function generateRandStr($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
   }
   /**
    * change Password is used when user requests to change his/her 
    * password. takes three arguments viz current password  new password 
    * and conformation of the new password.  varifies current password and 
    * insert new password to the database 
    */
   function changePassword($args){
      global $database, $form, $reg;  //The database and form object
      /* New password entered */
      $reg->check($args,'curpass','safeText');
      $reg->check($args,'newpass','safeText');
      if($args['newpass']!=$args['newpass2'])
      $form->setError('newpass', " * password does not match");

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      else{
        if($database->confirmUserPass($this->username,md5($args['curpass'])) != 0){
           $form->setError('curpass', "* Current Password incorrect");
           return false;
        }
         if($database->updateUserFieldByName($this->username,"password",md5($args['newpass'])))
             return true;
         else
             return false;

      }
   }

}
/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$user = new User;
/* Initialize form object */
$form = new Form;
?>
