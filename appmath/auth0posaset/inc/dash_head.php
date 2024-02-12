 <style type="text/css">
     .sidenav-link:hover {
        color:#20bea7 !important;
     }

     .sidenav-item.active{
        color:#20bea7 !important;
        background-color: #465963 !important;
     }
 </style>
<body>
<!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
<!-- [ Preloader ] End -->


<!-- [ Layout wrapper ] Start -->
  <div class="layout-wrapper layout-2">
       <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical logo-dark" style="background-color: #606c72;color: white;">
                <!-- Brand demo (see template/assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="../images/logo.png" alt="Brand Logo" class="img-fluid" style="height: 30px">
                    </span>
                    
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-l9arge ml-auto" id="close_nav">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                

                <!-- Links -->
                <ul class="sidenav-inner ">
<!-- 
                    <li class="sidenav-item <?php if($pageTitle=='dashboard'){ echo "active";} ?>" id='dashboard'>

                        <a href="dashboard.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li> -->


                    <li class="sidenav-item <?php if($pageTitle=='marketers'){ echo "active";} ?>" id='marketers'>
                        <a href="marketers.php" class="sidenav-link">
                            <i class="sidenav-icon  lnr lnr-users"></i>
                            <div>All Marketers </div>                            
                        </a>
                    </li>

                    <li class="sidenav-item  <?php if($pageTitle=='add_marketer'){ echo "active";} ?>" id='add_marketer'>
                        <a href="add_marketer.php" class="sidenav-link">
                            <i class="sidenav-icon  lnr lnr-user"></i>
                            <div>Register a Marketer </div>                            
                        </a>
                    </li>

 
                    <li class="sidenav-item <?php if($pageTitle=='providers'){ echo "active";} ?>" id='providers'>
                        <a href="providers.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-life-buoy "></i>
                            <div>All Providers </div>                            
                        </a>
                    </li>
                    

                <!--     <li class="sidenav-item <?php if($pageTitle=='add_provider'){ echo "active";} ?>" id='add_provider'>
                        <a href="add_provider.php" class="sidenav-link">
                            <i class="sidenav-icon  feather icon-plus-circle "></i>
                            <div>Register a Provider </div>                            
                        </a>
                    </li>
                

 -->
                   


                  
                  
                    

<!-- 

                    <li class="sidenav-divider border-0 mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Project Media</li>
                    
                      <li class="sidenav-item <?php if($pageTitle=='add_picture'){ echo "active";} ?>" id='add_picture'> 
                        <a href="add_picture.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-plus-circle"></i>
                            <div> Add Picture</div>
                        </a>
                    </li>

                    <li class="sidenav-item <?php if($pageTitle=='project_picture'){ echo "active";} ?>" id='project_picture'> 
                        <a href="project_picture.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-image"></i>
                            <div> Project Pictures</div>
                        </a>
                    </li>

              
               


                    <li class="sidenav-divider border-0 mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Account </li>
                    <li class="sidenav-item <?php if($pageTitle=='add_admin'){ echo "active";} ?>" id='add_admin'>
                        <a href="add_admin.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user-plus"></i>
                            <div>Add New Admin</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($pageTitle=='admins'){ echo "active";} ?>" id='admins'>
                        <a href="admins.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user"></i>
                            <div>Admins</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($pageTitle=='account_set'){ echo "active";} ?>" id='account_set'>
                        <a href="account_set.php" class="sidenav-link">
                            <i class="sidenav-icon feather icon-settings"></i>
                            <div>My Account Setting</div>
                        </a>
                    </li>
                   
 -->
                </ul>
            </div>
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center w3-text-white container-p-x" id="layout-navbar" style="background-color: #595d5f">

                    <!-- Brand demo (see template/assets/css/demo/demo.css) -->
                    <a href="index.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                        <img src="../images/logo.png" alt="Brand Logo" class="img-fluid" style="height: 30px">
                    </span>
                    <!-- 
                        <span class="app-brand-logo demo">
                            <img src="template/assets/img/logo-dark.png" alt="Brand Logo" class="img-fluid">

                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">Empire</span> -->
                    </a>

                    <!-- Sidenav toggle (see template/assets/css/demo/demo.css) -->
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center ml-auto">
                            


                           
 
                            <!-- Divider -->
                            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <span  class="d-block ui-w-30 rounded-circle bg-primary text-white font-weight-bold text-center pt-1" style="height: 30px;width: 30px"><?php echo substr($admin_user['username'], 0, 2); ?></span>
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"> Account</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  

                                    <a href="account_set.php" class="dropdown-item">
                                        <i class="feather icon-settings text-muted"></i> &nbsp; Account settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="logout.php" class="dropdown-item">
                                        <i class="feather icon-power text-danger"></i> &nbsp; Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout navbar ( Header ) ] End -->
 
