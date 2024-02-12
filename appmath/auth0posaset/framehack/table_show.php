<?php
    if (session_status() == PHP_SESSION_NONE) {
                session_start();
}

        if(empty($_SESSION['DB_HOST'])){
             include_once('engine/config.php'); 
             cf::mobi_redirect("index.php");
            die();
        }
        
include_once('engine/config.php'); 

if(empty($_GET['tb'])){
    cf::mobi_redirect("dashboard.php");
    die();
}else{
    $data_table = $_GET['tb'];
    $fields = cf::selfields($data_table);
}

// INCLUDE CONFIG FILE 
	// NOTE: config file already contains the major function files, so no need to include them individually on each page. except if you have some specific functions for this page alone, in that case, create a new functions file according to the guidelines in the engine folder and include the file after including the config file below.
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
	$pageTitle= $data_table;;
	include('./inc/header.php'); 
?>
                   

                <!-- Start content -->
                <div class="content">

                
            <?php  include('./inc/top_bar.php');  ?>
<br><br><br><br>
                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                             
            

                            <div class="row">
                                
            
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title mb-4"><?php echo $data_table; ?> Table</h4>
                                            <ol class="activity-feed mb-0">
                                                <?php
                                                    $count = 0;
                                                     foreach($fields as $field){
                                                        $count  = $count  +1;
                                                                //Print the field name out onto the page.
                                                                echo ' <li class="feed-item">
                                                    <div class="feed-item-list">
                                                        
                                                        <span class="activity-text">
                                                        '.$field[0].'
                                                        </span>
                                                    </div>
                                                </li>';
                                                               
                                                                
                                                    }
                                                ?>
                                               
                                            </ol>
            
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
            
                       
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <code>
                                            <h4 class="mt-0 header-title mb-4"> <?php echo $data_table; ?> Codes </h4>
                                                 <?php
                                                     $count=1;
                                            
                                        echo "-------------------VARIABLE CODE------------------- <br>";
                                                       echo "extract($" . "_POST); <br>" ;
                                                    foreach($fields as $field){                                                     
                                                        echo "if(!empty($". $field[0] . ")){ $" . $field[0] . " = cf::clean_input($". $field[0] . "); }else{ $" . $field[0] . " ='';} <br> ";
                                                        
                                                    }
                                    echo "---------------------------------------------------- <br><br><br>";







                                     echo "-----------------INSERT CODE----------------------- <br>";

 

echo "
     public static function ".$data_table."( ";
        $count=1;

        foreach($fields as $field){
            if($field[0]=='id'){
                        continue;
            }
            if($count==1){
                    echo "$".$field[0];
            }else{
                echo ", $".$field[0];
            }
            $count=$count+1;
        }

echo "){ <br> &nbsp&nbsp&nbsp&nbsp $"."db=config::dbcon();<br>
         &nbsp&nbsp&nbsp&nbsp $"."stmt = $"."db->prepare('INSERT INTO ".$data_table."(";

        $count=1;
        foreach($fields as $field){
            if($field[0]=='id'){
                        continue;
            }
            if($count==1){
                        echo "`".$field[0]."`";
            }else{
                echo ","."`".$field[0]."`";
            }
           
           $count=$count+1;
        }
   $count=1;
         

    echo") VALUES(";

   
       $count=1;
        foreach($fields as $field){
            if($field[0]=='id'){
                        continue;
            }
            if($count==1){
                echo "?";
            }else{
                echo ","."?";
            }
           
           $count=$count+1;
        }
   $count=1;
echo")'); <br>";

echo"&nbsp&nbsp&nbsp&nbsp $"."stmt->execute(array(";

       $count=1;
        foreach($fields as $field){
            if($field[0]=='id'){
                        continue;
            }
            if($count==1){
                echo "$".$field[0];
            }else{
                echo ","."$".$field[0];
            }
           
           $count=$count+1;
        }
   $count=1;
echo"));
<br>
        }

<br>
";
 echo "---------------------------------------------------- <br>";
echo "//EXAMPLE// dbi::".$data_table."(";
 $count=1;

        foreach($fields as $field){
            if($field[0]=='id'){
                        continue;
            }
            if($count==1){
                    echo "$".$field[0];
            }else{
                echo ", $".$field[0];
            }
            $count=$count+1;
        }
echo'); <br><br><br>';




                                   



                                     echo "-----------------UPDATE CODE----------------------- <br>";

                                                    foreach($fields as $field){
                                                        if($field[0]=='id'){
                                                                    continue;
                                                        }
                                                       echo "cf::update('". $data_table."','".$field[0]."',$".$field[0].",'id',$"."id); <br>";
                                                           
                                                    }
                                    echo "---------------------------------------------------- <br><br><br>";


                                     echo "-----------------FORM HTML CODE-------------------- <br>";

                                                    foreach($fields as $field){
                                                        if($field[0]=='id'){
                                                                    continue;
                                                        }

                                                        echo "<span><<span>label for='".$field[0]."'>".$field[0]."<span><<span>/label><br>

                                                       <span><<span>input type='text' name='".$field[0]."' class='form-control' id='".$field[0]."'  value='' required=''><br><br>";
                                                           
                                                    }
                                    echo "---------------------------------------------------- <br><br><br>";



                                                ?>

                                            </code>
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>
                           <!-- end row -->

                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

<?php include('./inc/footer.php');  ?>