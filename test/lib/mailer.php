<?php
date_default_timezone_set('Asia/Kathmandu');
require_once('lib/class.phpmailer.php');
class Mailer
{
    var $mail;
    function Mailer(){
        $this->mail = new PHPMailer();
        $this->mail->SetFrom('info@agricarenepal.com', 'Sagarmatha Engineering College');
        $this->mail->AddReplyTo("info@agricarenepal.com","Sagarmatha Engineering College");
    }
    function sendMail($to,$sub,$msg){
        $body = "Dear webmaster,<br/><br/>"
            ."This is the notification about the enquery in  ".$_SERVER['HTTP_HOST']." with the following information<br/><br/>"
            .$msg;

        $this->mail->Subject    = "Enquery =>".$sub;
        $this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		 // optional, comment out and test
        $this->mail->MsgHTML($body);        
        $this->mail->AddAddress($to,"sudaya");
        return $this->mail->Send(); 
    }
};

/* Initialize mailer object */
$mailer = new Mailer;

?>
