<?php 
    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='add_marketer';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  



if(isset($_POST['add_marketer'])) {
    
    extract($_POST);
    $marketer_id = cf::get_unique_code(4);
    dbi::posa_marketer($marketer_id, $name, $marketer_id, $email, $state, $city,'available');
    $m_id = cf::selany('id','posa_marketer','marketer_id',$marketer_id);
    $mark_id = ($m_id + 1000);
    $mark_id = "0".$mark_id;
    $encrypt_id = cf::generate_hash($mark_id);
    cf::update('posa_marketer','encrypt_id',$encrypt_id,'id',$m_id);  
    cf::update('posa_marketer','marketer_id',$mark_id,'id',$m_id);  

    cf::mobi_redirect('marketers.php');
    echo 'done'; exit;
}




?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">


                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">

                      
 
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12  ">
                        <section class=" card p-4 w3-light-grey pt-3 border">
                                
                     <div class="row">
                        <div class="col-sm">
                          <h4 class="text-dark">Register Marketer</h4>
                          <br>
                            <form   id="add-admin-form" class="form" method="post">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label mb-10" for="exampleInputusername"> Name:</label>
                                        <input type="text" required class="form-control w3-small" id="exampleInputusername" placeholder="Enter The Marketer's Name" name="name">                                      
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="control-label mb-10">Email:</label>
                                   <input type="text" required class="form-control w3-small" id="exampleInputusername" placeholder="Enter The  Marketer's Email " name="email">     
                                </div>
                                </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label class="control-label mb-10">State Of operation:</label>
                                            <input type="text" required class="form-control w3-small"  name="state"  placeholder="Enter The  Marketer's State of operation ">
                                        </div>
                                     </div>
                                    <div class="col-md-6">   
                                         <div class="form-group">
                                            <label class="control-label mb-10">City of Operation:</label>
                                            <input type="text" required class="form-control w3-small"  name="city"  placeholder="Enter The  Marketer's City of Operation ">
                                        </div>
                                    </div>
                                </div>
                                
                              
                               
                               
                                <center class="pt-3">
                                <button type="submit" name="add_marketer"   class="btn btn-primary rounded  mb-2">Create New Marketer</button>
                                </center>
                            </form>
                        </div>
                    </div>
                     
                          
                        </section>
                    </div>
                </div>
                <!-- /Row -->

 
                    </div>
                    <!-- [ content ] End -->

                </div>

<style type="text/css">
  body{
    background-color: #f7f7f7;
  }
</style>



<?php include('./inc/dash_footer.php'); ?>
<?php include('./inc/footer.php'); ?>
<?php include('app_js.php'); ?>