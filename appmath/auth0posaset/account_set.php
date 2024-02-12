<?php 


    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='account_set';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  



    if(isset($_POST['do_change_pw'])) {
        $currpass=$_POST['current_password']; 
        $newpass=$_POST['new_password'];
        $newpass2=$_POST['new_password2'];
        
        if(!cf::auth_admin($admin_user['login_email'],$currpass)){
             $derror='Your input for current password is incorrect';  
        }elseif($newpass !== $newpass2){
             $derror='Your new passwords do not match';  
        }else{
            $newpass=md5($newpass.$admin_user['login_token']);
            cf::update('admin','login_password',$newpass,'admin_id',$admin_user['admin_id']); 
            $dsuccess='Your Password Was Changed Successfully';
        }
    }

?>


  
                <!-- [ Layout content ] Start -->
   <div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Account Settings </h4>
                      
                        <div class="nav-tabs-top">
                           
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="user-edit-account">

                                    <div class="card-body " style="background-color: #fff2e2">

                                        <div class="media align-items-center">
                                            <div class="i-block " data-clipboard-text="feather icon-user" data-filter="icon-user" data-toggle="tooltip" title="" data-original-title="icon-user"><i class="feather icon-user" style="font-size: 70px;text-shadow: 0px 2px 10px #ddd"></i></div>
                                            <div class="media-body ml-3 ">
                                                <label class="form-label d-block mb-2 h2" style=";text-shadow: 0px 2px 10px #ddd;font-size: 15px"><?php echo $admin_user['username'] . ' ('.$admin_user['login_email']; ?>)</label>
                                    
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="border-light m-0">
                                    <div class="row">
                                   
                                    <div class="col-md-6" style="border-left:1px dashed #ddd">
                                        <div class="card-body pb-2 " >
                                            
                                        <form   name="change_pass"  id="change-pw-form" class="form" method="post">
                                            <div class="p-3" id="ch_pass">
                                                <?php  if(!empty($derror)){ echo  '<div class="bg-danger p-2 rounded text-white"> <span class="pl-2 pr-2 font-weight-bold"> ERROR: </span> '.  $derror . '</div>' ; } ?>
                                                <?php  if(!empty($dsuccess)){ echo  '<div class="bg-success p-2 rounded  text-white"><span class="pl-2 pr-2  font-weight-bold"> SUCCESS: </span> '. $dsuccess. '</div>' ; } ?>
                                            </div>
                                            <br>
                                        <h5 class="mb-4">CHANGE PASSWORD</h5>

                                        <h6  class="text-danger text-center" id="pass_error"></h6>
                                        
                                        <div class="form-group">
                                            <label class="form-label">Your Password</label>
                                            <input type="password" placeholder="Your Password" class="form-control" value="" required name="current_password" autocomplete="off">
                                        </div>
                                        
                                          <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <input type="password" placeholder="New Password" class="form-control" name="new_password" value="" required autocomplete="off">
                                        </div>

                                         <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" placeholder="Confirm Password" class="form-control" name="new_password2" value="" required autocomplete="off">
                                        </div>
                                       
                                       
                                         <div class="text-right mt-3 mb-3">
                                            <button type="submit" class="btn btn-primary" name="do_change_pw">Save changes</button>&nbsp;
                                        </div>

                                    </form>
                                    </div>
                                    
                                     </div>
                                 </div>
                                </div>
                                
                  

                      
                    </div>
                    <!-- [ content ] End -->
 
                </div>

<div class=" w3-display-container text-center pl-4 pr-4 animated fadeIn faster w3-hide " id="save_content" style="z-index: 100000;position: fixed;top: 0;bottom: 0;left: 0;right: 0;background-color: rgb(0 0 0 / 76%);">
  
<div class=" w3-display-middle " style="min-width: 300px">
  <div class="p-3 w3-white" >
        <div class="row ">
                <div class="col-3">
                  <div class="text-center">
                  <div class="spinner-border text-info" role="status" id='spinner_status'>
                  <span class="sr-only">Loading...</span>
                  </div>
                  </div>
              </div>
              <div class="col-9 p-2" id='save_content_text' style="text-align: left;">
                Processing...
              </div>

        </div>
  </div>
</div>
  
</div>



                <style type="text/css">
                    .form-control{
                        background-color: #fff;
                    }
                </style>




<?php include('./inc/dash_footer.php'); ?>

<?php include('./inc/footer.php'); ?>

<?php include('app_js.php'); ?>
 