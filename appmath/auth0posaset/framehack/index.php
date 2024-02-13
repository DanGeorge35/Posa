<?php
    $pageTitle='Login';
    include('./inc/header.php'); 
?>
                   


        <!-- Begin page -->
        <div class="home-btn d-none d-sm-block">
            <a href="index.html" class="text-dark"><i class="mdi mdi-home h1"></i></a>
        </div>

        <div class="account-pages">
            
            <div class="container">
                <div class="row align-items-center">
                 
                    <div class="col-lg-6 offset-lg-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-2">
                                   
                                    <div>
                                        <a href="index.html" class="logo logo-admin form-control-lg">FrameHack</a>
                                    </div>
                                </div>
        
                                <div class="p-2">
                                    <form class="form-horizontal m-t-20" action="dashboard.php" method="post">

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" required="" placeholder="SERVER-HOST"  name='server' value="localhost">
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text"   name='db_name' placeholder="DATABASE_NAME">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" required=""  name='db_user' placeholder="USERNAME">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="password"    name='db_pass' placeholder="PASSWORD">
                                            </div>
                                        </div>
                                       
        
                                        <div class="form-group text-center row m-t-20">
                                            <div class="col-12">
                                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Connect</button>
                                            </div>
                                        </div>
        
                                      
                                    </form>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
   

<?php include('./inc/footer.php');  ?>
