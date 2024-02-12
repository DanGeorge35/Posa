<?php 

    include('../engine/config.php');
    include('./inc/auth.php');

 
    
    if(!empty($_GET['did'])){
         $view_signal = $db->query("SELECT * FROM advert where id ='" . $_GET['did'] . "'")->fetch(PDO::FETCH_ASSOC);
         if(empty($view_signal)){
          cf::mobi_redirect('dashboard');
          die();
         }
    }

    $pageTitle=$_GET['signal'];  


    if(isset($_POST['add_signal_form'])) {
     //data = 'add_signal_form=1&crypto_name='+sform.crypto_name.value+'&pair='+sform.pair.value+'&open_pr='+sform.open_pr.value+'&stop_loss='+sform.stop_loss.value+'&profit='+sform.profit.value+'&risk='+sform.risk.value+'&comment='+sform.comment.value+'&signal_type='+<?php echo $pageTitle;
    extract($_POST);

    $signal_type = $pageTitle;

         if(empty($logo)){
              $logo ="";
         }
         
           if (0 < $_FILES['inputimg']['error']) {
              
            }else{

              $temp = $_FILES['inputimg']['tmp_name'];
              $type = $_FILES['inputimg']['type'];
              $location = "../advert_image/";

              $filename = $location .$abr.'_'. cf::get_unique_code(5);
              $src = cf::save_image($temp,$location,$filename,$type);

                if(!empty($src)){
                    $img = new imaging;
                    $img->set_img($src);
                    $img->set_size(500);
                    $img->save_img($src);
                    $img->clear_cache();
                    $logo= $src;
                    $type = pathinfo($logo, PATHINFO_EXTENSION);
                    $data = file_get_contents($logo);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                      
                } 
           }

    
         
        if(!empty($logo)){
              $picture= cf::selany('logo','advert','id',$advert_id);
              if(!empty($picture)){
                $ls = cf::countrow('logo','advert','logo',$picture) ;
                  if($ls < 2){
                     if(file_exists($picture)){
                             unlink($picture); 
                      }
                  }
              }

              cf::update('advert','img',$logo,'id',$advert_id);
              cf::update('advert','base64',$base64,'id',$advert_id);
        }
        
         
           
                if(!empty($link)){ 
                  cf::update('advert','link',$link,'id',$advert_id);
                }
              
                if(!empty($type)){ 
                    cf::update('advert','type',$type,'id',$advert_id);
                }

                if(!empty($dated)){ 
                    cf::update('advert','dated',$dated,'id',$advert_id);
                }

                

                cf::update('advert','publish','NO','id',$advert_id);


        echo 'Successfully Done';
    
    cf::mobi_redirect("adverts.php");
    die();
}



    include('./inc/header.php');     

    include('./inc/dash_head.php'); 
 
