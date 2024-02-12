<?php 
/* 
  _____                  _ _            _____ _______     ______                                           _    
 |  __ \                | | |          |_   _|__   __|   |  ____|                                         | |   
 | |  | | __ _ _ __ ___ | | |___   ______| |    | |______| |__ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 | |  | |/ _` | '__/ _ \| | / __| |______| |    | |______|  __| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 | |__| | (_| | | | (_) | | \__ \       _| |_   | |      | |  | | | (_| | | | | | |  __/\ V  V / (_) | |  |   < 
 |_____/ \__,_|_|  \___/|_|_|___/      |_____|  |_|      |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\

                                               
									  ,-.     ,-.       ,---.   ,--.   ,--. ,---.  
									 / .',---.'. \     '.-.  \ /    \ /   || o   \ 
									|  || .--' |  |     .-' .'|  ()  |`|  |`..'  | 
									|  |\ `--. |  |    /   '-. \    /  |  | .'  /  
									 \ '.`---'.' /     '-----'  `--'   `--' `--'   
									  `-'     `-'                                 

* Core Functions Class - This class contains the main functions of the website
* To use, include it in any page and refer to its functions like this cf::function_name()
* All global definations are done here. Database connection is also initialised
*/





//---------------------------------------------------------------------------------- Declare Class
class cf {

//---------------------------------------------------------------------------------- Pages Routing / Redeirecting
	public static function redirect($page) {
	 header('location:'.$page.''); exit();}
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Admin Authentication function
	 /*
	 * 1. The token is first fetched from the database using the email provided
	 * 2. We get the password chars using md5 of the Concatination of the fetched token with the with the user's provided password
	 * 3. Confirm if the resulting password chars  is the same as in the database using the fetch procedure 
	 * 4. Count if record is found in the databse admin table, and return true if so.
	 */
	public static function auth_admin($email,$pass) { 

		$db=config::dbcon();
	 $login_token=cf::selany('login_token','admin','login_email',$email); 
	 $password=md5($pass.$login_token);
	 $stmt = $db->prepare("SELECT * FROM admin WHERE login_email=:email and login_password=:password");
	 $stmt->execute(array(':email' => $email, ':password' => $password));
	 $row_count = $stmt->rowCount();
	 if($row_count>0){ return true; }

	}
//------------------------------------------------------------------------------------------------------------




//---------------------------------------------------------------------------------- Admin Login function (SESSION)
	/*
	 * 1. Create a session of the admin ID. taken from the admin table using the provided admin email
	 * 2. Create the admin login token using the  provided admin login email
	 * 3. Save The login process in the log table
	 * 4.  Redirect the user to another page with the provided redirect url
	 */
	public static function login_admin($email,$redirect) { 
	 $_SESSION['admin_id']=cf::selany('admin_id','admin','login_email',$email);
	 $_SESSION['admin_login_token']=cf::selany('login_token','admin','login_email',$email);
	 cf::log_login($email);
	 cf::redirect($redirect);
	}
//------------------------------------------------------------------------------------------------------------






//---------------------------------------------------------------------------------- Check Admin Token function
	/*
	 * 1. Check if the admin session is availanle or not
	 * 2. If not return false back as a result
	 * 3. If so find the login token in the admin table  at field admin_id using the AdminID session 
	 * 4. Compare if the  database admin-login-token is the same as the session admin-login-token  available
	 * 5. If so, return true OR return false if not.
	 */
	public static function checkauthadmin() {
	 if (!isset($_SESSION['admin_id']) or !isset($_SESSION['admin_login_token']))
	 { return false;}
	 else{ $login_token=cf::selany('login_token','admin','admin_id',$_SESSION['admin_id']);
		if ($login_token==$_SESSION['admin_login_token']) { return true; }
		else { return false;}
		 }
	 }
//------------------------------------------------------------------------------------------------------------





//---------------------------------------------------------------------------------- Users Authentication function
	 /*
	 * 1. The token is first fetched from the database using the login-email provided
	 * 2. We get the password chars using md5 of the Concatination of the fetched token with the with the user's provided password
	 * 3. Confirm if the resulting password chars  is the same as in the database using the fetch procedure 
	 * 4. Count if record is found in the databse admin table, and return true if so.
	 * NOTE: The same process as the   Admin Authentication function
	 */
	 public static function auth_user($email,$pass) { $db=config::dbcon();
	 $login_token=cf::selany('login_token','users','login_email',$email);
	 $password=md5($pass.$login_token);
	 $stmt = $db->prepare("SELECT * FROM users WHERE login_email=:email and login_password=:password");
	 $stmt->execute(array(':email' => $email, ':password' => $password));
	 $row_count = $stmt->rowCount();
	 if($row_count>0){ return true; }
	}
//------------------------------------------------------------------------------------------------------------





//---------------------------------------------------------------------------------- Users Login function (SESSION)
	/*
	 * 1. Create a session of the user_id. taken from the users table using the provided users email
	 * 2. Create the users login token using the  provided users login email
	 * 3. Save The login process in the log table
	 * 4.  Redirect the user to another page with the provided redirect url
	 * NOTE: The same process as the   Admin Authentication function
	 */
	 public static function login_user($email,$redirect) { 
	 $_SESSION['user_id']=cf::selany('user_id','users','login_email',$email);
	 $_SESSION['member_login_token']=cf::selany('login_token','users','login_email',$email);
	 cf::log_login($email);
	 cf::redirect($redirect);
	}
//------------------------------------------------------------------------------------------------------------





//---------------------------------------------------------------------------------- Check Users Token function
	/*
	 * 1. Check if the users session is availanle or not
	 * 2. If not return false back as a result
	 * 3. If so find the login token in the users table  at field user_id using the user_id session 
	 * 4. Compare if the  database users-login-token is the same as the session users-login-token  available
	 * 5. If so, return true OR return false if not.
	 * NOTE: The same process as the   Admin Authentication function
	 */
	public static function checkauthuser() {
	 if (!isset($_SESSION['user_id']) or !isset($_SESSION['member_login_token']))
	 { return false;}
	 else{ $login_token=cf::selany('login_token','users','user_id',$_SESSION['user_id']);
		if ($login_token==$_SESSION['member_login_token']) { return true; }
		else { return false;}
		 }
	 }
//------------------------------------------------------------------------------------------------------------




//---------------------------------------------------------------------------------- Get the  user_id session function
	public static function userid() {
	 $userid=$_SESSION['user']; return $userid;
	}
//------------------------------------------------------------------------------------------------------------



	
//---------------------------------------------------------------------------------- Get the  admin_id session function
	public static function adminid() {
	 $adminid=$_SESSION['admin']; return $adminid;
	}	
//------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------- Get the  salt  function
	/*
	 * For Encription Purpose,
	*/
	public static function salt(){ return  '@/*#t07%'; }
//------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------- Logout Session And Cookie function
	/*
	 * Clean off all sessios and cokies 
	*/
	public static function logout() {
	 $_SESSION = array();
	 if (isset($_COOKIE[session_name()])) {setcookie(session_name(), '', time()-86400, '/');}
	 session_destroy();
	}
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Change user role
	/*
	 * This is useful in a website where role is attached to each users
	 * And the roles determing what the users will have access to 
	*/
	public static function change_role($id,$newrole) { 
	cf::update('users','role',$newrole,'id',$id);
	}
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Check if user's informaton is availble or not
	/*
	 * This is useful in a website where users will have to write about themselves
	 * Information written will have to be displayed to visitors to view and read
	*/
	public static function checkuserinfo($userid) {
		$count=cf::countrow('id','user_info','user_id',$userid);
	 if ($count > 0) { return true;}
		else { return false;}
	}
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Process the role of an admin 
	/*
	 * This is will help to tell the role of an admin and the level of power assigned.
	 * NOTE: This color work well only with BOOSTRAP
	*/
	public static function process_admin_role($role,$option = '') {
		if ($role == 0) { $data = 'Level 0 Admin'; $color = 'primary'; } 
		elseif ($role == 1) { $data = 'Super Admin'; $color = 'danger'; } 
		elseif ($role == 2) { $data = 'Level 2 Admin'; $color = 'warning'; } 
			if($option=='color'){ return $color; exit;  }
			else {  return $data; exit; }
	}
//------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------- Process the status of a user 
	/*
	 * This is will help to tell the condition of a user where ACTIVE OR INACTIVE
	 * NOTE: This color work well only with BOOSTRAP
	*/	
	public static function process_user_account_status($status,$option = '') {
		if ($status == 0) { $data = 'Inactive'; $color = 'danger'; $msg = 'Account is Inactive'; } 
		elseif ($status == 1) { $data = 'Active'; $color = 'success'; $msg = 'Account is active'; } 
	if($option=='color'){ return $color; exit;  }
	elseif($option=='message'){ return $msg; exit;  }
		else {  return $data; exit; }
	}
	//------------------------------------------------------------------------------------------------------------


	
//---------------------------------------------------------------------------------- LOG FUNCTIONS 
	
