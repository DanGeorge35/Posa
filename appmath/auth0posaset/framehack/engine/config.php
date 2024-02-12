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
                                       

* Main Configuration File
* All global definations are done here. Database connection is also initialised
*/

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
define('SITE_NAME', 'MonsterHack');             // example site
define('SITE_EMAIL', 'info@monster');           // info@example.com
define('SITE_URL', 'monster.com');               // example.com  { CAUTION !!!- Please, Dont add https:// OR http:// }
define('SUPER_ADMIN_EMAIL', 'it@monster.com');   // it@example.com
//------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------- sending email variables
//define('MAIL_SEND_SERVER', 'maselly.com');
//define('MAIL_FROM', 'info@maselly.com');
//------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------- Configuration for: Database
/* This is the place where database credentials, database type etc is defined.*/
define('DB_TYPE', 'mysql');
define('DB_HOST', $_SESSION['DB_HOST']);
define('DB_NAME', $_SESSION['DB_NAME']);
define('DB_USER', $_SESSION['DB_USER']);
define('DB_PASS', $_SESSION['DB_PASS']);
define('DB_CHARSET', 'utf8');
//------------------------------------------------------------------------------------------------------------


//-------------------------------------------------------------- Function that instantiate database connection
class config {
public static function dbcon() {
$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
return $db;
}
}
//------------------------------------------------------------------------------------------------------------



//------------------------------------------------------------------------------ GET USER IP ADDRESS  FUNCTION
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
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------GET USER IP ADDRESS CALL FUNCTION
define('USER_IP', getUserIP());
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include the database insert model
    include('db_insert.php');
//----------------------------------------------------------------------------------------------



//-------------------------------------------------------------include core functions
    include('core_functions.php');
//----------------------------------------------------------------------------------------------

 

//-------------------------------------------------------------put database connection in var $db
    $db=config::dbcon();
//----------------------------------------------------------------------------------------------

 
?>
