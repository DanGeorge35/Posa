<?php 


    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='payments';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y">
                          <h4 class="font-weight-bold py-3 mb-0">Payments</h4>
                             
                                      
                                        
                                                <div class="card-body"  style="   background-color: #f7f7f7;">
                                                  <?php 
                                                    $paym = $db->query("SELECT * FROM commission_wallet ");
                                                  ?>  


        <div class="row">
              <div class="col-xl-12">
                   <div class="card">                            
                        <div class=" table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                      <th>Type</th>
                                        <th>₦</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>   
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                                  <?php
                                                        $s=0;
                                                        $cap = 0;
                                                        $com=0;
                                                        while($row = $paym->fetch(PDO::FETCH_ASSOC)){
                                                        
                                                        if($row['status'] =="Upcoming"){
                                                            $pay_c = "text-danger";
                                                        }else if($row['status'] =="Pending"){
                                                            $pay_c = "text-warning";
                                                        }else if($row['status'] =="Paid"){
                                                            $pay_c = "text-success";
                                                        }
                                                        
                                                        $dated = date("M jS ", strtotime($row['dated']))
                                                  ?>

                                                        <tr class="odd gradeX">
                                                            <td><?php echo $row['type'];?></td>
                                                            <td>₦<?php echo number_format($row['amount']);?></td>
                                                             <td><?php  echo  $dated;?></td>
                                                             <td class="<?php echo $pay_c; ?>"><?php echo $row['status'];?></td>
                                                             <td>
                                                               <a href="view_payment.php?pay_id=<?php echo $row['id'];?>"><button class="btn btn-success"><span class="feather icon-chevrons-right"></span></button></a>
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