	/* The Log functons are use to record the activities performed of users of the website
	 * This make traceability of activities possible on the platform

	 * 1. Save the login activity of a user in the log table 								|-- log_login($email)
	 * 2. Save the login failed activity of a user in the log table							|-- log_login_failed($email,$url)
	 * 3. Save the logout activity of a user in the log table								|-- log_logout($email)
	 * 4. Save the password change  activity of a user in the log table						|-- log_pwchange($email,$by)
	 * 5. Save the email change activity of a user in the log table							|-- log_email_change($oldemail,$newemail,$by)
	 * 6. Save the admin_role_change activity of an admin in the log table					|-- log_admin_role_change($email,$by,$oldrole,$newrole) 
	 * 6. Save the log activity of in the log table											|-- loglog($type,$msg)
	

	* NOTE: The Logs are save in the Log table and should only be accessible, viewed and analyzed in the admin dashboard
			You can add more logs following the pattern used, but has to be documented
	*/	
	public static function log_login($email){ 
	 dbi::log('Log in', $email.' login to the system');
	}
	public static function log_login_failed($email,$url){ 
	 dbi::log('Failed login attempt', $email.' tried to login to the system from '.$url.' with wrong credentials');
	}
	public static function log_logout($email){ 
	 dbi::log('Log out', $email.' log out of the system');
	}
	public static function log_pwchange($email,$by){ 
	 dbi::log('Password Change', $email.' changed password by '.$by);
	}
	public static function log_email_change($oldemail,$newemail,$by){ 
	 dbi::log('Login Email Change', $oldemail.' changed login email to '.$newemail.'  by '.$by);
	}
	public static function log_admin_role_change($email,$by,$oldrole,$newrole){ 
	 dbi::log('Admin Role Changed', $email.' admin role was changed from level '.$oldrole.' to level '.$newrole.' by '.$by);
	}
	public static function log($type,$msg){ 
	 dbi::log($type, $msg);
	}
//------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------- GENERAL FUNCTIONS 
	
