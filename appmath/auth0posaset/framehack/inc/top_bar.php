    
    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader" style="background-color:black">
            <div id="status">

                <div class="spinner">

                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>

                </div>
            FrameHack
            </div>
        </div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="fas fa-close"></i>
                </button>

                <div class="left-side-logo d-block d-lg-none">
                    <div class="text-center">
                        <a href="index.html" class="logo">FrameHack</a>
                    </div>
                </div>

                <div class="sidebar-inner slimscrollleft">
                    
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">SYSTEM CODES</li>
                             <li  >
                                <a href="dashboard.php" class="waves-effect">
                                  <i class="fas fa-calendar"></i>
                                    <span> Dashboard </span>
                                </a>

                            </li>
                              

                             <li>
                                <a href="insert_code.php" class="waves-effect"><i class="fas fa-calendar"></i><span> db_insert</span></a>
                            </li>




                            <li class="menu-title">TABLES LIST</li>

                           

    <?php 
    $tables = cf::seltables(DB_NAME);
        foreach($tables as $table){
            //Print the table name out onto the page.
         echo '<li>
                                <a href="table_show.php?tb='.$table[0].'" class="waves-effect"><i class="fas fa-calendar"></i><span>'. $table[0]. '</span> </a>
        </li>';
        }



    ?>
        

                             
                       


                            

                         



                      

 <?php // echo $first_name; ?>
    <?php  //echo $pageTitle; ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            
         <div class="content-page">


    <!-- Top Bar Start -->
                    <div class="topbar">

                        <div class="topbar-left d-none d-lg-block">
                            <div class="text-center">
                                <a href="index.php" class="logo  form-control-lg">FrameHack</a>
                            </div>
                        </div>

                        <nav class="navbar-custom">

                             <!-- Search input -->
                             <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="fas fa-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0">
                                <!-- <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
                                        <i class="fas fa-magnify noti-icon"></i>
                                    </a>
                                </li> -->
 

                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                      

                                        <span class="d-none d-md-inline-block ml-1 text-capitalize">
                                    <div class="float-left user mr-3 ">
                                        <span class="bg-primary text-center rounded-circle text-dark mt-0 p-2 ">DB</span>
                                    </div><?php echo DB_NAME; ?> <i class="fas fa-chevron-down"></i> </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                     
                                        <?php
                                            $dataBs = cf::seldatabase();
                                                foreach($dataBs as $dataB){
                                                    echo '<a class="dropdown-item" href="dashboard.php?db='. $dataB[0] .'"> <i class="fas fa-database text-muted"></i>'. $dataB[0].'</a>';
                                                }
                                        ?>

                                        <div class="dropdown-divider"></div>
                                        
                                        <a class="dropdown-item" href="index.php"><i class="fas fa-sign-out-alt text-muted"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="fas fa-menu"></i>
                                    </button>
                                </li>
                                
                               <!--  <li class="list-inline-item notification-list d-none d-sm-inline-block">
                                    <a href="#" class="nav-link waves-effect">
                                        Activity
                                    </a>
                                </li> -->

                            </ul>


                        </nav>

                    </div>
                    <!-- Top Bar End -->