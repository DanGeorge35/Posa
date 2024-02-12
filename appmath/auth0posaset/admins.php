<?php 


    include('../engine/config.php');
    include('./inc/auth.php');


 
// =================================FORMS PROCESSING CODES END HERE======================================


// INCLUDE HEADER FILE, IF AVAILABLE
    //NOTE: always set the pageTiltle variable before including the header file. the pageTitle variable is required so as to echo each page's unique title into the head section and even in some parts of the body section of the page
// =======================================================================
 

 if(isset($_POST['do_reset_pw'])) {
     $newpass=$_POST['email'];
     $sent_admin_email=$_POST['email'];

      $sent_admin_login_token=cf::selany('login_token','admin','login_email',$sent_admin_email);
      $dpass=$newpass.$sent_admin_login_token;     
      sm::send_admin_pass_reset($newpass,$sent_admin_email); 
      $newpass=md5($dpass);    
      cf::update('admin','login_password',$newpass,'login_email',$sent_admin_email);
      
      echo 'done'; exit;
}


if(isset($_POST['do_delete_admin'])) {
    $email=$_POST['email'];
    cf::delete('admin','login_email',$email);
    // LOG Delete       
    echo 'done'; 
    exit;
}



if(isset($_POST['do_change_role'])) {
    $sent_new_role=$_POST['new_role'];
    $sent_old_role=$_POST['old_role'];
    $sent_admin_email=$_POST['admin_email'];
    cf::update('admin','role',$sent_new_role,'login_email',$sent_admin_email);
    echo 'done'; exit;
}


    $pageTitle='admins';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">


                    <!-- [ content ] Start -->
                    <div class="container-fluid ">
 


         <div class="row">
              <div class="col-sm-12 pt-4 pb-4">
                  <div class="page-title-box">
                      <div class="row align-items-center">
                          <div class="col-md-12  ">
                              <h4 class="page-title m-0">All Admins</h4>
                          </div>
                           <div class="col-md-12 ">
                              <a href="add_admin.php">   <button class="btn bg-primary text-white  rounded pl-4 pr-4 float-right w3-small" > <span class="ti-plus"></span> Add Admin</button> </a>
                          </div>
                          <!-- end col -->
                      </div>
                      <!-- end row -->
                  </div>
                  <!-- end page-title-box -->
              </div>
          </div> 
 



<style type="text/css">
    
        /*.feed-item{
            border-top: 2px solid #172f5f !important;
        }*/

        .cat_seprate{
            
            position: absolute;
            margin-left: 0ex;
            margin-top: -23px;
            height: 24px;
            width:  22px;
            border-left: 2px solid #172f5f;
            border-bottom: 1px solid #3959a2;
        }
</style>
  <div class="row">
    <div class="col-12 p-0">


 
            
<style type="text/css">
        
        .cat_head{
            color: white;
            padding: 6px;
            background-color: #46cd93 ;

        }
        .cat_pan{
            max-height: 300px;
            overflow-y: auto;   
        }

        .cat_list{
            padding: 6px 16px;
            height: auto;
            font-size: 14px;
            font-weight: normal;
            border-radius: 3px;
        }
    
     
