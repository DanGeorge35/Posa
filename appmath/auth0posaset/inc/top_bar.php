<?php
    $frname = substr($login_user['firstname'], 0, 1);
    $srname = substr($login_user['surname'], 0, 1);    
    $dname = $frname . $srname;

    $messages= sf::total_new_message($login_user['member_id']);
    $notification= sf::total_new_notification($login_user['member_id']);
    $total_agent_property = sf::total_agent_property($login_user['member_id'] );
    $total_wallet_value = sf::total_wallet_value($login_user['member_id'] );



?>
    <body class="fixed-left">
<div id='menu_cover' onclick="$('#menu_close').click()" class="w3-display-container animated fadeIn slow" style="position: fixed;top:0;bottom: 0;left:0;right: 0;background-color: rgb(0 0 0 / 27%);z-index:5;display: none">
</div>
<div id='cover' class="w3-display-container animated fadeIn slow" style="position: fixed;top:0;bottom: -10vh;left:0;right: 0;background-color: rgb(255 255 255 / 95%); z-index: 9000;display: none">
</div>

<div class="" id='top_load' style="position: fixed;left: 0;right: 0;top: 0;height: 1px;z-index: 200;background-color: #ddd!important">
    <div class="" style="margin: 0px ;padding: 0px;height: 1px;background-color: #ddd!important" >
           <div class="bg-white " id ="top_loader" style="width: 33.3vw;padding: 1px;position: absolute;"></div>        
</div>
</div>
<script type="text/javascript">
 var top_loader = document.getElementById("top_loader");   
  var pos = 0;
  top_loader.style.display="none";
  var top_loader_tim = setInterval(frame, 5);
  function frame() {
      pos =  pos + 10; 
      top_loader.style.left = pos + 'px'; 
       top_loader.style.display="block";
    if (pos >= screen.width) {
       pos =0;
      top_loader.style.left = pos + 'px'; 
    }
  }

function stop_load() {
    clearInterval(top_loader_tim);
    top_loader.style.display="none";
}
function start_load() {
    top_loader_tim = setInterval(frame, 5);
}
stop_load();

</script>

        <!-- Loader -->
        <div id="preloader">
             <div style="position: absolute;left: 0;right: 0;top:35vh;">
                <center>
                    <img src="../logo2.png" height="50" alt="logo" style="z-index: 2;  position: relative;"><br>
                    <img src="../line_load.gif" alt="logo" style="margin-top: -50px;height: 110px;width: 165px;border-radius: 99px;z-index: 1;position: relative;">
         
                </center>
            </div>
        </div>

        <!-- Begin page -->
        <div id="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect"  id='menu_close' onclick="menu_remove()">
                    <i class="mdi mdi-close"></i>
                </button>

                <div class="left-side-logo d-block d-lg-none">
                    <div class="text-center">
                        <a href="https://9property.net" class="logo "><img src="../logo2.png"  class="" height="40" alt="logo"></a>
                    </div>
                </div>


                <div class="sidebar-inner slimscrollleft">
                    
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title ">Main Menu</li>

                            <li>
                                <a href="index.php" class="waves-effect ">
                                    <i class="dripicons-home"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>

                             <li>
                                  <a href="wallet" class="waves-effect"><i class="dripicons-wallet "></i><span>My wallet </span>
                                   <span class="badge badge-danger float-right  ml-2 w3-tiny" style="position: absolute;margin-top: -10px;border-radius: 5px 5px 5px 0px">Get Bonus</span></a>
                            </li>

   <li>
                              
    </li>
                          <li>
                                  <a href="#viewchat" class="waves-effect"  ><i class="dripicons-mail"></i><span>Messages </span>  <span class="badge badge-warning badge-pill float-right"><?php echo $messages;?></span></a>
                            </li>

                           
                           
<!-- <span class="badge badge-success badge-pill float-right">3</span> -->
    <li class="menu-title ">Agent Menu</li>
    
    <li>
        <a href="add_property.php" class="waves-effect"><i class="dripicons-medical "></i><span>  Add new property </span> </a>
    </li>

    <li>
         <a href="manage_property.php" class="waves-effect"><i class="dripicons-store"></i><span>  Manage properties </span>  </a>
    </li>

    <li>
        <a href="promotion.php" class="waves-effect"><i class="dripicons-shopping-bag"></i><span>  My promotion </span>  </a>
    </li>
    
<!--    
    <li class="menu-title ">Investments </li>
    
     <li>
         <a href="manage_products.php" class="waves-effect"><i class=" fas fa-hand-holding-usd"></i><span> Smart deals </span> <span class="badge badge-danger float-right  ml-2 w3-tiny" style="position: absolute;margin-top: -10px;border-radius: 5px 5px 5px 0px">Smart Earning</span>  </a>
    </li>

     <li>
        <a href="add_product.php" class="waves-effect"><i class="fas fa-hands-helping"></i><span>  Synergy deals </span> <span class="badge badge-warning float-right  ml-2 w3-tiny" style="position: absolute;margin-top: -10px;border-radius: 5px 5px 5px 0px">Joint Earning</span>  </a>
    </li>

    <li>
        <a href="calendar.php" class="waves-effect"><i class="fas fa-hands"></i><span>  Manage your deals </span>  </a>
    </li>
     -->


       <li class="menu-title">Account Menu </li>


                             <li>
                                  <a href="profile" class="waves-effect"><i class="dripicons-user"></i><span>My profile </span></a>
                            </li>

                           
                             <li>
                                  <a href="settings" class="waves-effect"><i class="dripicons-gear"></i><span>Settings </span></a>
                            </li>
                            
                            <li>
                              <a href="../logout" class="waves-effect"><i class="dripicons-exit"></i><span> Logout</span> </a>
                            </li>

                           

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->



         <div class="content-page">


                <!-- Start content -->
                <div class="content">

    <!-- Top Bar Start -->
                    <div class="topbar">

                        <div class="topbar-left d-none d-lg-block">
                            <div class="text-center">
                                <a href="https://9property.net" class="logo"><img src="../logo2.png" height="45" alt="logo"></a>
                            </div>
                        </div>

                        <nav class="navbar-custom">

                             <!-- Search input -->
                             <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0">
