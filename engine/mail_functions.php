<?php
	// every mail send function is here
		
class mail {
		
	////////////////////////////////////////insert functions ///////////////////////
	 	public static function send_mail($name,$to_email,$subject,$html_message,$button_text = "",$button_link = ""){ 
		 if(empty($name)) { $name = 'Investor'; } else { $name = $name;} 
		 if(empty($button_text)) { $button_text = 'My Dashboard'; } else { $button_text = $button_text;} 
		 if(empty($button_link)) { $button_link = 'https://<?php echo SITE_NAME; ?>/account/dashboard'; } else { $button_link = $button_link;}
 		
 			$message_body=mail::html_container($name,$html_message,$button_text,$button_link);
 			
 			$Server = MAIL_SEND_SERVER;
		   	$from = MAIL_FROM;
		    $headers = "From: $Server <".$from.">\n";
		    $headers .= "Reply-To: $Server <".$from.">\n";
		    $headers .= "Return-Path: $Server <".$from.">\n";
		    $headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$mail_from = SITE_NAME;
			mail($to_email, $subject, $message_body, $headers, $mail_from);
		} 

		public static function send_investment_activated_mail($name,$to_email,$investment_ref,$amount,$duration,$start_date,$end_date){
		$subject = 'Investment Active and Running';
		$html_message='We are pleased to inform you that your investment with WeU Capital. has been approved and is currently active. <br><br>
                  Here are the details of your investment:  <br> <br>
                  Investment Reference: '.$investment_ref.'  <br> 
                  Investment Amount: ₦'.$amount.' <br> 
                  Duration of Investment: '.$duration.' Months  <br>
                  Start Date: '.$start_date.'<br>
                  End Date: '.$end_date.'<br> <br>
                  You should receive an investment agreement and a certificate of investment in three(3) weeks.<br> <br>
                  Thank you for the trust. We promise to meet up with your expectations.<br> <br>';		
 		mail::send_mail($name,$to_email,$subject,$html_message);
		}

		public static function send_investment_approved_mail($name,$to_email,$investment_ref,$amount,$duration){
		$subject = 'Confirmation of Investment Request';
		$html_message='We are pleased to inform you that we received your request to invest with WeU Capital. <br> 
		You can make your investment deposit into our designated '.WEU_ACCOUNT_BANK.' account ('.WEU_ACCOUNT_NAME.', '.WEU_ACCOUNT_NUMBER.').
		<br><br>
                  Here are the details of your investment:  <br> <br>
                  Investment Reference: '.$investment_ref.'  <br> 
                  Investment Amount: ₦'.$amount.' <br> 
                  Duration of Investment: '.$duration.' Months  <br><br>
            After depositing intended amount for investment, we expect you to send payment details via email to info@<?php echo SITE_NAME; ?> and this Whatsapp number : 07081490286 for prompt activation. <br><br>
            Once we confirm your payment, you should receive investment agreement & certificate of investment with WeU capital seal in three(3) weeks.
                  <br>
			Thanking you for the trust and good choice. We promise you value, security and steady returns.';		
 		mail::send_mail($name,$to_email,$subject,$html_message);
		}

		public static function send_investment_submitted_mail($name,$to_email,$package,$investment_ref,$amount,$amount_words,$duration,$request_date){
		
		$subject = 'Investment Request Submitted';
		$html_message='Your request to invest with WeU Capital has been submitted. <br><br>
                  However, your request is pending manual approval.  <br> <br>
                  Here are the details of your investment request:  <br> <br>
                  Request Date: '.$request_date.'  <br> 
                  Investment Package: '.$package.'  <br> 
                  Investment Reference: '.$investment_ref.'  <br> 
                  Investment Amount: ₦'.$amount.' ('.$amount_words.') <br> 
                  Duration of Investment: '.$duration.' Months  <br> <br>
                  Expect a mail from us within the next 24 hours.<br> <br>
                  Thank you.<br> <br>
                  <small>If you did not initiate this investment request, please report this issue to us right away, your account may have been compromised.</small>';		
 		mail::send_mail($name,$to_email,$subject,$html_message);
		}

