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
	$pageTitle= "Insert Code";
	include('./inc/header.php'); 
?>
                   

                <!-- Start content -->
                <div class="content">

                
            <?php  include('./inc/top_bar.php');  ?>
<br><br><br><br>
                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                             
            

                            <div class="row">
                                
            
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body" contenteditable="true" style="text-overflow: scroll;">
                      <button class="btn btn-sm btn-success float-right "  style="display: none" id="btn_copy" onclick="copytext(document.getElementById('code').innerHTML,'btn_copy');">Copy <i></span></button>

                      <code id='code'>                 
<?php 

echo "
    <br>
      <br>  
      <div style='padding-left:50px'>
      class dbi {
        <div style='padding-left:50px'>";

$tables = cf::seltables(DB_NAME);
        foreach($tables as $table){

        $fields = cf::selfields($table[0]);


echo "


<br><br>
     public static function ".$table[0]."( ";
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
         &nbsp&nbsp&nbsp&nbsp $"."stmt = $"."db->prepare('INSERT INTO ".$table[0]."(";

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
echo "// dbi::".$table[0]."(";
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
echo');';
}
 
echo "
<br><br>
<br><br>
</div>
}

<br><br>
<br></div>

";

?>

   

</code>
            
                                        </div>
                                    </div> <br> <br>
                                </div>
                                <!-- end col -->
           
                             
                            </div>
                            <!-- end row -->
             

                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->


<script type="text/javascript">
    
function copytext(text,wall){
    
    var doc = new DOMParser().parseFromString(text, 'text/html');
    text = doc.body.textContent;

  var id = "mycustom-clipboard-textarea-hidden-id";
  var existsTextarea = document.getElementById(id);

  if(!existsTextarea){
        console.log("Creating textarea");
        var textarea = document.createElement("textarea");
        textarea.id = id;
        textarea.style.position = 'fixed';
        textarea.style.top = 0;
        textarea.style.left = 0;
        textarea.style.width = '1px';
        textarea.style.height = '1px';
        textarea.style.border = 'none';
        textarea.style.outline = 'none';
        textarea.style.boxShadow = 'none';
        textarea.style.background = 'transparent';
        document.querySelector("body").appendChild(textarea);
        existsTextarea = document.getElementById(id);
    }else{
        console.log("The textarea already exists :3")
    }
    existsTextarea.value = text;
    existsTextarea.select();

  try {
    var successful = document.execCommand('copy');
      var msg = successful ? "Copied!" : "Can't Copy!";
      document.getElementById(wall).innerHTML= msg;
    } catch (err) {
      document.getElementById(wall).innerHTML= 'Oops, unable to copy';
  }
}


function executeCopy2(html) {
    var doc = new DOMParser().parseFromString(html, 'text/html');
    var text = doc.body.textContent;
    return executeCopy(text);
}
</script>
<?php include('./inc/footer.php');  ?>