	/* The General functons are use multiple places in the plaform
	 * This function are very robust in handling almost all processes in a platform

	 * 1. Display the users information using on the field provided 						|-- display_user($email)
	 * 2. Save the login failed activity of a user in the log table							|-- log_login_failed($email,$url)
	 * 3. Save the logout activity of a user in the log table								|-- log_logout($email)
	 * 4. Save the password change  activity of a user in the log table						|-- log_pwchange($email,$by)
	 * 5. Save the email change activity of a user in the log table							|-- log_email_change($oldemail,$newemail,$by)
	 * 6. Save the admin_role_change activity of an admin in the log table					|-- log_admin_role_change($email,$by,$oldrole,$newrole) 
	 * 6. Save the log activity of in the log table											|-- loglog($type,$msg)
	

	* NOTE: The Logs are save in the Log table and should only be accessible, viewed and analyzed in the admin dashboard
			You can add more logs following the pattern used, but has to be documented
	*/	
//---------------------------------------------------------------------------------- Display the users information using the field provided 
	public static function display_user($col) { 
		$info=cf::selany($col,'users','id',$_SESSION['user']);
		echo $info;
	}

//---------------------------------------------------------------------------------- Display the admin information using the field provided 
	public static function display_admin($col) { 
		$info=cf::selany($col,'users','id',$_SESSION['admin']);
		echo $info;
	}	
 
//---------------------------------------------------------------------------------- Return  the users information using the field provided 
	public static function select_user($col) { 
		$info=cf::selany($col,'users','id',$_SESSION['user']);
		return $info;
	}	

//---------------------------------------------------------------------------------- Return  the Admin information using the field provided 
	public static function select_admin($col) { 
		$info=cf::selany($col,'users','id',$_SESSION['admin']);
		return $info;
	}		


 //---------------------------------------------------------------------------------- Return  the Total num of record in a Table 
	public static function countall($col,$table) { $db=config::dbcon();
	 $stmt = $db->query("SELECT ".$col." FROM ".$table."");
	 $row_count = $stmt->rowCount();
	 return $row_count;
	}

//---------------------------------------------------------------------------------- Return  the Total num of record in a Table using the field provided 
	public static function countrow($col,$table,$where,$val) { $db=config::dbcon();
	 $stmt = $db->query("SELECT ".$col." FROM ".$table." WHERE ".$where."='".$val."'");
	 $row_count = $stmt->rowCount();
	 return $row_count;
	}


	//---------------------------------------------------------------------------------- Return  the Total num of record in a Table using the 2 fields provided 
	public static function countrow_plus($col,$table,$where,$val,$where2,$val2) { $db=config::dbcon();
	 $stmt = $db->query("SELECT ".$col." FROM ".$table." WHERE ".$where."='".$val."' and ".$where2."='".$val2."'");
	 $row_count = $stmt->rowCount();
	 return $row_count;
	}

	//---------------------------------------------------------------------------------- Return  the Total num of record in a Table using the 3 fields provided 
	public static function countrow_plus1($col,$table,$where,$val,$where2,$val2,$where3,$val3) { $db=config::dbcon();
	 $stmt = $db->query("SELECT ".$col." FROM ".$table." WHERE ".$where."='".$val."' and ".$where2."='".$val2."' and ".$where3."='".$val3."'");
	 $row_count = $stmt->rowCount();
	 return $row_count;
	}

	//---------------------------------------------------------------------------------- Return  the Last information available in the provided  field
	public static function selectlast($col,$table,$orderby) { $db=config::dbcon();
	$stmt = $db->query('SELECT '.$col.' FROM '.$table.' ORDER BY '.$orderby.' DESC LIMIT 0,1');
	$row = $stmt->fetchColumn();
	return $row;
	}

	//---------------------------------------------------------------------------------- Return  the Last information available in the provided  field using 1 fied comparison
	public static function selectlastwhere($col,$table,$col2,$val,$orderby) { $db=config::dbcon();
	$stmt = $db->prepare('SELECT '.$col.' FROM '.$table.' WHERE '.$col2.'=:val ORDER BY '.$orderby.' DESC LIMIT 0,1');
	$stmt->execute(array(':val' => $val));
	$row = $stmt->fetchColumn();
	return $row;
	}
	//---------------------------------------------------------------------------------- Return  the Last information available in the provided  field using 2 fied comparison
	public static function selectlastwhereandwhere($col,$table,$col2,$val2,$col3,$val3,$orderby) { $db=config::dbcon();
	$stmt = $db->prepare('SELECT '.$col.' FROM '.$table.' WHERE '.$col2.'=:val2 && '.$col3.'=:val3 ORDER BY '.$orderby.' DESC LIMIT 0,1');
	$stmt->execute(array(':val2' => $val2, ':val3' => $val3));
	$row = $stmt->fetchColumn();
	return $row;
	}



//$stmt = $db->query("SELECT * FROM media WHERE type = 'Music' LIMIT 10");
//while ($media = $stmt->fetch(PDO::FETCH_ASSOC)){

