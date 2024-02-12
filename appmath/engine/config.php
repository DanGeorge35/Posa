<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

 //---------------------------------------------------------------------------------- set default time zone
date_default_timezone_set('Africa/Lagos');
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Here we get the current url 
define('URL', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------- Other default definations
define('SITE_NAME', 'posa');             // example site
define('SITE_EMAIL', 'hello@posa.net');           // info@example.com
define('SITE_URL', 'https://posa.net');               // example.com  { CAUTION !!!- Please, Dont add https:// OR http:// }
define('SUPER_ADMIN_EMAIL', 'admin@posa.net');   // it@example.com
//------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------- sending email variables
define('MAIL_SEND_SERVER', 'posa.net');
define('MAIL_FROM', 'hello@posa.net');
//------------------------------------------------------------------------------------------------------------

if($_SERVER["HTTP_HOST"] =="localhost"){

  //---------------------------------------------------------------------------------- Configuration for: Database
  /* This is the place where database credentials, database type etc is defined.*/
  define('DB_TYPE', 'mysql');
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'darorxkn_posa');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_CHARSET', 'utf8');
  //------------------------------------------------------------------------------------------------------------

}else{
  //---------------------------------------------------------------------------------- Configuration for: Database
  /* This is the place where database credentials, database type etc is defined.*/
  define('DB_TYPE', 'mysql');
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'poxxycountant_posa');
  define('DB_USER', 'poxxycountant_posa');
  define('DB_PASS', 'poxxycountant_posa001?@');
  define('DB_CHARSET', 'utf8');
  //------------------------------------------------------------------------------------------------------------
}
//DB_HOST,DBASE_USER,DBASE_PASS,DBASE_NAME)


//------------------------------------------------------------------Function that instantiate database connection
class config {
public static function dbcon() {
$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
return $db;
}
}
//------------------------------------------------------------------------------------------------------------



//------------------------------------------------------------------GET USER IP ADDRESS  FUNCTION
// Get real visitor IP behind CloudFlare network
function getUserIP()
{
    
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
//--------------------------------------------------------------------------------------------



//-------------------------------------------------------------GET USER IP ADDRESS CALL FUNCTION
define('USER_IP', getUserIP());
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include the database insert model
  include('db_insert.php');
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include core functions
  include('core_functions.php');
//----------------------------------------------------------------------------------------------


//-------------------------------------------------------------include core functions
  include('imaging.php');
//----------------------------------------------------------------------------------------------

//-------------------------------------------------------------include Send mail functions
    include('send_mail.php');
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include Country And State Location functions
    include('location.php');
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include core functions
    include('site_functions.php');
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------put database connection in var $db
  $db=config::dbcon();
//----------------------------------------------------------------------------------------------






  if(!empty($_SESSION['member_id'])){
      $login_id = $_SESSION['member_id'];
      $login_stmt = $db->query("SELECT * FROM property_users WHERE member_id='$login_id'");
      $login_user = $login_stmt->fetch(PDO::FETCH_ASSOC);


  }

  if(!empty($_GET['redirect'])){
      $_SESSION['redirect'] =$_GET['redirect'];
  }


  define('authorize_access', 'success');




    
 ?>