</style>

 

  <div > 
 

 
 
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12 p-0">
                        <section class="hk-sec-wrapper">
                        
                                
                                         <div class="table-responsive" >
                                                <table class="table  border table-striped" >
                                               
                                            <thead>
                                                <tr>
                                                    <th><center> Admins</center></th> 
                                                    <th><center> Change Department</center></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // FECTH ADMINS
                                                $stmt = $db->query('SELECT * FROM admin ORDER BY id DESC');
                                                while ($admins = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <tr class="text-center">
                                                    <td><?php echo $admins['login_email']; ?> 
                                                  <br>
                                                  <label class="m-3 ">
                                                  <span class="badge text-white w3-text-white p-1 pl-3 pr-3 bg-<?php echo cf::process_admin_role($admins['role'],'color'); ?>"><?php echo cf::process_admin_role($admins['role']); ?></span>
                                                  </label>
                                                  <div class="">


                                                      <a href="#" onclick="are_you_sure('confirmResetpw','<?php echo $admins['login_email']; ?>')"><button id="do_reset_pw" class="btn btn-sm rounded m-2 w3-green" style="width: 120px" >Reset Password</button></a>

                                                       <?php  if($admins['role'] != 1) {?><a href="#" onclick="are_you_sure('confirmDelete','<?php echo $admins['login_email']; ?>')" class="btn btn-sm rounded m-2 btn-danger"  style="width: 120px"> Delete Account</a><?php } ?>
                                                       </div>

                                                </td>

 
                                                    <td>
                                                      <span>Assign Department</span> <br>
                                                      <span class="ti-angle-down"></span><br>
                                                  


                                                      <?php  if($admins['role'] != 1) {?>
                                                      
                                                      <a href="#" onclick="are_you_sure3('roleChange',2,'<?php echo $admins['login_email']; ?>',<?php echo $admins['role']; ?>)" class="btn btn-sm m-2 btn-secondary" style="width: 120px"> Media Dept.</a><br>

                                                      <a href="#" onclick="are_you_sure3('roleChange',3,'<?php echo $admins['login_email']; ?>',<?php echo $admins['role']; ?>)" class="btn btn-sm m-2 btn-info" style="width: 120px"> Investment Dept.</a><br>

                                                      <a href="#" onclick="are_you_sure3('roleChange',4,'<?php echo $admins['login_email']; ?>',<?php echo $admins['role']; ?>)" class="btn btn-sm m-2 btn-success" style="width: 120px"> Quat. as. Dept.</a><br>

                                                       <a href="#" onclick="are_you_sure3('roleChange',5,'<?php echo $admins['login_email']; ?>',<?php echo $admins['role']; ?>)" class="btn btn-sm m-2 btn-primary" style="width: 120px"> Operation Dept.</a><br>

                                                    <?php } ?>

                                                            </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                               
                          
                        </section>
                    </div>
                </div>
                <!-- /Row -->

            </div>
            <!-- /Container -->

</div>
 </div>

      
</div>                            


<div class="modal  pr-0" id="add_admin" tabindex="-1" role="dialog" aria-labelledby="add_admin" aria-hidden="true">
  <div class="modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
       
      <div class="modal-body w3-text-black pl-4 pr-4" id='add_admin_content'>  
        <h5 class="hk-sec-title">Add a New Admin</h5>
        <br>
    <div class="row">
        <div class="col-sm">
            <form onsubmit="return false;" id="add-admin-form" class="form" method="post">
              <div class="form-group">
                    <label class="control-label mb-10" for="exampleInputEmail_1">Admin Username</label>
                     
                        <input type="username" required class="form-control w3-small" id="exampleInputEmail_1" placeholder="Enter Username" name="username">
                  
                </div>
                <div class="form-group">
                    <label class="control-label mb-10" for="exampleInputEmail_1">Admin Email</label>
                     
                        <input type="email" required class="form-control w3-small" id="exampleInputEmail_1" placeholder="Enter email" name="email">
                  
                </div>
                
                <div class="form-group">
                    <label class="control-label mb-10" for="exampleInputpwd_1">Password</label>
                    
                        <input type="password" required class="form-control w3-small" id="exampleInputpwd_1" name="new_password" placeholder="Type  password">
                    
                </div>
                <div class="form-group">
                    <label class="control-label mb-10" for="exampleInputpwd_2">Password Again</label>
                   
                        <input type="password" required class="form-control w3-small" id="exampleInputpwd_2" placeholder="Confirm Password" name="new_password2">
                 
                </div>
                <center>
                <button type="submit" id="do_add_admin" name="do_change_pw" class="btn btn-primary rounded w3-green btn-block mb-2">Add Admin</button>
                </center>
            </form>
        </div>
    </div>
      </div>
       
    </div>
  </div>
</div>
 
                    <!-- [ content ] End -->

                </div>

 


<?php include('./inc/dash_footer.php'); ?>
<?php include('./inc/footer.php'); ?>
<?php include('app_js.php'); ?>


<style type="text/css">
    body{
        background-color: #fff;
    }
</style>

<script type="text/javascript">


function confirmResetpw(email){
                 $.post("",
                    {
                      do_reset_pw: 'yes',
                      email: email
                    },
                    function(data,status){
                      if (data == 'done') { swal("Done", "Admin password was reset, new password is: "+ email, "success");  setTimeout(location.reload(true), 500);}
                     else { swal("Unknown Error occured", "Password was not modified. You might have been logged out, please refresh this page.", "error");  }
                    });
        
}

    function confirmDelete(email){
  
                $.post("",
                    {
                      do_delete_admin: 'yes',
                      email: email
                    },
                    function(data,status){
                      if (data == 'done') {
                          setTimeout(location.reload(true), 500);
                    }
                     else { 
                        setTimeout(location.reload(true), 500);
                      }
                    });
            
 
}


    function roleChange(newRole,email,oldRole){
                    $.post("",
                    {
                      do_change_role: 'yes',
                      new_role: newRole,
                      old_role: oldRole,
                      admin_email: email
                    },
                    function(data,status){
                      if (data == 'done') { 

                          setTimeout(location.reload(true), 500);
                    }
                     else {
                        setTimeout(location.reload(true), 500); 
                     }
                    });
     
       }
    
$("#add-admin-form").submit(function(){
              $.post("",
                    {
                      do_add_admin: 'yes',
                      new_password: $('input[name="new_password"]').val(),
                      new_password2: $('input[name="new_password2"]').val(),
                      email: $('input[name="email"]').val(),
                      username: $('input[name="username"]').val()
                    },
                    function(data,status){
                      if (data == 'done') { swal("Done", "Admin was added successfully.", "success"); 
                          setTimeout(location.reload(true), 500);
                          }
                      else if (data == 'bademail') { swal("Error", "The email address you entered is invalid", "error"); }
                      else if (data == 'emailinuse') { swal("Error", "The email address you entered is already in use by another admin", "error"); }
                      else if (data == 'nomatch') { swal("Error", "Your new passwords do not match", "error"); }
                     else { swal("Unknown Error occured", "Admin not added. You might have been logged out, please refresh this page.", "error");  }
                    });
  });


 
 </script>