	//---------------------------------------------------------------------------------- Return  the information available in any  provided  table using 1 field comparison
	public static function selany($col,$table,$where,$equals) { $db=config::dbcon();
	 $stmt = $db->prepare("SELECT ".$col." FROM ".$table." WHERE ".$where."=:equals");
	 $stmt->execute(array(':equals' => $equals));
	 $rows = $stmt->fetchColumn();
	 return $rows;
	}

	 
	//---------------------------------------------------------------------------------- Return  the rows available in any  provided  table using 1 field comparison
	//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	public static function selwhile($col,$table,$where,$equals) { $db=config::dbcon();
	 $stmt = $db->prepare("SELECT ".$col." FROM ".$table." WHERE ".$where."=:equals");
	 $stmt->execute(array(':equals' => $equals));
	 return $stmt;
	}


	//---------------------------------------------------------------------------------- Return  the rows available in any  provided  table using 1 field comparison
	//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	public static function selallwhile($col,$table) { $db=config::dbcon();
	 $stmt = $db->prepare("SELECT ".$col." FROM ".$table);
	 $stmt->execute();
	 return $stmt;
	}



//---------------------------------------------------------------------------------- Return  the table list available in database
	/*
			foreach($selfields() as $field){
		    //Print the field name out onto the page.
		    echo $field[0], '<br>';
			}
	*/
	public static function selfields($table_name) {
	 $db=config::dbcon();
	 $stmt = $db->prepare("SHOW COLUMNS FROM ".$table_name);
	 $stmt->execute();
	 $fields = $stmt->fetchAll(PDO::FETCH_NUM);
	 return $fields;
	}

	//---------------------------------------------------------------------------------- Return  the table list available in database
	/*
			foreach($seltables() as $table){
		    //Print the table name out onto the page.
		    echo $table[0], '<br>';
			}
	*/
	public static function seltables($database) {
	 $db=config::dbcon();
	 $stmt = $db->prepare("SHOW TABLES FROM ".$database);
	 $stmt->execute();
	 $tables = $stmt->fetchAll(PDO::FETCH_NUM);
	 return $tables;
	}

	//---------------------------------------------------------------------------------- Return  the table list available in database
	/*
			foreach($seltables() as $table){
		    //Print the table name out onto the page.
		    echo $table[0], '<br>';
			}
	*/
	public static function seldatabase() {
	 $db=config::dbcon();
	 $stmt = $db->prepare("SHOW DATABASES");
	 $stmt->execute();
	 $dataB = $stmt->fetchAll(PDO::FETCH_NUM);
	 return $dataB;
	}






	//---------------------------------------------------------------------------------- Return  the information available in any  provided  table using 2 field comparison
	public static function selany_plus($col,$table,$col2,$val2,$col3,$val3) { $db=config::dbcon();
	$stmt = $db->prepare('SELECT '.$col.' FROM '.$table.' WHERE '.$col2.'=:val2 && '.$col3.'=:val3');
	$stmt->execute(array(':val2' => $val2, ':val3' => $val3));
	$row = $stmt->fetchColumn();
	return $row;
	}	

	//---------------------------------------------------------------------------------- Return  the Addition of field values in a table using 1 field comparison
	public static function select_sum($col,$table,$where,$equals) { $db=config::dbcon();
	 $stmt = $db->prepare("SELECT SUM(".$col.") FROM ".$table." WHERE ".$where."=:equals");
	 $stmt->execute(array(':equals' => $equals));
	 $rows = $stmt->fetchColumn();
	 return $rows;
	}

//---------------------------------------------------------------------------------- Return  the Addition of field values in a table using 1 field comparison
	public static function selany_ltd($col,$table,$where,$equals,$ltd) { $db=config::dbcon();
	 $stmt = $db->prepare("SELECT LEFT(".$col.",".$ltd.") FROM ".$table." WHERE ".$where."=:equals");
	 $stmt->execute(array(':equals' => $equals));
	 $rows = $stmt->fetchColumn();
	 return $rows;
	}

//---------------------------------------------------------------------------------- Update the fields in a table with the data provided using 1 field comparison
	public static function update($table,$set,$val,$where,$place){  $db=config::dbcon();
	 $stmt = $db->prepare("UPDATE ".$table." SET ".$set."=? WHERE ".$where."=?");
	 $stmt->execute(array($val, $place));
	}

	//---------------------------------------------------------------------------------- Update the fields in a table with the data provided using 2 field comparison
	public static function update_plus($table,$set,$val,$where,$place,$where2,$place2){  $db=config::dbcon();
	 $stmt = $db->prepare("UPDATE ".$table." SET ".$set."=? WHERE ".$where."=? && ".$where2."=?");
	 $stmt->execute(array($val, $place, $place2));
	}

	//---------------------------------------------------------------------------------- Update the user table with the data provided using 1 field comparison
	public static function update_profile($set,$val,$user_id = ''){  $db=config::dbcon();
	 if (empty($user_id)) {$id=$_SESSION['user_id'];} else {$id=$user_id;} 
	 $stmt = $db->prepare("UPDATE users SET ".$set."=? WHERE user_id=?");
	 $stmt->execute(array($val, $id));
	}

	//---------------------------------------------------------------------------------- Delete a record from user table  using 1 field cmparison		
	public static function delete($table,$where,$val){  $db=config::dbcon();
	 $stmt = $db->prepare("DELETE FROM ".$table." WHERE ".$where."=:val");
	 $stmt->bindValue(':val', $val, PDO::PARAM_STR);
	 $stmt->execute();
	}

	//---------------------------------------------------------------------------------- Check if a key of a multi-dimensional array exist or not
	public static function keyexist($name,$type) {
		if (array_key_exists($name, $type)) {return true;}
	}


	//---------------------------------------------------------------------------------- Get a random strings of alpha numeric characters
	public static function random_alphanum($size) {
	$alpha_key = '';
	$keys = range('A', 'Z');

	for ($i = 0; $i < 2; $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}

	$length = $size - 2;

	$key = '';
	$keys = range(0, 9);

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}

	return $alpha_key . $key;
}


