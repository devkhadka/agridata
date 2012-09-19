<?php
date_default_timezone_set('Asia/Kathmandu');
require_once('lib/class.phpmailer.php');
class Mailer
{
    var $mail;
    function Mailer(){
        $this->mail = new PHPMailer();
        //$this->mail->IsSMTP(); //telling to use smtp
        //$this->mail->Host       = "smtp.gmail.com"; // SMTP server
        //$this->mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        //$this->mail->SMTPAuth   = true;                  // enable SMTP authentication
        //$this->mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        //$this->mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        //$this->mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        //$this->mail->Username   = "";  // GMAIL username
        //$this->mail->Password   = "";  // GMAIL password

        $this->mail->SetFrom('enqyery@agricarenepal.com', 'Agricare Nepal');

        $this->mail->AddReplyTo("enquery@agricarenepal.com","Agricare Nepal");

    }
    function sendEnqyeryEmail($name,  $email,$user, $pass){
        $body = "Dear webmaster,<br/><br/>"
            ."This is the notification about the enquery in  ".SITE_NAME." with the following information by {$user}:<br/><br/>"
            ."Username: ".$user."<br/>"
            ."Password: ".$pass."<br/>"
            ."If you ever lose or forget your password, a new "
            ."password will be generated for you and sent to this "
            ."<br/>" .SITE_NAME;

        $this->mail->Subject    = "Registration - Agricare Nepal";

        $this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $this->mail->MsgHTML($body);

        $address = $email;
        $this->mail->AddAddress($address, $user);

        //$this->mail->AddAttachment("images/sec_cam5.jpg"); // attachment
        //$this->mail->AddAttachment("images/cam2.jpg"); // attachment

        return $this->mail->Send(); 
    }

    /**
     * sendNewPass - Sends the newly generated password
     * to the user's email address that was specified at
     * sign-up.
     */
    function sendNewPass($user, $email, $pass){
        $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
        $subject = "'s Site - Your new password";
        $body = $user.",\n\n"
            ."We've generated a new password for you at your "
            ."request, you can use this new password with your "
            ."username to log in to".SITE_NAME."'s Site.\n\n"
            ."Username: ".$user."\n"
            ."New Password: ".$pass."\n\n"
            ."It is recommended that you change your password "
            ."to something that is easier to remember, which "
            ."can be done by going to the My Account page "
            ."after signing in.\n\n"
            ."-".SITE_NAME;

        $this->mail->Subject    = SITE_NAME."-Your new password";

        $this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $this->mail->MsgHTML($body);

        $address = $email;
        $this->mail->AddAddress($address, $user);

        //$this->mail->AddAttachment("images/sec_cam5.jpg");      // attachment

        return $this->mail->Send(); 
    }

    function askExpertQuery($args){
        $query="";
        $query.=<<<EOT
            Name : {$args['name']} <br /> 
            Address : {$args['address']}<br />
            Telephone : {$args['phone']} <br />
            Email: {$args['email']}<br />
            Profession: {$args['profession']}<br /> 
EOT;
        if($args['profession']=='student'){
            $query.="College : {$args['collegeS']}<br /> "
                ."Interested Topic :{$args['topicS']}<br /> "
                ."Question : {$args['questionS']}<br /> ";
        }
        else if($args['profession']=='farmer'){
            $query.="Name of the Crop : {$args['cropF']}<br /> "
                ."Problems in Crop (General) :{$args['generalF']}<br /> "
                ."Problems in Crop(Specific) : {$args['specificF']}<br /> "
                ."Days-problem appeared : {$args['dateOfProblem']}<br /> ";
        }
        else if($args['profession']=='research'){
            $query.="Topic of Research : {$args['topicR']}<br /> "
                ."Explanation : {$args['explanationR']}<br /> ";
        }
        $body = "Dear webmaster,<br/><br/>"
            ."This is the notification about the enquiry in  ".SITE_NAME." with the following information by {$args['name']}:<br/><br/>"
            .$query
            ."<br/>" .SITE_NAME;

        $this->mail->Subject    = "Enquery Message".SITE_NAME;
        $this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $this->mail->MsgHTML($body);
        $this->mail->AddAddress(EMAIL_WEB_MASTER, "Web Master");
        $this->mail->AddAddress($args['email'], $args['name']);
        return $this->mail->Send(); 
        
    }
};

/* Initialize mailer object */
$mailer = new Mailer;

?>