		public static function send_new_pw_mail($name,$to_email,$password){
 		$html_message='
 			  Your password has been reset successfully. <br> <br>
                 
                  			Your new password is: <b>'.$password.'</b> <br><br>
                  			Please change this password once you login. <br> <br>
                  			If you did not initiate this password reset please report this issue to us right away, your account may have been compromised.
 		';
 		mail::send_mail($name,$to_email,'Your New Password',$html_message);
		}

		public static function send_verify_pwreset_mail($name,$to_email,$token){
 		$link=SITE_URL.'/account/resetpassword?t='.$token;
 		$html_message='
 					  A password reset request was placed on our system by you. Click/press the button below to reset your password now. <br><br>
 					  If that does not work, copy and paste the following link in your browser: 
 					  <br><br>
		                    <a href="'.$link.'" target="_blank" style="color: #26c6da;">'.$link.'</a> 
		                    <br> <br>
		                    <a href="'.$link.'" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #26c6da; display: inline-block;">Reset My Password</a>
		                    <br><br>
		              <a href="'.$link.'" target="_blank" style="color: #26c6da;">'.$link.'</a> 
		              <br> <br>
		                    If you did not initiate this password reset, please report this issue to us right away, your account may have been compromised. Thank you. 
 		';
 		mail::send_mail($name,$to_email,'Verify Password Reset',$html_message);
		}

		public static function send_welcome_mail($to_email,$signup_password){
 		$html_message='
 			  You are welcome to WeU Capital! We hope you enjoy your time with us. Check your account, update your profile and make your first investment. <br> <br>
                 Here are your login details: <br>
                  			Login Page: '.SITE_URL.'/account/login <br>
                  			Login Email: '.$to_email.' <br>
                  			Login Password: '.$signup_password.' <br>
 		';
 		mail::send_mail('',$to_email,'Welcome to WeU Capital',$html_message);
		}


		public static function send_verify_signup_mail($to_email,$token){
		$link=SITE_URL.'/account/verify_signup?t='.$token;
 		$html_message='
		                  We are glad to have you as a WeU Capital Investor. First, you need to confirm your account. Just click/press the button below.
		                  <br><br>
		                  <a href="'.$link.'" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #26c6da; display: inline-block; background-color:#DC3A14; text-align="center">Confirm Account</a>
		             	  <br><br>
		             	  If the button above does not work, copy and paste the link below into your browser:
		                  <br><br>
		                  <a href="'.$link.'" target="_blank" style="color: #26c6da;">'.$link.'</a> 
		                  <br><br>
								Please note that the link above will expire in 1 hour.
				 		';
 		mail::send_mail('',$to_email,'Verify Your Email Address For WeU Capital',$html_message);
		}

	 
		public static function html_container($name,$html_message,$button_text,$button_link){

		 $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
			<head>

			<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
			<meta content="width=device-width" name="viewport"/>
			<!--[if !mso]><!-->
			<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
			<!--<![endif]-->
			<title></title>
			<!--[if !mso]><!-->
			<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
			<!--<![endif]-->
			<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}

			table,
			td,
			tr {
				vertical-align: top;
				border-collapse: collapse;
			}

			* {
				line-height: inherit;
			}

			a[x-apple-data-detectors=true] {
				color: inherit !important;
				text-decoration: none !important;
			}

			.ie-browser table {
				table-layout: fixed;
			}

			[owa] .img-container div,
			[owa] .img-container button {
				display: block !important;
			}

			[owa] .fullwidth button {
				width: 100% !important;
			}

			[owa] .block-grid .col {
				display: table-cell;
				float: none !important;
				vertical-align: top;
			}

			.ie-browser .block-grid,
			.ie-browser .num12,
			[owa] .num12,
			[owa] .block-grid {
				width: 650px !important;
			}

			.ie-browser .mixed-two-up .num4,
			[owa] .mixed-two-up .num4 {
				width: 216px !important;
			}

			.ie-browser .mixed-two-up .num8,
			[owa] .mixed-two-up .num8 {
				width: 432px !important;
			}