//---------------------------------------------------------------------------------- Get a random strings of numeric characters
public static function random_num() { 	 $ref=mt_rand(10000000,99999999); }


//---------------------------------------------------------------------------------- Get a unique non-similar random strings of alphnumeric characters
/*  
*  Length of 8 characters is recomended
*/
 public static function empty_value_exists($array) {
  return array_search("", $array) !== false;
  }

//---------------------------------------------------------------------------------- Return after converting timestamp characters to  Date in string form
/*  
*  This is most usefull when timerstamp is saved in the database  and needed to be corverted before display
*/
public static function timestamp_to_date($timestamp) {
	// $datetimeFormat = 'Y-m-d H:i:s';
	$datetimeFormat = 'd-M-Y';
	$date = new \DateTime();
	$date = new \DateTime('now', new \DateTimeZone('Africa/Lagos'));
	$date->setTimestamp($timestamp);
	return $date->format($datetimeFormat); 
  }



//---------------------------------------------------------------------------------- Return after converting timestamp characters to  Date & Time in string form
/*  
*  This is most usefull when timerstamp is saved in the database  and needed to be corverted before display
*/

public static function timestamp_to_datetime($timestamp) {
	$datetimeFormat = 'd-M-Y, H:i:s';
	$date = new \DateTime();
	$date = new \DateTime('now', new \DateTimeZone('Africa/Lagos'));
	$date->setTimestamp($timestamp);
	return $date->format($datetimeFormat); 
  }

//---------------------------------------------------------------------------------- Convertion of months to seconds
public static function months_to_seconds($months) {
  $seconds=$months * 30 * 24 * 60 * 60; return $seconds;
  }

//---------------------------------------------------------------------------------- Convertion of seconds to months
public static function seconds_to_months($seconds) {
  $months=$seconds / 30 / 24 / 60 / 60; return $months;
  }

//---------------------------------------------------------------------------------- Convertion of seconds to words
public static function secondsToWords($seconds)
{
    $ret = "";

    /*** get the days ***/
    $days = intval(intval($seconds) / (3600*24));
    if($days> 0)
    {
        $ret .= "$days days ";
    }

    /*** get the hours ***/
    $hours = (intval($seconds) / 3600) % 24;
    if($hours > 0)
    {
        $ret .= "$hours hours ";
    }

    /*** get the minutes ***/
    $minutes = (intval($seconds) / 60) % 60;
    if($minutes > 0)
    {
        $ret .= "$minutes minutes ";
    }

    /*** get the seconds ***/
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
        $ret .= "$seconds seconds";
    }

    return $ret;
}


//---------------------------------------------------------------------------------- Get username form the email provided, using the @ as the determinant
public static function extract_username($email){
  $substring ='@';
  $firstIndex = stripos($email, $substring);
  $username= substr($email, 0, $firstIndex);
  return $username;
}





//----------------------------------------------------------------------------------INPUT CLEANING FUNCTIONS 
/*
*	These list of functions help to clean up users input, before they save in the database
*	These functions uses REGEX to determine if what was inputed contain needless character and correct the data by replace them with empty string
*	It send back the data after cleaning up
*/
	
	//----------------------------------------------------------------------------------Remove all characters but remain alphabet and numbers

	public static function remove_special_characters($data) {
  	 $data=preg_replace('/[^A-Z.a-z0-9]/', '', $data);
  	 return $data;
	}
	//----------------------------------------------------------------------------------Remove all alphabetic characters
	public static function remove_letters($data) {
  	 $data = preg_replace("/[a-zA-Z]/", "", $data );
  	 return $data;
	}
	//----------------------------------------------------------------------------------Remove all numberic characters
	public static function remove_numbers($data) {
  	 $data = preg_replace('/[0-9]+/', '', $data);
  	 return $data;
	}
	//----------------------------------------------------------------------------------Remove all characters but remain only numbers
	public static function numbers_only($data) {
	 $data = preg_replace("/[^0-9]/", "", $data );
  	 return $data;
	}
	//----------------------------------------------------------------------------------Remove all characters but remain alphabet 
	public static function letters_only($data) {
  	 $data=cf::remove_special_characters($data);
  	 $data=cf::remove_numbers($data);
  	 return $data;
	}
	//----------------------------------------------------------------------------------Allow on string  
	public static function sanitize_string($data) {
	 filter_var($data, FILTER_SANITIZE_STRING);
	 return $data;
	}
	//----------------------------------------------------------------------------------Allow on email 
	public static function sanitize_email($data) {
	 filter_var($data, FILTER_SANITIZE_EMAIL);
	 return $data;
	}	 			

	//----------------------------------------------------------------------------------Remove all dangerous users inputed  characters    
	public static function clean_input($data) {
  	 $data = trim($data);
  	 $data = stripslashes($data);
  	 $data = htmlspecialchars($data);
  	 return $data;
	}

	//----------------------------------------------------------------------------------FUNCTIONS THAT CONTROL SESSIONS
	/*
	*	These list of functions help to interact with the sessions
	*	Set a session or managing the session to meet up to specifications
	*/
	
	//----------------------------------------------------------------------------------Delete a session using the session name provided
	public static function unset_session($name) { 
	 if (isset($_SESSION[''.$name.''])) { unset($_SESSION[''.$name.'']); }
	}

	//----------------------------------------------------------------------------------Create a session for invalide input from users
	public static function set_error_invalid_data() { 
	 $_SESSION['invalid_data'] = "*Error: The details you provided were invalid, please try again.";
	}

	//----------------------------------------------------------------------------------Display an error message saved in session with the session name provided
	public static function show_error($name) { 
	 if (isset($_SESSION[''.$name.''])) {
	 echo ' <span style="color:#F00;"> ' .$_SESSION[''.$name.''].'</span>';
	 unset($_SESSION[''.$name.'']);   }
	}
	//----------------------------------------------------------------------------------Display a Success message saved in session with the session name provided
	public static function show_success($name) { 
	 if (isset($_SESSION[''.$name.''])) {
	 echo ' <span style="color:#29aa33;"> ' .$_SESSION[''.$name.''].'</span>';
	 unset($_SESSION[''.$name.'']);   }
	}	

	//----------------------------------------------------------------------------------Display a message saved in session
	public static function displayinput($name) {
	 if (isset($_SESSION[''.$name.''])) {
	 echo $_SESSION[''.$name.''];
	 unset($_SESSION[''.$name.'']);}
	}

	//----------------------------------------------------------------------------------Display an error  message of empty field saved in session with the name provided
	public static function emptyfield($name) {
	 if (isset($_SESSION[''.$name.''])) {
	 if(empty($_SESSION[''.$name.'']))
		{ echo '<span style="color:#F00;">This field is required</span>';  }
	  }
	 }






