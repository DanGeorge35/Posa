<?php 


    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='adverts';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>

  
                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y p-2">
                          
                            <div class="p-3">
                            <h4 class="font-weight-bold py-3 mb-0"> STRATEGIC ADVICE </h4>    
                            <center>
                            <a href="add_strategy"> <button class="btn btn-success">Add New Strategic Advice</button>                         </a>
                        </center>
                            </div>   
                            <br>
                            <!-- subscribe start -->
                            <div>
                                
                                    <?php 
                                      $drow = $db->query("SELECT * FROM `adverts` order by id desc");
                                      $total_rec = $drow->rowCount();
                                    ?>  
                                                                    <div class="card">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table id="report-table" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sn</th>
                                                        <th>Advert ID</th>
                                                        <th>Image</th>
                                                        <th>Link</th>
                                                        <th>Publish</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    
                                                <?php
                                                    $a= 0;
                                                    while($row = $drow->fetch(PDO::FETCH_ASSOC)){
                                                      $a++;
                                                ?>

                                                    <tr class="odd gradeX">
                                                          <td><?php echo $a;?></td>
                                                            <td class="align-middle">
                                                                     <?php echo strtoupper($row['adv_id']);?>  
                                                             </td>
                                                           
                                                            <td class="align-middle">
                                                                <?php echo strtoupper($row['img']);?>  
                                                            </td>
                                                             <td class="align-middle">
                                                                <?php echo strtoupper($row['link']);?>  
                                                            </td>
                                                            <td class="align-middle">
                                                                
                                                                <?php if($row['publish'] =='NO'){ ?>
                                                                        <span class="text-danger"><?php echo $row['publish'];?> <i class="fas fa-times "></i> </span> 
                                                                <?php }else{ ?>
                                                                       <span class="text-success"><?php echo $row['publish'];?> <i class="fas fa-check text-success"></i>
                                                                       </span>
                                                                <?php }?>
                                                            </td>
                                                           
                                                        <td class="align-middle">
                                                            <div class="transact form-inline">

                                                                <?php if($row['publish'] =='NO'){ ?>
                                                                 <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure3('set_publish_str','<?php echo $row['id']; ?>','YES','strategy_adv')" style="cursor:pointer;"  class="btn btn-success btn-sm"> Publish  <i class="fas fa-eye"></i></a>
                                                                </div>
                                                            <?php }else{ ?>
                                                                <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure3('set_publish_str','<?php echo $row['id']; ?>','NO','strategy_adv')" style="cursor:pointer;"  class="btn btn-dark btn-sm"> Unpublish  <i class="fas fa-eye-slash"></i></a>
                                                                </div>
                                                            <?php }?>


                                                                <div class="mr-xl-2 mr-1">
                                                                    <a href="add_strategy?signal=<?php echo $pageTitle; ?>&did=<?php echo $row['id'];?> " class="btn btn-info btn-sm"> Open / Edit <i class="far fa-arrow-alt-circle-right"></i></a>
                                                                </div>
                                                                 <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure2('delete_strategy','<?php echo $row['id']; ?>','strategy_adv')" style="cursor:pointer;"  class="btn btn-danger btn-sm"> Delete  <i class="fas fa-trash"></i></a>
                                                                </div>
                                                                


                                                               
                                                            </div>
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
                            <!-- subscribe end -->
                       


                </div>

<style type="text/css">
  body{
    background-color: #f7f7f7;
  }
</style>



<?php include('./inc/dash_footer.php'); ?>
<?php include('./inc/footer.php'); ?>
<?php include('app_js.php'); ?>
 <script src="template/assets/libs/datatables/datatables.js"></script>
    <!-- Demo -->
    
    <script>
        // DataTable start
        $('#report-table').DataTable();
        // DataTable end
    </script>