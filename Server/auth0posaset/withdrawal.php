<?php 

    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='withdrawal';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  



function wallet_balance($user_id)
{
$db=config::dbcon();
  $wallet_amount = $db->query("SELECT sum(amount) as amount FROM wallet WHERE user_id='" . $user_id . "' and status ='success'")->fetch(PDO::FETCH_ASSOC);

   if(empty($wallet_amount['amount'])){
    return "0";
  }else{
    return  intval($wallet_amount['amount']);
  }
}



if(isset($_POST['pament_done'])) {
  
  $wallet_id = $_POST['wallet_id'];
  $dated = date("Y-m-d h:i:s A");    
  cf::update('wallet','status','success','id',$wallet_id); 
  cf::mobi_redirect('withdrawal.php');
  echo 'done'; exit;  
}



if(isset($_POST['decline_pay'])) {
  
  $wallet_id = $_POST['wallet_id'];
  $dated = date("Y-m-d h:i:s A");    
  cf::update('wallet','status','declined','id',$wallet_id); 
  cf::mobi_redirect('withdrawal.php');
  echo 'done'; exit;  
}



  

?>


  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y">
                          <h4 class="font-weight-bold py-3 mb-0">Withdrawal Request</h4>
                             
                                      
                                        
                                                <div class="card-body"  style="   background-color: #f7f7f7;">
                                                  <?php 
                                                    $drow = $db->query("SELECT * FROM wallet where type='Wallet Withdrawal' and status ='pending' ");
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
                                    <th>Wallet Balance</th>
                                    <th>Amount</th>
                                    <th>Details</th>                                
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
                                        <td><?php echo cf::selany('fname','posa_user','user_id',$row['user_id']) . " " . cf::selany('lname','posa_user','user_id',$row['user_id']) ;?></td>
                                        <td><?php echo wallet_balance($row['user_id']);?></td>
                                        <td><?php echo $row['amount'];?></td>
                                        
                                        <td><?php echo $row['details'];?></td>
                                       <td>                                         
                                         
                                                     <form   id="pament_done" class="form" method="post">
                                                        <div class="form-row">
                                                          <input type="hidden" name="wallet_id" value="<?php echo $row['id']; ?>">
                                                          <input type="hidden" name="pament_done" value="<?php echo $row['id']; ?>">
                                                        </div>
                                                      </form>

                                                        <form   id="make_decline" class="form" method="post">
                                                        <div class="form-row">
                                                          <input type="hidden" name="wallet_id" value="<?php echo $row['id']; ?>">
                                                          <input type="hidden" name="decline_pay" value="<?php echo $row['id']; ?>">
                                                        </div>
                                                      </form>


                                                      <button class="btn btn-success" onclick="are_you_sure('make_payment_claim','')" name="pament_done">PAYMENT DONE!</button>

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
