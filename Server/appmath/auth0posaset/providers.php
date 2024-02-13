<?php 

    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='providers';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  



    

if(isset($_POST['charge_code'])) {
    extract($_POST);
    $ddid= cf::clean_input($ddid); 
    cf::update('providers','charge_code',$charge_code,'id',$ddid);
    cf::mobi_redirect('providers.php');
    echo 'done'; exit;
}

  

?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y">
                          <h4 class="font-weight-bold py-3 mb-0">POSA Providers</h4>
                             
                                      
                                        
                                                <div class="card-body"  style="   background-color: #f7f7f7;">
                                                  <?php 
                                                    $drow = $db->query("SELECT * FROM providers order by charge_type, provider");
                                                  ?>  




  <div class="row">
          <div class="col-xl-12">
               <div class="card">                            
                    <div class="card-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sn</th>
                                     <th>Name</th>
                                    <th>Transaction</th>
                                    <th>Charges</th>                                
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                    $s=0;
                                    while($row = $drow->fetch(PDO::FETCH_ASSOC)){
                                      $s++;
                              ?>

                                    <tr class="odd gradeX">
                                        <td><?php echo $s;?></td>
                                        <td><?php echo $row['provider'];?></td>
                                        <td><?php echo $row['charge_type'];?></td>
                                        <td style="max-width: 150px;" class="">
                                          <div class="pr-4">
                                            <form id="form<?php echo $row['id'];?>" class="form" method="post">
                                            <textarea class="form-control font-weight-bold" style="height: 120px" required name="charge_code"> <?php echo $row['charge_code'];?></textarea>
                                            <input type="hidden" name="ddid" value="<?php echo $row['id'];?>">
                                            </form>

                                            </div>
                                          </td>
                                        <td> 
                                          
                                            <button class="btn btn-success" style="width: 100px" onclick="$('#form<?php echo $row['id'];?>').submit()" > SAVE <span class="feather icon-chevrons-right" ></span></button>
                                            <br><br>
                                          <!--   <button class="btn btn-danger" style="width: 100px"> DELETE <span class="feather icon-chevrons-right" ></span></button> -->
                                          
                                        </td>
                                    </tr>
                              <?php 
                                }
                              ?>
                            </tbody>
                        </table>
                    </div>
                </div>                       
         </div>
  </div>



                           
                                               </div>
                                      
                               
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
