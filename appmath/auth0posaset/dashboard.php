<?php 



    include('../engine/config.php');
    include('./inc/auth.php');

    cf::mobi_redirect('add_marketer.php');
die();
    $pageTitle='dashboard';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  



?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">


                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">

                        <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
                    
                        <div class="row">
                            <!-- first card start -->
                            <!-- Staustic card 11 Start -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5>Active Investment</h5>
                                        <div class="row align-items-center">
                                            <div class="col">
                                               <a href="active_slot.php"> 
                                                <label class="badge badge-pill badge-success"><?php //echo  $active_investment;?> Active <i class="m-l-10 feather icon-arrow-down"></i></label>
                                               </a>
                                            </div>
                                            <div class="col-12 text-right">

                                                <h5 class="mb-0"><?php //echo number_format(sf::total_active_capital()); ?> <sup>₦</sup></h5>
                                                 
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5>Awaiting Approval</h5>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="awaiting_approval.php"> 
                                                <label class="badge badge-pill badge-secondary"> <?php //echo $awaiting_approval; ?> Awaiting <i class="m-l-10 feather icon-arrow-down"></i></label>
                                                </a>
                                            </div>
                                            <div class="col-12 text-right">
                                                <h5 class="mb-0"><?php //echo number_format(sf::total_awaiting_approval_capital()); ?> <sup>₦</sup></h5>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5>Pending Investment</h5>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="awaiting_pay_slot.php"> 
                                                <label class="badge badge-pill badge-danger"><?php //echo $awaiting_investment; ?> Pending <i class="m-l-10 feather icon-arrow-down"></i></label>
                                                </a>
                                            </div>
                                            <div class="col-12 text-right">
                                                <h5 class="mb-0"><?php //echo number_format(sf::total_awaiting_investment_capital()); ?> <sup>₦</sup></h5>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>


                             <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5>Investment  Payment</h5>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="active_slot.php"> 
                                                <label class="badge badge-pill badge-warning"><?php //echo $awaiting_investment; ?> Investment Returns <i class="m-l-10 feather icon-arrow-down"></i></label>
                                                </a>
                                            </div>
                                            <div class="col-12 text-right">
                                                <h5 class="mb-0"><?php //echo number_format(sf::total_awaiting_investment_capital()); ?> <sup>₦</sup></h5>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                          
                          
                            <!-- Staustic card 11 end -->
                            <!-- Second card start -->
                            <div class="col-md-12">
                                <div class="card d-flex w-100 mb-4">
                                    <div class="row no-gutters row-bordered row-border-light h-100">
                                        
                                         
                                        <div class="d-flex col-md-3 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-users display-4 d-block text-danger"></i>
                                                <span class="media-body d-block ml-3">
                                                    <span class="text-big"><span class="mr-1 text-danger"><?php //echo sf::total_users() ; ?>+</span> Investors</span>
                                                    <br>
                                                    <small class="text-muted">YoghurtVest Partners</small>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex col-md-3 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-clock display-4 d-block text-danger"></i>
                                                <span class="media-body d-block ml-3">
                                                    <span class="text-big"><span class="mr-1 text-danger"> </span> Monthly / Bi-annual</span>
                                                    <br>
                                                    <small class="text-muted">Invesment Packages </small>
                                                </span>
                                            </div>
                                        </div>



                                        <div class="d-flex col-md-3 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-chart-bars display-4 d-block text-danger"></i>
                                                <span class="media-body d-block ml-3">
                                                    <span class="text-big"><span class="mr-1 ">5% Monthly <br> 50% Bi-annually</span>
                                                    <br>
                                                    <small class="text-muted">Interest Rate  </small>
                                                </span>
                                            </div>
                                        </div>


                                         <div class="d-flex col-md-3 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-leaf display-4 d-block text-danger"></i>
                                                <span class="media-body d-block ml-3">
                                                    <span class="text-big"><span class="mr-1 text-danger"> ₦ <?php  //echo number_format((sf::total_cash_out())); ?></span> </span>
                                                    <br>
                                                    <small class="text-muted">Total Cash Paid-Out  </small>
                                                </span>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                    

                            
                            <div class=" col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0"> Investment Chart</h6>
                                        
                                    </div>
                                    <div class="card-body py-0">
                                        <div id="chart-bar-moris" style="height:300px"></div>
                                    </div>
                                    <div class="card-footer pt-0 pb-0">
                                        <div class="row row-bordered row-border-light">
                                           
                                            <div class="col-sm-6 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="ui-legend bg-success" style="width:20px;height:20px"></div>
                                                    <div class="ml-3">
                                                        <p class="text-muted small mb-1">Total Cash In</p>
                                                        <h5 class="mb-0"> ₦<?php //echo  number_format((sf::total_cash_in())); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="ui-legend bg-danger" style="width:20px;height:20px"></div>
                                                    <div class="ml-3">
                                                        <p class="text-muted small mb-1">Total Cash Out</p>
                                                        <h5 class="mb-0"> ₦<?php  //echo number_format((sf::total_cash_out())); ?></h5>
                                                    </div>
                                                </div>
                                            </div>


                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    </div>
                    <!-- [ content ] End -->

                </div>

<?php include('./inc/dash_footer.php'); ?>

<?php include('./inc/footer.php'); ?>