//---------------------------------------------------------------------------------- VALIDATION FUNCTIONS 

/* The Validate functions take Type And Value as parameter.
*	This is use to validate if the users entery is correct or in line with some set rules
*	It also elve to easy comfirm or check if inputs in the database is already existing or is not correct with what is expected
* NOTE: More valition options can be included base on the project or application.
*/
	public static function validate($type,$val) {
	 if($type=='name') {
		if (!preg_match("/^[a-zA-Z]*$/",$val) or strlen($val)<'3' or $val=='admin' or $val=='Admin' or $val=='ADMIN' or $val=='site admin' or $val=='Site Admin'  or $val=='site admin')
			{return false;} else  { return true;}
		}
	 if($type=='email') {
		if(!filter_var($val,FILTER_VALIDATE_EMAIL))
		{return false;} else  { return true;}
		}
	 if($type=='newemail') {
		if(cf::countrow('login_email','users','login_email',$val) > 0)
		{return false;} else  { return true;}
		}
	 if($type=='newusername') {
		if(cf::countrow('username','users','username',$val) > 0)
		{return false;} else  { return true;}
		}
	 if($type=='reff_exist') {
		if(cf::countrow('user_ref','users','user_ref',$val) > 0)
		{return true;} else  { return false;}
			}
	 if($type=='passwd') {
		if(strlen($val)>5)
		{return true; } else  { return false; }
		}
	 if($type=='usernamelen') {
		if(strlen($val)<6)
		{return false;} else  { return true;}
		}
	 }
	public static function expired($first,$second,$limit) {
		$diff=$first - $second;
		if ($diff > $limit) { return true;}
	}






/*
CHANGE TEXT TO LOWER CASE AFTER
------------------------------------------------------------------------*/
public static function  sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}


/*
GENERATE A UNIQUE CODE DAT CAN NOT BE AVAILABLE AGAIN ON THE PLATFORM (9 or > length is the best)
-----------------------------------------------------------------------*/
//---------------------------------------------------------------------------------- Get a unique non-similar random strings of alphnumeric characters
/*  
*  Least length of 8 characters is recomended
*/

public static function  get_unique_code($length = ""){
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}




/*
GENERATE HASH [AN ENCRYPTED STRING] (mostly for passwords)
-----------------------------------------------------------------------*/
public static function  generate_hash($plainText, $salt = null)
{
	if ($salt === null)
	{
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	}
	else
	{
		$salt = substr($salt, 0, 25);
	}

	return $salt . sha1($salt . $plainText);
}



/*
CONVERT STRING THAT HAS A LINK IN TO AN ACHORED STRING K (Working for --> [https://] [http://] [www.] )
---------------------------------------------------------------------------------------------------------------*/
public static function  text_achor($textorigen){
$reg_exUrl = "/(^|\A|\s)((http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?)/";
    if(preg_match($reg_exUrl, $textorigen, $url)) {

	   // make the urls hyper links
	   $text_result=preg_replace( $reg_exUrl, "$1<a href='$2' target='_blank'>$2</a> ", $textorigen );
	} else {

	   // if no urls in the text just return the text
	    $text_result=$textorigen;
	}

		$reg_exUrl = "/(^|\A|\s)((www\.)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?)/";
	if(preg_match($reg_exUrl, $text_result, $url)) {

	   // make the urls hyper links
	   $text_result=preg_replace( $reg_exUrl, "$1<a href='http://$2' target='_blank'>$2</a>", $text_result );
	}
			return $text_result;
}



/*
DECODE THE HTML-SPECIAL-STRING IN TO NORMAL STRING
-----------------------------------------------------------------------*/
public static function  special_string($string){
 $string = htmlspecialchars_decode($string);
 $string = text_achor($string);
 return $string;
}




