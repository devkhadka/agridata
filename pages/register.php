<?php
function registerForm(){
$ret; global $user,$pm,$form;
//$_SESSION['url']=$_SERVER['REQUEST_URI'];
if($pm->checkLogin){
   $ret.= "<h1>Registered</h1>";
   $ret.= "<p>We're sorry <b>$user->username</b>, but you've already registered. "
       ."<a href=\"main.php\">Main</a>.</p>";
}
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      $ret.="<h1>Registered!</h1>";
      $ret.= "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
."and an email has been sent to the email provided with activation link.";
unset($_SESSION['act_link']);
   }
   /* Registration failed */
   else{
      $ret.= "<h1>Registration Failed</h1>";
      $ret.= "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */


else{
$ret.="<h1>Register</h1>";
if($form->num_errors > 0){
  $ret.= "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
$ret.=<<<EOT
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td>First Name:</td>
		<td><input type="text" name="fname" maxlength="30" value="{$form->value("fname")}"></td>
		<td>{$form->error("fname")}</td>
	</tr>
	<tr>
		<td>Middle Name:</td>
		<td><input type="text" name="mname" maxlength="30" value="{$form->value("mname")}"></td>
		<td>{$form->error("mnane")}</td>
	</tr>
	<tr>
	<tr>
		<td>Last Name:</td>
		<td><input type="text" name="lname" maxlength="30" value="{$form->value("lname")}"></td>
		<td>{$form->error("lname")}</td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><input type="text" name="email" maxlength="50" value="{$form->value("email")}">
		</td>
		<td>{$form->error("email")}</td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="passwd1" maxlength="30" value="{$form->value("passwd1")}"></td>
		<td>{$form->error("passwd1")}</td>
	</tr>
	<tr>
		<td>Conform Password:</td>
		<td><input type="password" name="passwd2" maxlength="30" value="{$form->value("passwd2")}"></td>
		<td>{$form->error("passwd2")}</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="hidden" name="subjoin" value="1"><input type="submit" value="Join!"></td>
	</tr>
	<tr>
		<td colspan="2" align="left"><a href="privateminder.php">Back to Home</a></td></tr>
</table>
</form>
EOT;
}
return $ret;
}
?>
