<?php 


    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='profile';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>


  
                <!-- [ Layout content ] Start -->
     <div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Users Profile</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item">Users</li>
                                
                            </ol>
                        </div>

                        <!-- Header -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-auto col-sm-12">
                                        <div class="i-block " data-clipboard-text="feather icon-user" data-filter="icon-user" data-toggle="tooltip" title="" data-original-title="icon-user"><i class="feather icon-user" style="font-size: 90px;text-shadow: 0px 2px 10px #ddd"></i></div>
                                    </div>
                                    <div class="col">
                                        <h4 class="font-weight-bold mb-4"><?php echo $login_user['fname'] . ' '.$login_user['lname']; ?></h4>
                                        

                                        <a href="javascript:void(0)" class="d-inline-block text-dark">
                                            <strong><?php echo sf::total_user_slot($login_user['user_id']);?> </strong>
                                            <span class="text-muted">M<sup>2</sup><br> Total Active Slot </span>
                                        </a>
                                        <a href="javascript:void(0)" class="d-inline-block text-dark ml-3">
                                            <strong>₦<?php echo number_format(sf::total_user_capital($login_user['user_id']));?></strong>
                                            <span class="text-muted"><br> Total Active Capital</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Header -->

                        <div class="row">
                            <div class="col">

                                <!-- Info -->
                                <div class="card mb-4">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Birthday:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['dob'])){ echo $login_user['dob']; }else{ echo "-";} ?>
                                            </div>
                                        </div>

                                           <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Gender:</div>
                                            <div class="col-md-9">
                                               <?php if(!empty($login_user['gender'])){ echo $login_user['gender']; }else{ echo "-";} ?>
                                            </div>
                                        </div>
                                        <h6 class="my-3">Contacts</h6>

                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Phone:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['phone'])){ echo $login_user['phone']; }else{ echo "-";} ?>
                                            </div>
                                        </div>

                                          <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Email:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['email'])){ echo '<a href="javascript:void(0)" class="text-dark">'. $login_user['email'].'</a>' ; }else{ echo "-";} ?>
                                            </div>
                                        </div>


                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Address:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['address'])){ echo $login_user['address']; }else{ echo "-";} ?>
                                            </div>
                                        </div>