			.ie-browser .block-grid.two-up .col,
			[owa] .block-grid.two-up .col {
				width: 324px !important;
			}

			.ie-browser .block-grid.three-up .col,
			[owa] .block-grid.three-up .col {
				width: 324px !important;
			}

			.ie-browser .block-grid.four-up .col [owa] .block-grid.four-up .col {
				width: 162px !important;
			}

			.ie-browser .block-grid.five-up .col [owa] .block-grid.five-up .col {
				width: 130px !important;
			}

			.ie-browser .block-grid.six-up .col,
			[owa] .block-grid.six-up .col {
				width: 108px !important;
			}

			.ie-browser .block-grid.seven-up .col,
			[owa] .block-grid.seven-up .col {
				width: 92px !important;
			}

			.ie-browser .block-grid.eight-up .col,
			[owa] .block-grid.eight-up .col {
				width: 81px !important;
			}

			.ie-browser .block-grid.nine-up .col,
			[owa] .block-grid.nine-up .col {
				width: 72px !important;
			}

			.ie-browser .block-grid.ten-up .col,
			[owa] .block-grid.ten-up .col {
				width: 60px !important;
			}

			.ie-browser .block-grid.eleven-up .col,
			[owa] .block-grid.eleven-up .col {
				width: 54px !important;
			}

			.ie-browser .block-grid.twelve-up .col,
			[owa] .block-grid.twelve-up .col {
				width: 50px !important;
			}
			</style>
			<style id="media-query" type="text/css">
			@media only screen and (min-width: 670px) {
				.block-grid {
					width: 650px !important;
				}

				.block-grid .col {
					vertical-align: top;
				}

				.block-grid .col.num12 {
					width: 650px !important;
				}

				.block-grid.mixed-two-up .col.num3 {
					width: 162px !important;
				}

				.block-grid.mixed-two-up .col.num4 {
					width: 216px !important;
				}

				.block-grid.mixed-two-up .col.num8 {
					width: 432px !important;
				}

				.block-grid.mixed-two-up .col.num9 {
					width: 486px !important;
				}

				.block-grid.two-up .col {
					width: 325px !important;
				}

				.block-grid.three-up .col {
					width: 216px !important;
				}

				.block-grid.four-up .col {
					width: 162px !important;
				}

				.block-grid.five-up .col {
					width: 130px !important;
				}

				.block-grid.six-up .col {
					width: 108px !important;
				}

				.block-grid.seven-up .col {
					width: 92px !important;
				}

				.block-grid.eight-up .col {
					width: 81px !important;
				}

				.block-grid.nine-up .col {
					width: 72px !important;
				}

				.block-grid.ten-up .col {
					width: 65px !important;
				}

				.block-grid.eleven-up .col {
					width: 59px !important;
				}

				.block-grid.twelve-up .col {
					width: 54px !important;
				}
			}

