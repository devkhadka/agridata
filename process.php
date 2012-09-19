<?php
/**
 * Process.php
 * 
 * The Process class is meant to simplify the task of processing
 * user submitted forms, redirecting the user to the correct
 * pages if errors are found, or if form is successful, either
 * way. Also handles the logout procedure.
 *
 */
include("./include/class.controller.php");

class Process
{
   /* Class constructor */
   function Process(){
       global $ctrl; global $user;
      /* User submitted login form */
      if(isset($_POST['synlogin'])){
         $this->procLogin();
      }
      /* User submitted registration form */
      else if(isset($_POST['subjoin'])){
         $this->procRegister();
      }
      /* User submitted forgot password form */
      else if(isset($_POST['subforgot'])){
         $this->procForgotPass();
      }
      /* User submitted edit account form */
      else if(isset($_POST['subedit'])){
         $this->procEditAccount();
      }
      else if(isset($_POST['addProfile'])){
                   $this->procAddProfile(); 
      }
      else if(isset($_POST['switch']) && isset ($_POST['username'])){
                    $this->procSwitchUser();
      }
      
      /* The only other reason user should be directed here
       * is if he wants to logout, which means user is
       * logged in currently.
       */
      else if($user->logged_in){
		   $this->procLogout();
      }   
      
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
      header("Location:".DEFAULT_PAGE );
       }
   }

   /**
    * procLogin - Processes the user submitted login form, if errors
    * are found, the user is redirected to correct the information,
    * if not, the user is effectively logged in to the system.
    */
   function procLogin(){
      global $user, $form,$ctrl;
      /* Login attempt */
      $retval = $user->login($_POST['user'], $_POST['pass']);
      
      /* Login successful */
      if($retval){
         // echo "true returned".$user->username;
      header("Location:".DEFAULT_PAGE );
      }
      /* Login failed */
      else{
          //echo "false returned";
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
        header("Location:".DEFAULT_PAGE );
      }
   }
   
   /**
    * procLogout - Simply attempts to log the user out of the system
    * given that there is no logout form to process.
    */
   function procLogout(){
      global $user;
      $user->logout();
      header("Location:".DEFAULT_PAGE);
   }
   
   /**
    * procRegister - Processes the user submitted registration form,
    * if errors are found, the user is redirected to correct the
    * information, if not, the user is effectively registered with
    * the system and an email is (optionally) sent to the newly
    * created user.
    */
   function procRegister(){
      global $user, $form, $pm;
      /* Convert username to all lowercase (by option) */
      /*if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }*/
      /* Registration attempt */
	$args=array("fname"=>$_POST['fname'],"mname"=>$_POST['mname'],"lname"=>$_POST['lname'],"email"=>$_POST['email'],"passwd1"=>$_POST['passwd1'], "passwd2"=>$_POST['passwd2']);
      $retval = $pm->register($args);
      
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['fname'];
         $_SESSION['regsuccess'] = true;
         header("Location: ".$pm->referrer);
      }
      /* Error found with form */
      else if($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location:".$pm->referrer);
      }
      /* Registration attempt failed */
      else if($retval == 2){
         $_SESSION['reguname'] = $_POST['fname'];
         $_SESSION['regsuccess'] = false;
         header("Location: privateminder.php?r=register");
      }
   }

 /***
*procAddProfile adds the profile information entered by the uses into the session variable and waits  untill the 
*user sends payment information to
*inserted into the database
*/
    function procAddProfile(){
        global $pm,$form;    
        //$args= array('streetAdd1'=>$_POST['streetAdd1'],'streetAdd2'=>$_POST['streetAdd2'],'city'=>$_POST['city'],'state'=>$_POST['state'],'zip'=>$_POST['zip'],'country'=>$_POST['country'],'mobile'=>$_POST['mobile']);
        $retval=$pm->addProfileInfo($_POST);

        /* Registration Successful */
        if($retval == true){
            header("Location: ".$pm->referrer);
        }
        /* Error found with form */
        else{
           $_SESSION['addPPInfoError'] =true;
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:".$pm->referrer);
        }
        /* Registration attempt failed */
    }



   /**
    * procForgotPass - Validates the given username then if
    * everything is fine, a new password is generated and
    * emailed to the address the user gave on sign up.
    */
   function procForgotPass(){
      global $database, $user, $mailer, $form,$ctrl;
      /* Username error checking */
      $email = $_POST['email'];
      $field = "email";  //Use field name for username
      if(!$email || strlen($email = trim($email)) == 0){
         $form->setError($field, "* Email not entered<br>");
      }
      else{         /* Make sure username is in database */
         $email = stripslashes($email);
         /* Check if valid email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$email)){
            $form->setError($field, "* Email invalid");
         }
		else if (!$database->usernameTaken($email)){
            $form->setError($field, "* Username does not exist<br>");
			$_SESSION['userNotFound']= true;
         }

      }
      
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
      }
      /* Generate new password and email it to user */
      else{
         /* Generate new password */
         $newpass = $user->generateRandStr(8);
         /* Get email of user */
         $username = $database->getUserName($email);
         /* Attempt to send the email with new password */
         if($mailer->sendNewPass( $username, $email,$newpass)){
            /* Email sent, update database */
            $database->updateUserFieldByName($username, "password", md5($newpass));
            $_SESSION['forgotpass'] = true;
         }
         /* Email failure, do not change password */
         else{
            $_SESSION['forgotpass'] = false;
         }
      }
      
      header("Location: ".$ctrl->referrer);
   }
   
   /**
    * procEditAccount - Attempts to edit the user's account
    * information, including the password, which must be verified
    * before a change is made.
    */
   function procEditAccount(){
      global $user, $form;
      /* Account edit attempt */
      $retval = $user->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email']);

      /* Account edit successful */
      if($retval){
         $_SESSION['useredit'] = true;
         header("Location: ".$pm->referrer);
      }
      /* Error found with form */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$pm->referrer);
      }
   }
   
   
   //-------------------------Router-----------------------------------
	
		function procAddRouter(){
			
			 global $pm,$form;
			
			$args = array("hostName"=>$_POST['hostName'],"hostType"=>$_POST['hostType'],"routerManufacturer"=>$_POST['routerManufacturer'],"routerModelNo"=>$_POST['routerModelNo'],"helpSetCamera"=>$_POST['helpSetCamera'],"adminUsername"=>$_POST['adminUsername'],"adminPassword"=>$_POST['adminPassword'],"port"=>$_POST['port'],"protocol" =>$_POST['protocol'],"otherManufacturer"=>$_POST['otherManufacturer'],"otherModel"=>$_POST['otherModel']);
			
			
			$retval = $pm->addRouter($args);
			
			if($retval){
				 $_SESSION['addRouterSuccess'] = true;
				header("Location: privateminder.php?r=addrouter");				
			}
			else{
				 $_SESSION['value_array'] = $_POST;
				 $_SESSION['error_array'] = $form->getErrorArray();
				 header("Location: privateminder.php?r=addrouter");
				 //header("Location: ".$pm->referrer);
			}
			
		}
	
	
	
   //-------------------------- End Router-----------------------------
   
   //-----------------------start add camera---------------------------------
   function procAddCamera(){
	   
		global $pm,$form; 
		
		//echo $_POST;
		//print_r($_POST);
		//die();
		
		$args = array("cameraName"=>$_POST['cameraName'],"hostName"=>$_POST['hostName'],"port"=>$_POST['port'],"cType"=>$_POST['cType'],"username"=>$_POST['username'],"password"=>$_POST['password'],"vresoln"=>$_POST['vresoln'],"hresoln"=>$_POST['hresoln'],"mfps" =>$_POST['mfps']);
		$retval = $pm->addCamera($args);

		if($retval){
			 $_SESSION['addCameraSuccess'] = true;
			 header("Location: privateminder.php?r=addcamera");				
		}
		else{
			 $_SESSION['value_array'] = $_POST;
			 $_SESSION['error_array'] = $form->getErrorArray();
			 header("Location: privateminder.php?r=addcamera");
			 //header("Location: ".$pm->referrer);
		}
   }
   
   function procEditCamera(){
	   
	   	global $pm,$form;
	    $args = array("cameraName"=>$_POST['cameraName'],"hostName"=>$_POST['hostName'],"port"=>$_POST['port'],"cType"=>$_POST['cType'],"username"=>$_POST['username'],"password"=>$_POST['password'],"vresoln"=>$_POST['vresoln'],"hresoln"=>$_POST['hresoln'],"mfps" =>$_POST['mfps']);
		$retval = $pm->editCamera($args,$_POST['id']);
		$_SESSION['valueEdited'] = true;
		
		if($retval){
			 $_SESSION['editCameraSuccess'] = true;
			 header("Location: privateminder.php?r=editcamera&id=".$_POST['id']);				
		}
		else{
			 $_SESSION['value_array'] = $_POST;
			 $_SESSION['error_array'] = $form->getErrorArray();
			 header("Location: privateminder.php?r=editcamera&id=".$_POST['id']);
			 //header("Location: ".$pm->referrer);
		}
   }

   
   //----------------------end add camera---------------------
   
   function procAddAlert(){
	   
	   global $pm;
	   
	   $retval = $pm->addAlert($_REQUEST);
	   
	   if($retval){
		   $_SESSION['addAlertSuccess'] = true;
		   header("Location: privateminder.php?r=addalert");
	   }
	   else
	   {
		   header("Location: privateminder.php?r=addalert");
	   }
	   //print_r($_POST);
	   
	   //print_r(array_keys($_POST));
	   //die();	   
   }
   
   function procEditAlert(){
	   global $pm;
	   
	   $retval = $pm->editAlert($_POST);
	   
	   if($retval){
		   $_SESSION['editAlertSuccess'] = true;
		   header("Location: privateminder.php?r=editalert");
	   }
	   else
	   {
		   header("Location: privateminder.php?r=editalert");
	   }
	   
   }
   function procSwitchUser(){
      global $user;
      /* Login attempt */
      $retval = $user->switchUser($_POST['username']);

      /* Login successful */
      if($retval){
         // echo "true returned".$user->username;
      header("Location:".DEFAULT_PAGE );
      }
      /* Login failed */
      else{
          //echo "false returned";
         
        header("Location:".DEFAULT_PAGE );
      }
   }
   
};

/* Initialize process */
$process = new Process;
?>
