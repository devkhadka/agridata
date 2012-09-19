<?php
function forgotPass(){

/**

 * Forgot Password form has been submitted and no errors

 * were found with the form (the username is in the database)

 */

$ret;
global $form;
if(isset($_SESSION['forgotpass'])){

   /**

    * New password was generated for user and sent to user's

    * email address.

    */

   if($_SESSION['forgotpass']){

$ret.="<h1>New Password Generated</h1>";

    $ret.= "<p>Your new password has been generated "

          ."and sent to the email <br>associated with your account. "

          ."<a href=\"main.php\">Main</a>.</p>";

   }

   /**

    * Email could not be sent, therefore password was not

    * edited in the database.

    */

   else{$ret.="<h1>New Password Failure</h1>";

    $ret.= "<p>There was an error sending you the email with the new password,<br> so your password has not been changed.<a href=\"privateminder.php\">Main</a>.</p>";

   }
   unset($_SESSION['forgotpass']);
}

else{



/**

 * Forgot password form is displayed, if error found

 * it is displayed.

 */
$ret.="<h1>Forgot Password</h1>
A new password will be generated for you and sent to the email address<br>
associated with your account, all you have to do is enter your
E-mail.<br><br>{$form->error('email')}<form action='process.php' method='POST'><b>Username:</b> <input type='text' name='email' maxlength='30' value=\"{$form->value('email')}\">
<input type=\"hidden\" name=\"subforgot\" value=\"1\">
<input type=\"submit\" value=\"Get New Password\">
</form>";
if($_SESSION['userNotFound'])
{

		$ret.="<form  method=\"POST\" action=\"process.php\">
		<p> Enter your Full Name: <input type=\"text\" name=\"fullName\" value=\"{$form->value('fullName')}\">{$form->error('fullName')}
		<p> Enter your Address: <input type=\"text\" name=\"Address\" value=\"{$form->value('address')}\">{$form->error('address')}
		<p>comments :
		<p> <textarea name=\"comment\" rows=\"4\" cols=\"50\"> </textarea>
		<input type=\"hidden\" name=\"forgotEmailRequest\" value=\"1\">
		<p><input type=\"submit\" value= \"send  mail\" name=\"submit\">
		</form>";
unset($_SESSION['userNotFound']);

}

}
return $ret;
}
?>
