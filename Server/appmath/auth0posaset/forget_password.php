<?php 
    include('../engine/config.php');

     if(!empty($login_user)){
        cf::mobi_redirect('./dashboard');
    }

    $pageTitle='forget_password';
    include('./inc/header.php');
?>
<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-2 px-4"  style="background-image: url('../images/lakeview_8.jpg');background-position: center;">
        <div class="authentication-inner py-5">

            <!-- [ Form ] Start -->
            <form class="card " method="post" onsubmit="return forget_pass(this);" name="forget_pass_form" style="">
                <div class="p-4 p-sm-5">
                    <!-- [ Logo ] Start -->
                    <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                        <div class=" ">
                            <div class="">
                                <img src="../images/pos2.png" alt="Brand Logo" style="height: 30px">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                <div class="p-2 text-center bg-success text-white text-center   mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="forget_success" ></div>
                <div class="p-2  text-center bg-danger text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="forget_error"></div>
                


                    <!-- [ Logo ] End -->
                    <h5 class="text-center text-muted font-weight-normal mb-4">Reset Your Password</h5>
                    <center><hr class="mt-0 mb-4" style="width: 100px"></center>
                    <p><small>Enter your email address and we will send you a link to reset your password.</small></p>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter your email address" required="" name="email">
                        <div class="clearfix"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send password reset email</button>
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