			@media (max-width: 670px) {

				.block-grid,
				.col {
					min-width: 320px !important;
					max-width: 100% !important;
					display: block !important;
				}

				.block-grid {
					width: 100% !important;
				}

				.col {
					width: 100% !important;
				}

				.col>div {
					margin: 0 auto;
				}

				img.fullwidth,
				img.fullwidthOnMobile {
					max-width: 100% !important;
				}

				.no-stack .col {
					min-width: 0 !important;
					display: table-cell !important;
				}

				.no-stack.two-up .col {
					width: 50% !important;
				}

				.no-stack .col.num4 {
					width: 33% !important;
				}

				.no-stack .col.num8 {
					width: 66% !important;
				}

				.no-stack .col.num4 {
					width: 33% !important;
				}

				.no-stack .col.num3 {
					width: 25% !important;
				}

				.no-stack .col.num6 {
					width: 50% !important;
				}

				.no-stack .col.num9 {
					width: 75% !important;
				}

				.video-block {
					max-width: none !important;
				}

				.mobile_hide {
					min-height: 0px;
					max-height: 0px;
					max-width: 0px;
					display: none;
					overflow: hidden;
					font-size: 0px;
				}

				.desktop_hide {
					display: block !important;
					max-height: none !important;
				}
			}
			</style>
			</head>
			<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #F5F5F5;">
			<style id="media-query-bodytag" type="text/css">
			@media (max-width: 670px) {
			.block-grid {
			min-width: 320px!important;
			max-width: 100%!important;
			width: 100%!important;
			display: block!important;
			}
			.col {
			min-width: 320px!important;
			max-width: 100%!important;
			width: 100%!important;
			display: block!important;
			}
			.col > div {
			margin: 0 auto;
			}
			img.fullwidth {
			max-width: 100%!important;
			height: auto!important;
			}
			img.fullwidthOnMobile {
			max-width: 100%!important;
			height: auto!important;
			}
			.no-stack .col {
			min-width: 0!important;
			display: table-cell!important;
			}
			.no-stack.two-up .col {
			width: 50%!important;
			}
			.no-stack.mixed-two-up .col.num4 {
			width: 33%!important;
			}
			.no-stack.mixed-two-up .col.num8 {
			width: 66%!important;
			}
			.no-stack.three-up .col.num4 {
			width: 33%!important
			}
			.no-stack.four-up .col.num3 {
			width: 25%!important
			}
			}
			</style>
			<!--[if IE]><div class="ie-browser"><![endif]-->
			<table bgcolor="#F5F5F5" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #F5F5F5; width: 100%;" valign="top" width="100%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">

			<div style="background-color:transparent;">
			<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">

			<div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;;">
			<div style="width:100% !important;">
			<!--[if (!mso)&(!IE)]><!-->
			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
			<!--<![endif]-->
			<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
			<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="10" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; border-top: 0px solid transparent; height: 10px;" valign="top" width="100%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td height="10" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse;" valign="top"><span></span></td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>

			</div>

			</div>
			</div>

			</div>
			</div>
			</div>
			<div style="background-color:transparent;">
			<div class="block-grid two-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

			<div class="col num6" style="min-width: 320px; max-width: 325px; display: table-cell; vertical-align: top;;">
			<div style="width:100% !important;">

			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:25px; padding-right: 0px; padding-left: 25px;">

			<div align="left" class="img-container left fixedwidth" style="padding-right: 0px;padding-left: 0px;">
			<img width="30px" alt="Image" border="0" class="left" src="https://<?php echo SITE_NAME; ?>/images/weu.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 195px; display: block;" title="Image" width="195"/>

			</div>

			</div>

			</div>
			</div>

			<div class="col num6" style="min-width: 320px; max-width: 325px; display: table-cell; vertical-align: top;;">
			<div style="width:100% !important;">

			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:25px; padding-right: 25px; padding-left: 0px;">

			<div align="right" class="button-container" style="padding-top:10px;padding-right:0px;padding-bottom:10px;padding-left:10px;">
			<a href="https://<?php echo SITE_NAME; ?>/account/contact-us" style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #052d3d; background-color: #e3edfe; border-radius: 14px; -webkit-border-radius: 14px; -moz-border-radius: 14px; width: auto; width: auto; border-top: 1px solid #e3edfe; border-right: 1px solid #e3edfe; border-bottom: 1px solid #e3edfe; border-left: 1px solid #e3edfe; padding-top: 5px; padding-bottom: 5px; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;" target="_blank"><span style="padding-left:20px;padding-right:20px;font-size:14px;display:inline-block;">
			<span style="font-size: 16px; line-height: 32px;"><span style="font-size: 14px; line-height: 28px;">Contact Us</span></span>
			</span></a>

			</div>

			</div>

			</div>
			</div>

			</div>
			</div>
			</div>
			<div style="background-color:transparent;">
			<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #D6E7F0;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#D6E7F0;">

			<div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;;">
			<div style="width:100% !important;">

			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:60px; padding-right: 25px; padding-left: 25px;">

			<div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
			</div>

			<div style="color:#052d3d;font-family:"Lato", Tahoma, Verdana, Segoe, sans-serif;line-height:150%;padding-top:20px;padding-right:10px;padding-bottom:0px;padding-left:15px;">
			<div style="font-size: 12px; line-height: 18px; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif; color: #052d3d;">

