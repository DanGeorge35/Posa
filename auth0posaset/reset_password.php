<?php
    include('../engine/config.php');

     if(!empty($login_user)){
        cf::mobi_redirect('./dashboard');
    }

    $pageTitle='Reset Password';
    include('./inc/header.php');

    if(!empty($_SESSION['user_id'])){
        cf::logout();
    }
   
    if (empty($_GET['dcode'])) {
         include('404.php');
         die();
    }

    $dcode = cf::clean_input($_GET['dcode']);
    $stmt = $db->query("SELECT * FROM users WHERE code='$dcode'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (empty($user)) {
         include('404.php');
         die();
    }


?>


<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-2 px-4"  style="background-image: url('../images/');background-position: center;">
        <div class="authentication-inner py-5">

            <!-- [ Form ] Start -->
            <form class="card" onsubmit="return reset_pass(this);" name="reset_pass_form" >
                <div class="p-4 p-sm-5">
                    <!-- [ Logo ] Start -->
                    <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                        <div class=" ">
                            <div class="">
                                <img src="../images/icon.png" alt="Brand Logo" style="height: 50px">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                <div class="p-2 text-center bg-success text-white text-center   mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="reset_success" ></div>
                <div class="p-2  text-center bg-danger text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="reset_error"></div>
                

                            <p class="text-center">
                                <b class="text-center h4"><?php echo $user['fname'] . ' '. $user['lname'];?></b>
                                <br><br>
                                <small >Enter your new password.</small></p>
                 

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control pl-3 pr-3"  name="password"  required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control pl-3 pr-3"  name ="cpassword" required>
                            <div class="clearfix"></div>
                        </div>

                    <input type="hidden" id="dcode" name="dcode" value="<?php echo $dcode;?>">

                     <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </div>
            </form>
            <!-- [ Form ] End -->

        </div>
    </div>
    <!-- [ content ] End -->

    <!-- Core scripts -->
    <script src="template/assets/js/pace.js"></script>
    <script src="template/assets/js/jquery-3.3.1.min.js"></script>
    <script src="template/assets/libs/popper/popper.js"></script>
    <script src="template/assets/js/bootstrap.js"></script>
    <script src="template/assets/js/sidenav.js"></script>
    <script src="template/assets/js/layout-helpers.js"></script>
    <script src="template/assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="template/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <!-- Demo -->
    <script src="template/assets/js/demo.js"></script>

<!-- Demo -->    
    <?php include('app_js.php'); ?>

</body>

</html>