?>
  
 
                <div class="layout-content">

                    <!-- [ content ] Start -->
                      <div class="container-fluid flex-grow-1 container-p-y p-2">
                          
                             
                            <br>
                         <form  action="" method="post" enctype="multipart/form-data" name="add_signal_form">
                                <div class="p-3">
                                    <div class="p-2 text-center bg-success text-white text-center   mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="success" ></div>
                                    <div class="p-2  text-center bg-danger text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="error"></div>
                                    <div class="p-2  text-center bg-warning text-white text-center mb-2" style="display: none;border-radius:10px;margin-left: -16px;margin-right: -16px;" id="warning"></div>
                                </div>

                            <!-- subscribe start -->
                            <div class="row">

                              <div class="col-lg-8 offset-lg-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>SET ADVERT<h5>
                                    </div>
                                    <div class="card-body">
                                      <div class="row">

                                    

                                    <div class="col-md-12">
                                             <h5 class="text-dark w3-opacity w3-small ">ADS IMAGE:</h5>
                                              <div class="form-group fill mb-0">
                                                <div id="div_img_logo">
                                                   
                                                  <input type="hidden" name="logo"  id="input_logo"  value="">

                                                </div>

                                                <input type="file" class="" id="inputimg"  name="inputimg" style="width: 1px;   height: 1px;  opacity: 0;" onchange="sel_file(this,'image_id','upl_favicon')" accept="image/x-png,image/jpeg" <?php if(empty($view_signal['id'])){ echo "required"; } ?> >

                                                  <label class="bg-light  text-center p-0  mb-0 text-center w3-display-container" for="inputimg" style="border:1px dashed #3b4863;width: 55px; height: 55px; background-size: cover;   background-repeat: no-repeat;    background-position: center;" >

                                                    <?php if(!empty($view_signal['logo'])){ ?>
                                                      <img src="<?php echo $view_signal['logo']; ?>" id="upl_favicon" style="height:56px;" class="w3-display-middle">
                                                    <?php }else{ ?>
                                                     <span class="fas fa-camera w3-display-middle" style="font-size: 30px;" id='upl_favicon'></span>
                                                    <?php } ?>

                                                   <img src="" id="image_id" style="height:56px;display: none;" class="w3-display-middle">


                                                </label>
                                              </div>
                                     </div>

                                      <div class="col-md-12">
                                        <h5 class="text-dark w3-opacity w3-small">Link</h5>
                                        <div class="form-group fill mb-3">
                                            <input type="text" class="form-control"  required name="stop_loss"  value="<?php if(!empty($view_signal['stop_loss'])){ echo $view_signal['stop_loss']; }?>">
                                        </div>
                                      </div>

                                        <div class="col-md-6">
                                         <h5 class="text-dark w3-opacity w3-small">Profit <span>%</span></h5>
                                        <div class="form-group fill mb-3">
                                          <select class="form-control" name="profit">
                                            <?php
                                            if(!empty($view_signal['profit'])){ 
                                              echo '<option value="' . $view_signal['profit'] . '">'.$view_signal['profit'].' %   -- Selected</option>'; 
                                            }
                                              for ($i=1; $i <= 100 ; $i++) { 
                                                echo '<option value="'.$i.'">' . $i.' %</option>';
                                              }
                                            ?>
                                          </select>
                                       
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                         <h5 class="text-dark w3-opacity w3-small">DAYS</h5>
                                        <div class="form-group fill mb-3">
                                           <select class="form-control" name="dated">
                                            <?php
                                              if(!empty($view_signal['dated'])){ 
                                                echo '<option value="'.$view_signal['dated'].'">' . ucwords($view_signal['dated']) . ' -- Selected</option>'; 
                                              }
                                            ?>
                                              <option value="1">1</option>
                                              <option value="7">7</option>
                                              <option value="15">15</option>
                                              <option value="30">30</option>
                                          </select>
                                       
                                        </div>
                                      </div>




                                      <div class="col-md-6">
                                        <h5 class="text-dark w3-opacity w3-small">Buy On</h5>
                                       <div class="form-group fill mb-3">
                                            <input type="text" class="form-control" required name="buy_on" aria-describedby="emailHelp"  value="<?php if(!empty($view_signal['buy_on'])){ echo $view_signal['buy_on']; }?>">
                                        </div>
                                     </div>

                                      <div class="col-md-6">
                                        <h5 class="text-dark w3-opacity w3-small">Store On</h5>
                                        <div class="form-group fill mb-3">
                                            <input type="text" class="form-control"  required name="store_on" value="<?php if(!empty($view_signal['store_on'])){ echo $view_signal['store_on']; }?>">
                                        </div>
                                      </div>

                                      <div class="col-md-12">
                                        <h5 class="text-dark w3-opacity w3-small">Caution</h5>
                                        <div class="form-group fill mb-3">
                                            <textarea type="text" class="form-control" name="caution" required style="height:100px"><?php if(!empty($view_signal['caution'])){ echo $view_signal['caution']; }?></textarea>
                                        </div>
                                  </div>


 

                                      </div>

                                        <button  class="btn btn-success btn-sl-sm" name="save_advert" type="submit">Save Signal</button>
                                        
                                    </div>
                                </div>
                            </div>
                               

                            </div>
                            <!-- subscribe end -->
                          </form>
                       


                </di
                v>

<style type="text/css">
  body{
    background-color: #f7f7f7;
  }
</style>



<?php include('./inc/dash_footer.php'); ?>
<?php include('./inc/footer.php'); ?>
<?php include('app_js.php'); ?>