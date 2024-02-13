<?php 
    include('../engine/config.php');

    if(!empty($admin_user)){
        cf::mobi_redirect('./dashboard');
    }
 

    // process login form
    if(isset($_POST['do_login'])) {
        $login_email=strtolower(cf::clean_input(cf::sanitize_email($_POST['login_email'])));    
    // validate inputs
        if (empty($login_email) or empty($_POST['login_password'])) {
         cf::set_error_invalid_data(); 
        }elseif (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
         cf::set_error_invalid_data(); 
        }else{

            if(cf::auth_admin($login_email,$_POST['login_password'])){
                    // die($_POST['login_password']);
                    if (empty($redirect)){
                         cf::login_admin($login_email,'dashboard.php'); 
                    }else { 
                        cf::login_admin($login_email, $redirect); 
                    }
            }else{        
                    // die("Fail login");
                 $_SESSION['failed_login'] = "*Invalid Login - Email or password incorrect. <br> Note: every login attempt is recorded."; 
            }
        }
    } 




    $pageTitle='login';
    include('./inc/header.php');
?>
<body>

<!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
<!-- [ Preloader ] End -->


<!-- [ Content ] Start -->
<div class="authentication-wrapper authentication-1 px-4 bg-dark">
 
        <div class="authentication-inner py-5">
 
                <div class="">

                    <!-- [ Logo ] Start -->
                    <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                         <div class="">
                            <div class="">
                                <img src="../images/logo.png" alt="Brand Logo" style="height: 30px">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Logo ] End -->

                    <h5 class="text-center text-muted font-weight-normal mb-4">Login to Your Account</h5>

                    <!-- Form -->
                    <form action="" method="post">
                
                        <div class="p-2 text-center bg-success text-white text-center   mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="login_success" ></div>
                        <div class="p-2  text-center bg-danger text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="login_error"></div>
                        <div class="p-2  text-center bg-warning text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="login_warning"></div>



                        <div class="form-group">
                            <label class="form-label text-white">Email</label>
                            <input type="text" class="form-control pl-3 pr-3 y"  name="login_email" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-white d-flex justify-content-between align-items-end">
                                <span>Password</span>
                               
                            </label>
                            <input type="password" class="form-control pl-3 pr-3 " name="login_password"required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center m-0">
                           
                            <button type="submit" class="btn btn-primary btn-block" type="submit" name="do_login" >Sign In</button>


                        </div>
                    </form>
                     <br>
                            <center> <a href="forget_password" class="d-block small text-primary">Forgot password?</a></center>
                    <!-- [ Form ] End -->

                </div>
               
          

        </div>
    </div>
<!--  Content -->

<style type="text/css">
.form-control:focus {
    color: #212529;
    background-color: #fff;

}
</style>

<!-- Core scripts -->
        <script src="template/assets/js/pace.js"></script>
        <script src="template/assets/js/jquery-3.3.1.min.js"></script>
        <script src="template/assets/libs/popper/popper.js"></script>
        <script src="template/assets/js/bootstrap.js"></script>
        <script src="template/assets/js/sidenav.js"></script>
        <script src="template/assets/js/layout-helpers.js"></script>
        <script src="template/assets/js/material-ripple.js"></script>
<!-- Core scripts -->


<!-- Libs -->
    <script src="template/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<!-- Demo -->
    <script src="template/assets/js/demo.js"></script>
    <script src="template/assets/js/analytics.js"></script>

<!-- Demo -->    
    <?php include('app_js.php'); ?>

</body>

</html>
