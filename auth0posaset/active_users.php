<?php 

    include('../engine/config.php');
    include('./inc/auth.php');

 $dated =  date('Y-m-d', strtotime('-3 days'));
// echo $dated ;
// die();

    $pageTitle='active_users';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>

  <?php 
              
             

              $drow = $db->query("SELECT * FROM posa_user  where user_type='owner' and user_id IN (select owner_id from shop_account where  transaction_type !='Shop day closed' and dated >= '$dated' group by owner_id )");
                $act_count = $drow->rowCount();
                $total_users = $db->query("SELECT * FROM posa_user where user_type = 'owner' ")->rowCount();
?>
  
<!-- [ Layout content ] Start -->
<div class="layout-content">
      <!-- [ content ] Start -->
      <div class="container-fluid flex-grow-1 container-p-y">
      <h4 class="font-weight-bold py-3 mb-0">POSA ACTIVE USERS  (<?php echo number_format($act_count); ?>  / <?php echo  $total_users; ?>)</h4>
      <small>Users that use our platform for transactions withing the last 3 days</small>                                                           
      <div class="card-body"  style="   background-color: #f7f7f7;">

               <div class="row">
                        <div class="col-xl-12">
                             <div class="card">                            
                                  <div class="card-datatable table-responsive">
                                      <table class="datatables-demo table table-striped table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>Sn</th>
                                                  <th>UserID</th>
                                                  <th>Name</th>
                                                  <th>Email</th>
                                                  <th>State</th>
                                                  <th>Address</th>   
                                                  <th>Package</th>
                                                  <!-- <th>Action</th> -->
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                              $s=0;
                                              while($row = $drow->fetch(PDO::FETCH_ASSOC)){
                                                $s++;
                                                 $pack_id =   cf::selany_plus("package_id","package_subscription","owner_id",$row['user_id'],"status","Active");
                                            ?>
                                                  <tr class="odd gradeX">
                                                      <td><?php echo $s;?></td>
                                                      <td><?php echo $row['user_id'];?></td>
                                                      <td><?php echo $row['fname']. ' '. $row['lname'];?></td>
                                                      <td><?php echo $row['email'];?></td>
                                                      <td><?php echo $row['state'];?></td>
                                                      <td><?php echo $row['address'];?></td>
                                                      <td><?php echo cf::selany("name","package","id",$pack_id );?></td>
                                                      
                                                       <!-- <td> <a href="marketer_details.php?marketer_id=<?php echo $row['marketer_id'] ;?>" ><button class="btn btn-success"><span class="feather icon-chevrons-right"></span></button></a> </td> -->
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