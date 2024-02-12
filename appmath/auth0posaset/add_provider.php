<?php 


    include('../engine/config.php');
    include('./inc/auth.php');




// PROCESS FORMS
if(isset($_POST['do_add_provider'])) {

    
    extract($_POST);
    $marketer_id = cf::get_unique_code(4);
    dbi::posa_marketer($marketer_id, $name, $marketer_id, $email, $state, $city,'available');
    $m_id = cf::selany('id','posa_marketer','marketer_id',$marketer_id);
    $mark_id = ($m_id + 1000);
    $encrypt_id = cf::generate_hash($mark_id);
    cf::update('posa_marketer','encrypt_id',$encrypt_id,'id',$m_id);  
    cf::update('posa_marketer','marketer_id',$mark_id,'id',$m_id);  

    cf::mobi_redirect('marketers.php');
    echo 'done'; exit;
}



// =================================FORMS PROCESSING CODES END HERE======================================


// INCLUDE HEADER FILE, IF AVAILABLE
    //NOTE: always set the pageTiltle variable before including the header file. the pageTitle variable is required so as to echo each page's unique title into the head section and even in some parts of the body section of the page
// =======================================================================
 


    $pageTitle='add_provider';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">


                    <!-- [ content ] Start -->
                    <div class="container-fluid ">
 


         <div class="row">
              <div class="col-sm-12 pt-4 pb-4">
                  <div class="page-title-box">
                      <div class="row align-items-center">
                          <div class="col-md-12  ">
                       
                               <a href="providers.php" class="btn w3-pink w3-hover-pink text-white rounded pl-4 pr-4 float-right w3-small"> <span class="ti-plus"></span> All Provider</a>
                          </div>
                          <!-- end col -->
                      </div>
                      <!-- end row -->
                  </div>
                  <!-- end page-title-box -->
              </div>
          </div> 
 



<style type="text/css">

        .cat_seprate{
            
            position: absolute;
            margin-left: 0ex;
            margin-top: -23px;
            height: 24px;
            width:  22px;
            border-left: 2px solid #172f5f;
            border-bottom: 1px solid #3959a2;
        }
</style>

<div class="row">
  <div class="col-12 p-0">
          
    <style type="text/css">
            .cat_head{
                color: white;
                padding: 6px;
                background-color: #46cd93 ;

            }

            .cat_pan{
                max-height: 300px;
                overflow-y: auto;   
            }

            .cat_list{
                padding: 6px 16px;
                height: auto;
                font-size: 14px;
                font-weight: normal;
                border-radius: 3px;
            }
    </style>

  <div> 

                        <section class=" card p-4 w3-light-grey pt-3 border">
                           <div class="row">
                              <div class="col-12">
                                <h4 class="text-dark">Add New </h4>
                                <br>
                                  <form   id="add-admin-form" class="form" method="post">
                                    <div class="row">
                                      
                                  <div class="col-md-6  ">                                    
                                    <div class="form-group">
                                          <label class="control-label mb-10" for="exampleInputusername">Provider's Name</label>
                                          <input type="text" required class="form-control w3-small" id="exampleInputusername" placeholder="Provider's Name" name="name">
                                        
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label mb-10" for="exampleInputEmail_1" >Transaction</label>
                                          <select class="form-control" name="transaction_type" required>
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="deposit">Deposit</option>
                                            <option  value="withdrawal">Withdrawal</option>
                                          </select>
                                      </div>
                                      </div>

                                      <div class="col-md-6  ">
                                      <div class="form-group">
                                            
                                         <div class="form-group">
                                            <label class="control-label mb-10">Charges:</label>
                                            <textarea class="form-control font-weight-bold" style="height: 140px" name="charges" required>
                                                [
                                                {"a":"1","charge":"30"}
                                                ]
                                              </textarea>
                                        
                                    </div>
                                           
                                          
                                      </div>
                                    
                                    </div>

                                      </div>
                                      
                                      <button type="submit" name="do_add_provider"   class="btn btn-primary rounded  float-right mb-2">Add Provider</button>
                                      
                                   </form>
                               </div>
                            </div>                   
                        </section>

                  

            </div>
            <!-- /Container -->

</div>
 </div>

      
</div>                            


 
                    <!-- [ content ] End -->

                </div>

 


<?php include('./inc/dash_footer.php'); ?>
<?php include('./inc/footer.php'); ?>
<?php include('app_js.php'); ?>


<style type="text/css">
    body{
        background-color: #fff;
    }
</style>

