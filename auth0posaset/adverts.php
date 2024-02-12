<?php 


    include('../engine/config.php');
    include('./inc/auth.php');

    $pageTitle='adverts';  
    include('./inc/header.php');     

    include('./inc/dash_head.php');  

?>

  
                <!-- [ Layout content ] Start -->
                <div class="layout-content pt-4">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y p-2">
                          
                            <div class="p-3">
                            <h4 class="font-weight-bold py-3 mb-0"> ADVERTISEMENT  </h4>    
                           <!--  <center>
                            <a href="add_advert"> <button class="btn btn-success">Add New Advert</button>                         </a>
                        </center> -->
                            </div>   
                            <br>
                            <!-- subscribe start -->
                            <div>
                                
                                    <?php 
                                      $drow = $db->query("SELECT * FROM `advert` order by id ");
                                      $total_rec = $drow->rowCount();
                                    ?>  
                                                                    <div class="card">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table id="report-table" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sn</th>
                                                        <th>Advert Code</th>
                                                        <th style="max-width:200px">Image</th>
                                                        <th tyle="max-width:200px">Link</th>
                                                        <th>Days Remaining</th>
                                                        <th>Publish</th>
                                                        <th>Action</th>
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
                                                                <a href="<?php echo $row['img']; ?>" target="_blank"> <?php echo  substr($row['img'],0,15)."....";?>  
                                                            </td>
                                                             <td class="align-middle">
                                                               <a href="<?php echo $row['link']; ?>"  target="_blank"> <?php echo  substr($row['link'],0,15)."....";?>  </a>
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
                                                                <?php echo   $row['dated'];?>   
                                                            </td>
                                                        <td class="align-middle">
                                                            <div class="transact form-inline">

                                                                <?php if($row['publish'] =='NO'){ ?>
                                                                 <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure3('set_publish','<?php echo $row['id']; ?>','YES','advert')" style="cursor:pointer;"  class="btn btn-success btn-sm"> Publish  <i class="fas fa-eye"></i></a>
                                                                </div>
                                                            <?php }else{ ?>
                                                                <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure3('set_publish','<?php echo $row['id']; ?>','NO','advert')" style="cursor:pointer;"  class="btn btn-dark btn-sm"> Unpublish  <i class="fas fa-eye-slash"></i></a>
                                                                </div>
                                                            <?php }?>


                                                                <div class="mr-xl-2 mr-1">
                                                                    <a href="add_advert.php?did=<?php echo $row['id'];?> " class="btn btn-info btn-sm"> Open / Edit <i class="far fa-arrow-alt-circle-right"></i></a>
                                                                </div>

                                                                <!--  <div class="mr-xl-2 mr-1 text-white">
                                                                    <a onclick="are_you_sure2('delete_advert','<?php echo $row['id']; ?>','advert')" style="cursor:pointer;"  class="btn btn-danger btn-sm"> Delete  <i class="fas fa-trash"></i></a>
                                                                </div> -->
                                                                


                                                               
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



   function delete_advert(did,link) {
       // start_load();
        data = 'delete_advert=1&did='+did;
        var dapproval = new  $.ajax({
                            url: 'app_api.php',                                    
                            type: 'POST',
                            data: data,
                            error: function (xhr, ajaxOptions, thrownError) {
                                // stop_load(); 
                                $("#error").html('Internet Error');
                            },
                            success: function(result){
                                if(result.res =='200'){
                                            location.reload(true);
                                }
                                
                              // stop_load();
                              return false;
                            }
                    });
           return false;
    }

    function set_publish(did,dvalue,link) {
       // start_load();
        data = 'set_publish=1&did='+did + '&dvalue='+dvalue;
        var set_pub = new  $.ajax({
                            url: 'app_api.php',                                    
                            type: 'POST',
                            data: data,
                            error: function (xhr, ajaxOptions, thrownError) {
                                // stop_load(); 
                                $("#error").html('Internet Error');
                            },
                            success: function(result){
                                if(result.res =='200'){
                                            location.reload(true);
                                }
                                
                              // stop_load();
                              return false;
                            }
                    });
           return false;
    }



    </script>