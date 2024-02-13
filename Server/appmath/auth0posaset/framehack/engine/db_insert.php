<?php
	// every table insert fuction is here just use dbi::table_name('1st_field','2nd_field')
		
class dbi {
		
	////////////////////////////////////////insert functions ///////////////////////
			////////////////////////////////////////insert functions ///////////////////////
		public static function signup($signup_email,$signup_password,$signup_token,$timestamp){ $db=config::dbcon();
		 $stmt = $db->prepare("INSERT INTO signup(`signup_email`, `signup_password`, `signup_token`, `timestamp`) VALUES(?, ?, ?, ?)");
		 $stmt->execute(array($signup_email,$signup_password,$signup_token,$timestamp));
		 // return $stmt->lastInsertId(); 
		}

		public static function users($member_id,$account_status,$first_name,$login_email,$date_joined,$login_password,$login_token){ $db=config::dbcon();
		 $stmt = $db->prepare("INSERT INTO users(`member_id`, `account_status`, `first_name`, `login_email`, `date_joined`, `login_password`, `login_token`) VALUES(?, ?, ?, ?, ?, ?, ?)");
		 $stmt->execute(array($member_id,$account_status,$first_name,$login_email,$date_joined,$login_password,$login_token));
		}

		public static function admin($admin_id,$username,$login_email,$login_password,$login_token,$role,$account_status){ $db=config::dbcon();
		 $stmt = $db->prepare("INSERT INTO ".__FUNCTION__."(`admin_id`, `username`, `login_email`, `login_password`, `login_token`, `role`, `account_status`) VALUES(?, ?, ?, ?, ?, ?, ?)");
		 $stmt->execute(array($admin_id,$username,$login_email,$login_password,$login_token,$role,$account_status));
		}

		
	 	public static function log($type,$details){ $db=config::dbcon();
 		 $stmt = $db->prepare("INSERT INTO log(`type`, `details`, `ip`, `timestamp`) VALUES(?, ?, ?, ?)");
 		 $stmt->execute(array($type, $details, USER_IP, time()));
		}

		
 

	//////// End of Insert //////////////


/////////////closing bracket for class /////////////
}

?>