public static function save_image($temp,$location,$filename,$type){
 $check = getimagesize($temp);

    if($check !== false) {
				if($temp && $location && $filename && $type ){

						if(($type=="image/jpeg") || ($type=="image/jpg") || ($type=="image/bmp")|| ($type=="image/png")){
						if (file_exists($location)){
						}else{mkdir($location,0777, true);
						}

						if($type=="image/jpeg"){
							$filename = $filename .".jpeg";
						}

						if($type=="image/jpg"){
							$filename = $filename .".jpg";
						}

						if($type=="image/bmp"){
							$filename = $filename .".bmp";
						}
						if($type=="image/png"){
							$filename = $filename .".png";
						}
							move_uploaded_file($temp,$filename);
							return $filename;
					}
				}
		}else{
			return "";
		}
}





/*
GET THE PICTURE ID USING MEMBER_ID
-----------------------------------------------------------------------*/
 public static function get_pic_id($memberID,$connectDB){
		$sql = "select id from picture_table where member_id = '$memberID'";
		if ($result=mysqli_query($connectDB,$sql)or die(mysqli_error($connectDB))){
			while($row= mysqli_fetch_array($result, MYSQL_ASSOC)){
				$id= $row['id'];
				 break;
			}
		}
		if(!empty($id)){
				return $id;
		}else{
		}
}


/*
GET THE PICTURE DIR USING MEMBER_ID
-----------------------------------------------------------------------*/
 public static function get_pic_dir($memberID,$connectDB){

			$sql = "select pic_dir from picture_table where member_id = '$memberID' ";
		if ($result=mysqli_query($connectDB,$sql)or die(mysqli_error($connectDB))){
			while($row= mysqli_fetch_array($result, MYSQL_ASSOC)){
				$pic_dir= $row['pic_dir'];
				 break;
			}
		}
		if(!empty($pic_dir)){
				return $pic_dir;
		}else{
		}
}





/*
GET THE LIST OF AVAILABLE PICTURE OF USERS IN ARRAY USING MEMBER_ID
-----------------------------------------------------------------------*/
public static function get_pic_arr($member_id,$connectDB){
$pic_dir='';
		$sql = "select pic_dir from picture_table where member_id = '$member_id' ";
		if ($result=mysqli_query($connectDB,$sql)or die(mysqli_error($connectDB))){
			while($row= mysqli_fetch_array($result, MYSQL_ASSOC)){
				$pic_dir[]= $row['pic_dir'];

			}
		}

		if(!empty($pic_dir)){
				return $pic_dir;
		}else{
		}
}








//																											[ VIDEO ]
/*
SAVE VIDEO FILE (Parameter)
-----------------------------------------------------------------------*/
public static function save_video($temp,$location,$filename,$type){


				if($temp && $location && $filename && $type ){

					if($type=="video/mp4"){
						if (file_exists($location)){
						}else{mkdir($location,0777, true);
						}

							$filename = $filename .".mp4";

							move_uploaded_file($temp,$filename);
							return $filename;
					}else{
						return "";
					}
				}else{
					return "";
				}

}



/*
GET THE VIDEO DIR USING MEMBER_ID
-----------------------------------------------------------------------*/
 public static function get_vid_dir($memberID,$connectDB){

		$sql = "select * from video_table  where member_id = '". $memberID ."'";
		 if ($resultd=mysqli_query($connectDB,$sql)or die(mysqli_error($connectDB))){
		      while($rowd= mysqli_fetch_array($resultd, MYSQL_ASSOC)){
		          $vid_dir = $rowd['vid_dir'];
		          break;
		       }
		 }


		if(!empty($vid_dir)){
				return $vid_dir;
		}else{
		}
}







//																									[ JAVASCRIPT CODE ]




/*
REDIRECT TO A PARTICULTER LOCATION OR FILE , USE TIME DELAY IF NEEDED
-----------------------------------------------------------------------*/
public static function mobi_redirect($filename,$timer=0) {
		if($timer ==0){
		        echo '<script type="text/javascript">';
		        echo 'window.location.href="'.$filename.'";';
		        echo '</script>';
		 }else{
		 		echo '<script type="text/javascript">

		 		setTimeout(function(){
			 		';
		        echo 'window.location.href="'.$filename.'";';
		        echo '
				},'.$timer.');

		        </script>';
		 }

        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0; url='.$filename.'" />';
        echo '</noscript>';

}


/*
ALERT A STRING TEXT WITH JAVASCRIPT METHOD
-----------------------------------------------------------------------*/
public static function php_alert($string) {
         echo '<script type="text/javascript">';
        echo 'alert("'.$string.'");';
        echo '</script>';
}

//	


/*
CONVERT NUMBER TO INTERNATIONAL NUMBER
-----------------------------------------------------------------------*/

  public static function create_internation_number($value='',$prefix ='234')
     {  
      $val= substr($value,0,1);

        if($val=='0'){
          $limit = strlen($value) -1;
          $value =  $prefix.substr($value,1, $limit);
           return $value;
        }else if($val=='+'){
 		  $limit = strlen($value) -1;
          $value =  substr($value,1, $limit);
           return $value;
        }else{
        	return $value;
        }
     }

//																											[ EMAIL ]