<!-- 
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
                                        <i class=" mdi mdi-magnify noti-icon"></i>
                                    </a>
                                </li> -->



                             
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link waves-effect toggle-search" href="#viewchat"  >
                                        <i class=" mdi mdi-email-variant noti-icon"></i>
                                        <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo $messages;?></span>
                                    </a>
                                </li>

                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        <i class="mdi mdi-bell-outline noti-icon"></i>
                                        <span class="badge badge-warning



                                         badge-pill noti-icon-badge"><?php echo $notification ;?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Notification (<?php echo $notification;?>)</h5>
                                        </div>

                                        <div class="slimscroll-noti">
                                            

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details"><b>Hello  <?php echo $login_user['firstname'] . " ". $login_user['surname'] ?> </b><span class="text-light"> You are welcome to 9property</span></p>
                                            </a>

                                             <a href="wallet" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details"><b>Get Bonus </b><span class="text-light">Get 50% Bonus on Every Topup of ₦1000 and Above</span></p>
                                            </a>

                                            <a href="promotions" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details"><b>Sell Fast  </b><span class="text-light">Use our property Ads promotion to sell or lease your property faster</span></p>
                                            </a>




                                        <!-- All-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-all">
                                            View All
                                        </a> -->

                                    </div>
                                </li>
    

                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        <!-- <img src="template/assets/images/users/avatar-6.jpg" alt="user" class="rounded-circle">
                                         -->
                                        <div class="float-left user mr-1 ">
                                        <!-- <span class="bg-success text-center rounded-circle text-dark mt-0 p-2 ">DG</span> -->
                                        <img class=" rounded-circle "  src="<?php echo cf::get_member_image($login_user['member_id']);?>"   alt="user.jpg" style="height: 35px;width: 35px;">
                                        </div>

                                        <span class="d-none d-md-inline-block ml-1"><?php echo $login_user['firstname'] . " ". $login_user['surname'] ?> <i class="mdi mdi-chevron-down"></i> </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                        <a class="dropdown-item" href="profile"><i class="dripicons-user text-success"></i> Profile</a>
                                        <a class="dropdown-item" href="wallet"><i class="dripicons-wallet text-success"></i> My Wallet <span class="badge badge-danger float-right   w3-tiny" style="position: absolute;margin-top: -5px;border-radius: 5px 5px 5px 0px">Get Bonus</span></a>
                                        <a class="dropdown-item" href="settings"><i class="dripicons-gear text-success"></i> Settings</a>
                                        <a class="dropdown-item" href="javascript:void(0" onclick="toggleFullScreen();"><i class="dripicons-expand text-success"></i> Full screen</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../logout"><i class="dripicons-exit text-success"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect" onclick="menu_click()">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>
                                <!-- <li class="list-inline-item d-inline-block d-md-none ">
                                    <img src="../logo2.png" style="height: 31px;position: absolute; margin-top: -25px;    margin-left: -10px;" >
                                </li> -->


                                <li class="list-inline-item dropdown notification-list d-none d-sm-inline-block">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        Go to Links <i class="ti-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animated">
                                        <a class="dropdown-item" href="../estates?search=house"> <i class="ti-angle-right pr-3"></i> Houses For Sale/Rent</a>
                                        <div class="dropdown-divider"></div>
                                        <!-- <a class="dropdown-item" href="../estates?search=rent"> <i class="ti-angle-right  pr-3"></i> Houses To Let/Lease</a> -->
                                        <!-- <div class="dropdown-divider"></div> -->
                                        <a class="dropdown-item" href="../estates?search=land"> <i class="ti-angle-right  pr-3"></i> Land For Sale/Lease</a>
                                        <!-- <div class="dropdown-divider"></div> -->
                                        <!-- <a class="dropdown-item" href="#"> <i class="ti-angle-right  pr-3"></i> Land To Let/Lease</a> -->
                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="../agents"> <i class="ti-angle-right  pr-3"></i> Our Agents</a>
                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="../about"> <i class="ti-angle-right  pr-3"></i> About Us</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../faq"> <i class="ti-angle-right  pr-3"></i> FAQs</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../privacy"> <i class="ti-angle-right  pr-3"></i> Privacy Policy</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../terms"> <i class="ti-angle-right  pr-3"></i> Terms of Use</a>
                                        
                                        
                                    </div>
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
                </div>


                <script type="text/javascript">
                    function menu_click() {
                         menu_cover= document.getElementById('menu_cover');
                        if(menu_cover.style.display==='block'){
                            menu_cover.style.display='none';
                        }
                        if(screen.width < 700){
                            menu_cover.innerHTML='';
                            menu_cover.style.display='block';
                            
                        }

                       
                    }

                     function menu_remove() {
                            document.getElementById('menu_cover').style.display='none';
                    }
                </script>