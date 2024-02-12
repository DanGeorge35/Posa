<?php
    if (session_status() == PHP_SESSION_NONE) {
                session_start();
    }

if(!empty($_POST['server'])){

 

     extract($_POST);
 
     try
      {
          $conn = new PDO('mysql:host='.$server.';dbname='.$db_name.';charset=utf8', $db_user, $db_pass);
          echo "Connecting.....";
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $_SESSION['DB_HOST'] = $server;
          $_SESSION['DB_NAME'] = $db_name;
          $_SESSION['DB_USER'] = $db_user;
          $_SESSION['DB_PASS'] = $db_pass;
          include_once('engine/config.php');
          cf::mobi_redirect("dashboard.php");
          die();
      }
      catch(PDOException $e)
      {
            include_once('engine/config.php'); 
            cf::mobi_redirect("index.php");
            die();
      } 

}



include_once('engine/config.php');


if(!empty($_GET['db'])){
 
    $_SESSION['DB_NAME'] = $_GET['db'];
    cf::mobi_redirect("dashboard.php");
    die();
}
   
// $_SESSION['DB_HOST'] = 'localhost';
// $_SESSION['DB_NAME'] = 'maselly_db';
// $_SESSION['DB_USER'] = 'root';
// $_SESSION['DB_PASS'] = '';









// INCLUDE CONFIG FILE 
	// NOTE: config file already contains the major function files, so no need to include them individually on each page. except if you have some specific functions for this page alone, in that case, create a new functions file according to the guidelines in the engine folder and include the file after including the config file below.
// ======================================================================

    
// INCLUDE AUTHENTICATE FILE 
    // NOTE: This file takes care of login and logout features plus setting logged in user variables
// ======================================================================
 

    

  

// INCLUDE SEND MAIL FUNCTIONS FILE
	// NOTE: mail function file is included on its on, it is not included in config by default. This is because not all pages or files will require the mail functions or sending mail feature 
// =======================================================================
	// include('../engine/send_mail.php');


// FORMS PROCESSING CODES START HERE
	//NOTE: all the php codes to process the forms on this page should be included here 
// ====================================FORMS PROCESSING CODES START HERE===================================
	


// =================================FORMS PROCESSING CODES END HERE======================================


// INCLUDE HEADER FILE, IF AVAILABLE
	//NOTE: always set the pageTiltle variable before including the header file. the pageTitle variable is required so as to echo each page's unique title into the head section and even in some parts of the body section of the page
// =======================================================================
	$pageTitle='Dashboard';
	include('./inc/header.php'); 
?>
                   

                <!-- Start content -->
                <div class="content">

                
            <?php  include('./inc/top_bar.php');  ?>
<br><br><br><br>
                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h4 class="page-title m-0"> <?php echo DB_NAME; ?> </h4>
                                            </div>
                                            
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end page-title-box -->
                                </div>
                            </div> 
                            <!-- end page title -->

                            <div class="row">

<?php 
    $tables = cf::seltables(DB_NAME);
        foreach($tables as $table){
             $fields = cf::selfields($table[0]);

echo'                             <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary mini-stat">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">'.$table[0].'</h6>
                                                <h4 class="mb-3 mt-0 float-right">'. count($fields).'</h4>
                                            </div>
                                            <div>
                                                <a href="table_show.php?tb='.$table[0].'"><span class="badge badge-light text-info"> +'. count($fields).'  <b class="ml-2  text-info">Click here to view</b></span>
                                                </a>
                                            </div>
                                            
                                        </div>
                                        <div class="p-3">
                                            <div class="float-right">
                                                <a href="#" class="text-white-50"><i class="fab fa-cube-outline h5"></i></a>
                                            </div>
                                            <p class="font-14 m-0">Field Count : '. count($fields).'</p>
                                        </div>
                                    </div>
                                </div>';
 } ?>
                               
                            </div>  

                            <br><br>
                            <!-- end row -->
<!-- <textarea class="form-control" style="height: 500px">
<?php
// $myfile = fopen("table_show.php", "r") or die("Unable to open file!");
// echo fread($myfile,filesize("table_show.php"));
// fclose($myfile);

?>
</textarea>   -->     
                            
            
                           
                           <!-- end row -->

                        </div><!-- container fluid -->
<br><br>
                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

<?php include('./inc/footer.php');  ?>