/*
GET MEMBER PROFILE IMAGE LINK
-----------------------------------------------------------------------*/
public static function get_member_image($member_id){
  $sql = "SELECT * FROM property_users WHERE member_id='$member_id'";
  $con=mysqli_connect(DB_SERVER,DBASE_USER,DBASE_PASS,DBASE_NAME);
  $result= mysqli_query($con, $sql);
  $agents= mysqli_fetch_array($result);
	if (empty($agents['propic'])) { 
			if (empty($agents['fb_img'])){
			$image = 'http://'.SITE_NAME.'/images/user9p.png'; }
			else { $image = $agents['fb_img']; }
		} 
	else { $image = "http://".SITE_NAME."/".$agents['propic'];  } 
	return $image; 
}


/*
INITIATE A TEXT MESSAGE
------------------------------------------------------------------------
Using the sms gateway of smartsmssolutions,
darolls IT resolve to use this function to send message to users*/
public static	function initiate_sms($message,$recipients){
		$sms_sender="Darolls Default";
		$sms_username="";
		$sms_password="";

		$sms_array = array (
		 'username' => $sms_username,
		 'password' => $sms_password,
		 'message' => $message,
		 'sender' => $sms_sender,
		 'recipient' => $recipients
		 );
			return $sms_array;
	}
/*	For this function to work, the  [sms_sender] [sms_username] [sms_password]
 parameters has to be set.
----------------------------------------------------------------------*/


/*
SEND A TEXT MESSAGE [ A GENERATED ARRAY FROM (initiate_sms function)]
-----------------------------------------------------------------
	The array generated can be passed for posting here
	E.G $post_sms = sendsms_post($initial_sms("The Message","080-0-0-0-0"));*/
public static function sendsms_post (array $params) {
$url = "https://api.smartsmssolutions.com/smsapi.php";
 $params = http_build_query($params);
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
 $output=curl_exec($ch);
 curl_close($ch);
 return $output;
}/*
$post_sms is either [1 /  0] meaning  [Delivered/Not Delivered]
Read documentation at [smartsmssolutions.com]
----------------------------------------------------------------*/


/*
SEND MOBILE PHONE SMS
-----------------------------------------------------------------------*/
public static function send_phone_msg($name,$phone,$message){
		try{
			$message = $name."\n".$message;
			$send_msg= initiate_sms($message,$phone);
			$post_sms = sendsms_post($send_msg);

					if(!empty($post_sms)){
						return 1;
					}else{
						return 0;
					}

		}catch (Exception $e){return 0;}
}



/*
CHECK IF ONLINE CONNECTION IS SECURE
NOTE: If not secure it can be redirect with the HTTPS included
-----------------------------------------------------------------------*/
public static function is_secure()
{
    if (
        ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        || ( ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
        || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
    ) {
        return true;
    } else {
        return false;
    }

}



public static function sql_detect($data){
		$sql = array(
		"DROP DATABASE",
		"ALTER TABLE",
		"TRUNCATE TABLE",
		"DELETE FROM",
		"INSERT INTO",
		"DROP TABLE",
		"CREATE TABLE"
		);

		$str  = strtoupper($data);
		$count = count($sql);
		$b="";

		for ($i=0; $i < $count; $i++) {
			$pos = strpos($str, $sql[$i]);
			if ($pos === false) {
				$b= FALSE;
			}else{
				$b= TRUE;
			 	break;
			}
		}

		if ($b == false) {
			return FALSE;
		}else{
		 	return TRUE;
		}
}

public static function sql_offence($data){
				$data = escape_data($data);
				$data = str_replace(" ", "_", $data);
				$data = "__".$data."__";
				return $data;
}




/*
ALERT US IN CASE OF ANY ATTACK [NOTIFICATION SENT TO OUR EMAILS AND PHONE NUMBER]
-----------------------------------------------------------------------*/
public static function attack_detect($offence,$mem_id){
		$con=mysqli_connect(DB_SERVER,DBASE_USER,DBASE_PASS,DBASE_NAME);
		 $ip_info = escape_data(get_ip_info());
		  $offence = escape_data($offence);
		 if(empty($mem_id)){
		 	$mem_id = "UN-KNOWN";
		 }

		$sql = " insert into db_offence_tb (ip_address ,date_time ,ip_info,offence,user_id) values ('".get_client_ip()."','". date("F j, Y, D, h:i a")."','".$ip_info."','$offence','$mem_id')";
		mysqli_query($con,$sql);

			$subject = 'THREAT ALERT';

			$email = "dangeorge35@gmail.com" ;
			//-----
		   	$from = "admin@".SITE_NAME;
		   	//-----

		   	$Server ="";
		    $headers = "From: $Server <".$from.">\n";
		    $headers .= "Reply-To: $Server <".$from.">\n";
		    $headers .= "Return-Path: $Server <".$from.">\n";
		    $headers .= "MIME-Version: 1.0\n";
    		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

    		$message = msg_html("<h2>$offence<h2> </br>" . get_ip_info());

   			mail($email, $subject, $message, $headers);

}



public static function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($source_url);

    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($source_url);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($source_url);

    		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}
    //$filename = compress_image($temp, $filename, 30);



//																											[ FORM INPUTED STRING ]

/*
EXTRACT THE CONTENT OF A ZIP FILE TO A SPECIFIED DIRECTORY
-----------------------------------------------------------------------*/
public static function extract_zip($file_dir,$extract_to)
    {
        $zip = new ZipArchive;
        $result = $zip->open($file_dir);
        if ($result === TRUE) {
            $zip->extractTo($extract_to);
            $zip->close();
        }
    }


}
?>
