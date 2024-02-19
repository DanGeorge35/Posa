<?php
// ****************************** MAIL SENDING FUNCTIONS FILE *************************

// Note: This is the main mail functions file for cross app mail sending. every mail function is declared here statically in the class 'sm', just use for example sm::send_mail('1st_field','2nd_field') 
// ======================================================================================= 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoloader

// Create a PHPMailer object


class sm {

	
   public static function send_otp_mail($email,$code){
    try {
        echo "start";
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.posaccountant.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@posaccountant.com';
        $mail->Password = 'no-reply001?';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

                        //Recipients
        $mail->setFrom('no-reply@posaccountant.com', SITE_NAME);
        $mail->addAddress($email, $email);

                        //Content
        $mail->isHTML(true);


        $html_message='<HTML style="background-color: white"><BODY style="width:600px;margin:5px auto;font-size:12px;">
        <div style="font-family:arial;border:1px solid #ddd; min-height: 40vh;line-height: 20px;  letter-spacing: 0.5; ">

        <div style="min-height:50px; padding:10px 25px;">
        <center> <img src="https://posaccountant.com/images/icon2.png" style="height:60px;" alt="img">
        <br> <br></center> 



        </div>


        <div style="padding:15px;font-size:18px;text-align: center;color:#f69d5b; background:#fff">



        <p>YOUR  OTP CODE IS <b style="font-size:25px;">'.$code.'</b>
        <br>
        <br>

        </div>

        </BODY></HTML> ';
                             // $message_body=$html_message;  
        echo "body";

        $mail->Subject = 'POSA OTP CODE';
        $mail->Body = $html_message;  
        $mail->send();
        echo 'Email sent successfully!';
        
    } catch (Exception $e) {
        error_log("Failed to send email. Error: {$mail->ErrorInfo}");
    }

    
}

public static function send_reset_mail($email,$link, $firstname){

    $html_message='<HTML style="background-color: white"><BODY style="width:600px;margin:5px auto;font-size:12px;">
    <div style="font-family:arial;border:1px solid #ddd; min-height: 40vh;line-height: 20px;  letter-spacing: 0.5; ">

    <div style="min-height:50px; padding:10px 25px;">
    <center> <img src="https://posaccountant.com/images/icon2.png" style="height:60px;" alt="img">
    <br> <br></center> 



    </div>


    <div style="padding:15px;font-size:18px;text-align: justify;color:#099220; background:#fff">

    <b style="">Greetings from Posa,</b><br> <br> 
    <span > How are you today '.$firstname.',</span> we received a request to reset your account password associated with this e-mail address.

    <p> Click the button below to reset your password using our secured server:<br><br>

    <center>
    <a href='.$link.'>
    <button style="border: none;color: white;background-color:#3aaf4e;padding: 15px 32px; text-align: center;text-decoration: none;  font-size: 16px; margin: 4px 2px;cursor: pointer;border-radius:30px;">Reset Password</button>
    </a>
    </center>
    <br>
    </div>
    <div style="background-color:#dedede;min-height:70px; border-top:1px solid #ccc; padding:10px 25px;">
    <br><center>  
    For inquiries, send us an email at <a href="mailto:hello@posaccountant.net" target="_blank">hello@posaccountant.net</a>



    </center>
    </div>

    </BODY></HTML>';
    $message_body=$html_message;            
    $Server = MAIL_SEND_SERVER;
    $from = 'no-replyreply@posaccountant.net';
                            // $subject = $subject ."(".date("F j, Y, D, h:i a") .")";
    $headers = "From: ".SITE_NAME."  <".$from.">\n";
    $headers .= "Reply-To: $Server <".$from.">\n";
    $headers .= "Return-Path: $Server <".$from.">\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $mail_from = SITE_NAME;
    mail($email, 'Password Reset', $message_body, $headers);
}











}

?>
