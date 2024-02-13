<?php 
    include('../engine/config.php');

    if(!empty($login_user)){
        cf::mobi_redirect('./dashboard');
    }   

    $pageTitle='Register Account';
    include('./inc/header.php');
?>
<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Content ] Start -->
    <div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-" style="background-image: url('../images/');">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>

        <div class="authentication-inner py-5">

            <div class="card">
                <div class="p-4 p-sm-5" style="padding-bottom: 0px !important;">
                    <!-- [ Logo ] Start -->
                    <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                        <div class="">
                            <div class="">
                                <img src="../images/icon.png" alt="Brand Logo" style="height: 50px">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Logo ] End -->

                    <h5 class="text-center text-muted font-weight-normal mb-4">Create an Account</h5>

                    <!-- Form --> 
                    <form  onsubmit="return register_form(this);" name="regi_form">

                <div class="p-2 text-center bg-success text-white text-center   mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="success" ></div>
                <div class="p-2  text-center bg-danger text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="error"></div>
                <div class="p-2  text-center bg-warning text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="warning"></div>

                        <div class="form-group">
                            <label class="form-label">Firstname</label>
                            <input type="text" class="form-control pl-3 pr-3"  name="fname"  required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lastname</label>
                            <input type="text" class="form-control pl-3 pr-3"  name ="lname" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Your email</label>
                            <input type="text" class="form-control pl-3 pr-3"  name="email" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control pl-3 pr-3" name="password" required>
                            <div class="clearfix"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">Sign Up</button>
                        <div class="text-light small mt-4">
                            By clicking "Sign Up", you agree to our
                            <a href="javascript:void(0)">terms of service and privacy policy</a>. We’ll occasionally send you account related emails.
                        </div>
                    </form>
                    <!-- [ Form ] End -->

                </div>
                <div class="card-footer py-3 px-4 px-sm-5">
                    <div class="text-center text-muted">
                        Already have an account?
                        <a href="login">Sign In</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->

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
    <?php include('app_js.php'); ?>
</body>


<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/pages_authentication_register-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Oct 2020 05:07:03 GMT -->
</html>
