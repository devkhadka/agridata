<?php

//	require_once('./lib/mailer.php');
//	$mail_To = "sudaya.maharjan@gmail.com";
//	$mail_Subject = "HTTP ERROR";
//	$mail_Body = "error string from fsockopen";
//	
//	if($mailer->sendMail($mail_To,$mail_Subject,$mail_Body)){
//		$response = "Your request is successfully sent";
//	}else{
//		$response = "Message Send failed !!";
//	}
//	
//	echo $response;
	$mail_From = "info@agricarenepal.com";
	$mail_To = "sudaya.maharjan@gmail.com";
	$mail_Subject = "Test";
	$mail_Body = "Hello test. error string from fsockopen";

	if(mail($mail_To, $mail_Subject, $mail_Body, $mail_From) ){
		echo "mail has been sent";
	}else{
		echo "mail sent failed!!";
	}
?>
