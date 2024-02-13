<?php 


include('../engine/config.php');
include('./inc/auth.php');



function subscribe_to_package($owner_id,$pack_id,$sub_mode,$duration)
{

  if(empty($duration)){
      $duration = 1;
    }
        
  $db=config::dbcon();
  $stmt = $db->query("SELECT * FROM package WHERE id='$pack_id'");
  $package = $stmt->fetch(PDO::FETCH_ASSOC);   
  $ddays = $package['duration'];
  $ddays = intval($duration) * intval($ddays );
  $exp_date =  date("Y-m-d h:i:s A",strtotime('+'.$ddays.' Days'));
 
     $sub_date =  date("Y-m-d h:i:s A");  
     cf::update_plus('package_subscription','status','Expired','owner_id',$owner_id,'status','Active');  
     dbi::package_subscription($owner_id, $pack_id, $sub_date, $exp_date, "Active");
     $action_details = "Package Subscription  Successful!";

 

if($pack_id !== '1'){
   $d_referal = cf::selany('referal','posa_user','user_id',$owner_id);
   $ref_user_id = cf::selany('user_id','posa_user','my_ref_id',$d_referal);
   if(!empty($ref_user_id)){
      dbi::wallet($ref_user_id, "Referal Compensation", "50", "success","");
   }
}
    dbi::notification($pack_id, "subscription", $action_details, $owner_id , date("Y-m-d h:i:s A"));
    return "Success";

}




 //subscribe_to_package($owner_id,$pack_id,$sub_mode,$duration)

if(isset($_POST['pament_done'])) {
  
  $proof_id = $_POST['proof_id'];
  $payment_prove = $db->query("SELECT * FROM payment_prove where id = '". $proof_id."' ")->fetch(PDO::FETCH_ASSOC);

  $owner_id = $payment_prove['user_id'];
  $pack_id = $payment_prove['package_id'];
  $sub_mode = "SUB";
  $duration = $payment_prove['duration'];
 

  $action = subscribe_to_package($owner_id,$pack_id,$sub_mode,$duration);

  cf::update('payment_prove','status','success','id',$proof_id); 
  cf::mobi_redirect('bank_payment_sub.php');
  echo 'done'; exit;  
}




if(isset($_POST['decline_pay'])) {
  
  $proof_id = $_POST['proof_id'];
  $db->query("DELETE FROM payment_prove WHERE id='" . $proof_id . "'");
  cf::mobi_redirect('bank_payment_sub.php');
  echo 'done'; exit;  
}



  
$pageTitle='bank_payment_sub';
include('./inc/header.php');     

include('./inc/dash_head.php');  


?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y">
                          <h4 class="font-weight-bold py-3 mb-0">Bank Transfer Subscription</h4>
                             
                                      
                                        
                                                <div class="card-body"  style="   background-color: #f7f7f7;">
                                                  <?php 
                                                    $drow = $db->query("SELECT * FROM payment_prove where status ='pending' ");
                                                  ?>  




  <div class="row">
          <div class="col-xl-12">
               <div class="card">                            
                    <div class="card-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sn</th>
                                    <th>Ticket ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Package Subscription</th>                                
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
                                        <td class="font-weight-bold w3-xlarge"><?php echo $row['ticket_id'];?></td>
                                        <td><?php echo cf::selany('fname','posa_user','user_id',$row['user_id']) . " " . cf::selany('lname','posa_user','user_id',$row['user_id']) ;?></td>
                                        <td><?php echo $row['amount'];?></td>
                                        <td><?php echo cf::selany('phone','posa_user','user_id',$row['user_id']);?></td>                                       
                                        <td>  Name: <?php  echo cf::selany('name','package','id',$row['package_id'])?> <br>
                                             Duration : <?php echo $row['duration']; ?> Month(s) <br> </td>
                                       <td>                                         
                                         
                                                     <form   id="pament_done" class="form" method="post">
                                                        <div class="form-row">
                                                          <input type="hidden" name="proof_id" value="<?php echo $row['id']; ?>">
                                                          <input type="hidden" name="pament_done" value="<?php echo $row['id']; ?>">
                                                        </div>
                                                      </form>

                                                        <form   id="make_decline" class="form" method="post">
                                                        <div class="form-row">
                                                          <input type="hidden" name="proof_id" value="<?php echo $row['id']; ?>">
                                                          <input type="hidden" name="decline_pay" value="<?php echo $row['id']; ?>">
                                                        </div>
                                                      </form>


                                                      <button class="btn btn-success" onclick="are_you_sure('make_payment_claim','')" name="pament_done">APPROVE PAYMENT!</button>

                                                       <button class="btn btn-danger" onclick="are_you_sure('make_decline','')" name="decline_pay">DECLINE PAYMENT!</button>
                                          
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


<script type="text/javascript">
      function make_payment_claim(a) {
        document.getElementById('pament_done').submit();
      }
       function make_decline(a) {
        document.getElementById('make_decline').submit();
      }
</script>
                           
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
