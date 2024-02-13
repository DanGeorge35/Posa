<?php
// ****************************** MAIL SENDING FUNCTIONS FILE *************************

// Note: This is the main mail functions file for cross app mail sending. every mail function is declared here statically in the class 'sm', just use for example sm::send_mail('1st_field','2nd_field') 
// ======================================================================================= 
		
class sm {
	
                 public static function send_confirm_user_mail($email,$link, $firstname){
                        
                            $html_message='<HTML style="background-color: white"><BODY style="width:600px;margin:5px auto;font-size:12px;">
                                <div style="font-family:arial;border:1px solid #ddd; min-height: 40vh;line-height: 20px;  letter-spacing: 0.5; ">
                                  
                                <div style="min-height:50px; padding:10px 25px;">
                              <center> <img src="https://9property.net/logo2.png" style="height:60px;" alt="img">
                              <br> <br></center> 
                            
                             
                             
                                </div>


                <div style="padding:15px;font-size:18px;text-align: justify;color:#099220; background:#fff">

               
                                <span style="">Hello, '.$firstname.'.</span>

                <p >Welcome to 9property, the No 1 Real Estate company in Nigeria, where certified agents from anywhere across the globe converge to help you acquire any landed property you desire without stress and in the fastest time possible.
<br>
                <br>
                Kindly, click the button below to proceed to your account verification.<br><br>

                <center>
                <a href='.$link.'>
                <button style="border: none;color: white;background-color:#3aaf4e;padding: 15px 32px; text-align: center;text-decoration: none;  font-size: 16px; margin: 4px 2px;cursor: pointer;border-radius:30px;">Verify My Account</button>
                 </a>
                </center>
                                <br>
                  </div>
                  <div style="background-color:#dedede;min-height:70px; border-top:1px solid #ccc; padding:10px 25px;">
                             <br><center>  
                            For inquiries, send us an email at <a href="mailto:hello@9property.net" target="_blank">hello@9property.net</a>
                              
                       

                </center>
                </div>

                                </BODY></HTML> ';
                             $message_body=$html_message;            
                            $Server = MAIL_SEND_SERVER;
                            $from = 'hello@9property.net';
                            // $subject = $subject ."(".date("F j, Y, D, h:i a") .")";
                            $headers = "From: ".SITE_NAME."  <".$from.">\n";
                            $headers .= "Reply-To: $Server <".$from.">\n";
                            $headers .= "Return-Path: $Server <".$from.">\n";
                            $headers .= "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                            $mail_from = SITE_NAME;
                            mail($email, 'Welcome to 9property', $message_body, $headers);
                       


                    }

                    public static function send_reset_mail($email,$link, $firstname){
                            
                            $html_message='<HTML style="background-color: white"><BODY style="width:600px;margin:5px auto;font-size:12px;">
                                <div style="font-family:arial;border:1px solid #ddd; min-height: 40vh;line-height: 20px;  letter-spacing: 0.5; ">
                                  
                                <div style="min-height:50px; padding:10px 25px;">
                              <center> <img src="https://9property.net/logo2.png" style="height:60px;" alt="img">
                              <br> <br></center> 
                            
                             
                             
                                </div>


                <div style="padding:15px;font-size:18px;text-align: justify;color:#099220; background:#fff">

                <b style="">Greetings from 9property,</b><br> <br> 
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
                            For inquiries, send us an email at <a href="mailto:hello@9property.net" target="_blank">hello@9property.net</a>
                              
                       

                </center>
                </div>

                                </BODY></HTML>';
                            $message_body=$html_message;            
                            $Server = MAIL_SEND_SERVER;
                            $from = 'hello@9property.net';
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