			<p style="font-size: 14px; line-height: 51px; text-align: center; margin: 0;"><span style="font-size: 34px;"><strong><span style="line-height: 51px; font-size: 34px;"><span style="color: #2190e3; line-height: 51px; font-size: 34px;">Dear '.$name.'</span></span></strong></span></p>
			</div>
			</div>

			<div style="color:#555555;font-family:"Lato", Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
			<div style="font-size: 12px; line-height: 14px; color: #555555; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif;">
			<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;"><span style="font-size: 16px; color: #000000;">'.$html_message.'</span></p>
			</div>
			</div>

			<div align="center" class="button-container" style="padding-top:40px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
			<a href="'.$button_link.'" style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #ffffff; background-color: #fc7318; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; width: auto; width: auto; border-top: 1px solid #fc7318; border-right: 1px solid #fc7318; border-bottom: 1px solid #fc7318; border-left: 1px solid #fc7318; padding-top: 10px; padding-bottom: 10px; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;">
			<span style="font-size: 16px; line-height: 32px;"><strong>'.$button_text.'</strong></span>
			</span></a>

			</div>

			<div style="color:#555555;font-family:"Lato", Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
			<div style="font-size: 12px; line-height: 14px; color: #555555; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif;">
			<p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;"><span style="font-size: 14px; color: #000000;">Simply reply this email, if you have any questions.
			<br><br>
			Warm Regards,<br>
			WeU Capital Team.
			</span></p>
			</div>
			</div>
			</div>

			</div>
			</div>

			</div>
			</div>
			</div>
			<div style="background-color:transparent;">
			<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">

			<div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;;">
			<div style="width:100% !important;">
			<!--[if (!mso)&(!IE)]><!-->
			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:60px; padding-right: 0px; padding-left: 0px;">
			<!--<![endif]-->
			<table cellpadding="0" cellspacing="0" class="social_icons" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td style="word-break: break-word; vertical-align: top; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
			<table activate="activate" align="center" alignment="alignment" cellpadding="0" cellspacing="0" class="social_table" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: undefined; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;" to="to" valign="top">
			<tbody>
			</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>

			<div style="color:#555555;font-family:"Lato", Tahoma, Verdana, Segoe, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
			<div style="font-size: 12px; line-height: 18px; color: #555555; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif;">
			<p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;">You are receiving this email because you signed up on www.<?php echo SITE_NAME; ?> </p>
			<p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;">No41 Francis Okediji Street, Off Ibadan Business School, Old Bodija Ibadan, Nigeria.</p>
			</div>
			</div>
			<!--[if mso]></td></tr></table><![endif]-->
			<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
			<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 60%; border-top: 1px dotted #C4C4C4; height: 0px;" valign="top" width="60%">
			<tbody>
			<tr style="vertical-align: top;" valign="top">
			<td height="0" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse;" valign="top"><span></span></td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>

			<div style="color:#4F4F4F;font-family:"Lato", Tahoma, Verdana, Segoe, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
			<div style="font-size: 12px; line-height: 14px; color: #4F4F4F; font-family: "Lato", Tahoma, Verdana, Segoe, sans-serif;">
			<p style="font-size: 12px; line-height: 16px; text-align: center; margin: 0;"><span style="font-size: 14px;"><a href="https://<?php echo SITE_NAME; ?>/account/dashboard" rel="noopener" style="text-decoration: none; color: #2190E3;" target="_blank"><strong>Your Dashboard</strong></a> |  <strong><a href="https://<?php echo SITE_NAME; ?>/account/contact-us" rel="noopener" style="text-decoration: none; color: #2190E3;" target="_blank">Contact Us</a> </strong></span></p>
			</div>
			</div>

			</div>

			</div>
			</div>

			</div>
			</div>
			</div>

			</td>
			</tr>
			</tbody>
			</table>

			</body>
			</html>';

		 return $message;
		}



	//////// End of Insert //////////////


/////////////closing bracket for class /////////////
}

?>
