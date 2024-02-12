<?php 

    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='marketers';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>


  
<!-- [ Layout content ] Start -->
<div class="layout-content">
      <!-- [ content ] Start -->
      <div class="container-fluid flex-grow-1 container-p-y">
      <h4 class="font-weight-bold py-3 mb-0">Product Marketers</h4>                                                           
      <div class="card-body"  style="   background-color: #f7f7f7;">
            <?php 
              $drow = $db->query("SELECT * FROM posa_marketer limit 50");
            ?>  
               <div class="row">
                        <div class="col-xl-12">
                             <div class="card">                            
                                  <div class="card-datatable table-responsive">
                                      <table class="datatables-demo table table-striped table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>Sn</th>
                                                  <th>Ref Code</th>
                                                  <th>Name</th>
                                                  <th>Email</th>
                                                  <th>State</th>
                                                  <th>City</th>   
                                                  <th>Status</th>
                                                  <th>Referals</th>
                                                  <!-- <th>Action</th> -->
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
                                                      <td><?php echo $row['marketer_id'] ;?></td>
                                                      <td><?php echo $row['name'];?></td>
                                                      <td><?php echo $row['email'];?></td>
                                                      <td><?php echo $row['state'];?></td>
                                                      <td><?php echo $row['city'];?></td>
                                                      <td><?php echo $row['status'];?></td>
                                                      <td><?php echo sf::get_referals($row['marketer_id']); ?></td>
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