<br>

                                        <h6 class="my-3">Next of Kin</h6>

                                       <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Name:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['nok_fname'])){ echo $login_user['nok_fname'] . ' '. $login_user['nok_lname']; }else{ echo "-";} ?>
                                            </div>
                                        </div>
                                    
                                         <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Phone:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['nok_phone'])){ echo $login_user['nok_phone']; }else{ echo "-";} ?>
                                            </div>
                                        </div>

                                         <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Email:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['nok_email'])){ echo $login_user['nok_email']; }else{ echo "-";} ?>
                                            </div>
                                        </div>
                                      

                                         <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Address:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['nok_address'])){ echo $login_user['nok_address']; }else{ echo "-";} ?>
                                            </div>
                                        </div>

                                           <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Relationship:</div>
                                            <div class="col-md-9">
                                                <?php if(!empty($login_user['nok_relation'])){ echo $login_user['nok_relation']; }else{ echo "-";} ?>
                                            </div>
                                        </div>



                                    </div>
                                
                                </div>
                                <!-- / Info -->

                                <!-- Posts -->

                                
                                <!-- / Posts -->

                            </div>
                            <div class="col-xl-4">
                                            
                                <div class="card">
                                    <div class="card-body text-center">

                                    <?php 


                                    if(sf::total_user_slot($login_user['user_id']) == 0){
                                     $mem =' <img src="template/assets/img/pages/medal-trial.svg" alt="" class="img-fluid w-50">
                                        <h4 class="mt-3">TRIAL ACCOUNT</h4>
                                        <p class="mb-2">You are not yet an Investor</p>


                                        <p><span class="badge badge-primary">0 Slot Acquired</span> </p>
                                        ';
                                        $tchk = " <span class='fas fa-check '></span> ";
                                    }

                                    if(sf::total_user_slot($login_user['user_id']) > 0){
                                         $tchk='';
                                         $bchk='';
                                         $schk='';
                                         $gchk='';
                                         $pchk ='';
                                         $bchk = " <span class='fas fa-check text-primary'></span> ";
                                     $mem =' <img src="template/assets/img/pages/medal-bronze.svg" alt="" class="img-fluid w-50">
                                        <h4 class="mt-3">BRONZE ACCOUNT</h4>
                                        <p class="mb-2"> '. sf::mem_type($login_user['user_id']) . '</p>
 

                                        <p><span class="badge badge-primary">'. sf::total_user_slot($login_user['user_id']) . ' Slot Acquired</span> </p>
                                        ';
                                    }

                                    if(sf::total_user_slot($login_user['user_id']) >= 150){
                                          $tchk='';
                                         $bchk='';
                                       
                                         $gchk='';
                                         $pchk ='';
                                         $schk = " <span class='fas fa-check'></span> ";
                                     $mem =' <img src="template/assets/img/pages/medal-silver.svg" alt="" class="img-fluid w-50">
                                        <h4 class="mt-3">SILVER ACCOUNT</h4>
                                        <p class="mb-2"> '. sf::mem_type($login_user['user_id']) . '</p>


                                        <p><span class="badge badge-primary">'.sf::total_user_slot($login_user['user_id']).' Slot Acquired</span> </p>
                                        ';
                                    }


                                     if(sf::total_user_slot($login_user['user_id']) >= 300){
                                          $tchk='';
                                         $bchk='';
                                         $schk='';
                                  
                                         $pchk ='';
                                         $gchk = " <span class='fas fa-check'></span> ";
                                     $mem =' <img src="template/assets/img/pages/medal-gold.svg" alt="" class="img-fluid w-50">
                                        <h4 class="mt-3">GOLD ACCOUNT</h4>
                                        <p class="mb-2"> '. sf::mem_type($login_user['user_id']) . '</p>


                                        <p><span class="badge badge-primary">'.sf::total_user_slot($login_user['user_id']).' Slot Acquired</span> </p>
                                        ';
                                    }

                                      if(sf::total_user_slot($login_user['user_id']) >= 420){
                                         $tchk='';
                                         $bchk='';
                                         $schk='';
                                         $gchk='';
                                         $pchk = " <span class='fas fa-check'></span> ";
                                     $mem =' <img src="template/assets/img/pages/medal-platinum.svg" alt="" class="img-fluid w-50">
                                        <h4 class="mt-3">PLATINUM ACCOUNT</h4>
                                        <p class="mb-2"> '. sf::mem_type($login_user['user_id']) . '</p>


                                        <p><span class="badge badge-primary">'.sf::total_user_slot($login_user['user_id']).' Slot Acquired</span> </p>
                                        ';
                                    }

                                    echo $mem;


                                    ?>
                                        
                                    </div>

                                  
                                    
                                </div>
                                    

                            <div class="row">

                                <div class="col-12 text-center pb-3">
                                    <span class="badge badge-dot badge-default"></span> Trial Account&nbsp;<?php  echo $tchk;?>
                                </div>
                                 <div class="col-6 pb-3">
                                    <span class="badge badge-dot badge-primary"></span> Bronze Account&nbsp;<?php  echo $bchk;?>
                                </div>

                                 <div class="col-6 pb-3">
                                    <span class="badge badge-dot badge-success"></span> Silver Account &nbsp;<?php  echo $schk;?>
                                </div>

                                 <div class="col-6 pb-3">
                                    <span class="badge badge-dot badge-info"></span> Gold Account &nbsp;<?php  echo $gchk;?>
                                </div>
                                <div class="col-6 ">
                                    <span class="badge badge-dot badge-warning"></span> Platinum Account&nbsp;<?php  echo $pchk;?>
                                </div>



                                
                                
                                
                                
                                

                            </div>
 
                            </div>
                        </div>

                    </div>
                    <!-- [ content ] End -->

           

                </div>

<?php include('./inc/dash_footer.php'); ?>

<?php include('./inc/footer.php'); ?>