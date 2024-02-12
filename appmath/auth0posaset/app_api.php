<?php
// header("Access-Control-Allow-Origin: *");

class Data {
      public $id ="";
      public $user_id ="";
      public $firstname = "";
      public $surname = "";
      public $email  = "";
      public $note = "";
      public $res = "";
      public $code = "";
      public $redirect  = "";
  }


  // if(!empty($_GET['app_id'])){
  //   $app_id = $_GET['app_id'];
  //   if($app_id !=='202masel'){
  //          header('Content-Type: application/json');        
  //           $data->res= "0";
  //           $data->note= "Un-authorised Access Code";
  //           $result = json_encode($data);
  //           echo $result;
  //           die();
  //         }
  // }else{
  //           header('Content-Type: application/json');        
  //           $data->res= "0";
  //           $data->note= "Un-authorised Access";
  //           $result = json_encode($data);
  //           echo $result;
  //           die();
  //   }



include('../engine/config.php');



if(!empty($_SESSION['redirect'])){$redirect = $_SESSION['redirect'];}

  

    if(!empty($_POST['login_mem'])) {

      extract($_POST);
        $stmt = $db->query("SELECT * FROM users WHERE user_id='$user_id'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($user)){
              $_SESSION['login']= TRUE;
              $_SESSION['user_id']= $user['user_id'];
              $_SESSION['email']= $user['email'];
              echo"good";
              die();
          }else{
              echo"bad";
              die();
          }
       }


 
 if(!empty($_POST['get_states'])) {extract($_POST);
            $data = new Data();
            $data->res= "200";
            $data->note ="<option value=''>--Select State--</option>";

              $loc = new location;
              $country_arr = $loc->get_state_list($dCountry_id);
              $counts = count($country_arr);
               for ($a = 0; $a < $counts; $a++) {$strs =   $country_arr[$a];
                      $data->note = $data->note . '<option value="'.$strs .'">'.$strs .'</option>';
               }
            $result = json_encode($data);
            header('Content-Type: application/json');           
            echo $result;
            die();
    }






if(!empty($_POST['del_vacancy'])) {
    $data = new Data(); 
    extract($_POST);    
    header('Content-Type: application/json');
    cf::delete('vacancy','id',$id);
    $data->note = "Deleted Successfully";
    $data->res= "200";
    $result = json_encode($data);
    echo $result;
    die();
}






if(!empty($_POST['add_video'])) {
    $data = new Data(); 
    extract($_POST);    
    
    dbi::project_video($url, $title, $is_youtube, "Active");

    header('Content-Type: application/json');
    $data->note = "Added Successfully";
    $data->res= "200";
    $result = json_encode($data);
    echo $result;
    die();
}


if(!empty($_POST['delete_video'])) {
    $data = new Data(); 
    extract($_POST);    
    header('Content-Type: application/json');
    cf::delete('project_video','id',$id);
    $data->note = "Deleted Successfully";
    $data->res= "200";
    $result = json_encode($data);
    echo $result;
    die();
}

if(!empty($_POST['delete_picture'])) {
    $data = new Data(); 
    extract($_POST);    
    header('Content-Type: application/json');
    $pimg  =  cf::selany('pict_url','project_picture','id',$pic_id);
    if(file_exists($pimg)){
      unlink($pimg); 
    }
    cf::delete('project_picture','id',$pic_id);
    $data->note = "Deleted Successfully";
    $data->res= "200";
    $result = json_encode($data);
    echo $result;
    die();
}


if(!empty($_POST['toggle_status'])) {
    $data = new Data(); 
    extract($_POST);    
    header('Content-Type: application/json');
    $status  =  cf::selany('status','project_picture','id',$pic_id);
    if($status =="Active"){
      cf::update('project_picture','status','Inactive','id',$pic_id);
    }else{
      cf::update('project_picture','status','Active','id',$pic_id);
    }
    $data->note = "Updated Successfully";
    $data->res= "200";
    $result = json_encode($data);
    echo $result;
    die();
}

if(!empty($_POST['project_pic'])) {
            $data = new Data();         
            extract($_POST);    
            header('Content-Type: application/json');
        
            if (0 < $_FILES['inputimg']['error']) {
              $data->note = "Error Uploading Images";
              $data->res= "0";
              $result = json_encode($data);
              echo $result;
              die();
            }else{

              $temp = $_FILES['inputimg']['tmp_name'];
              $type = $_FILES['inputimg']['type'];
              $location = "../project_pictures/";
              $filename = $location."ppic" . cf::get_unique_code(5);
              $src = cf::save_image($temp,$location,$filename,$type);

                if(!empty($src)){
                      $img = new imaging;
                      $img->set_img($src);
                      $img->set_size(400);
                      $img->save_img($src);
                      $img->clear_cache();
                      $data->note = $src;
                      $dated = date("Y-m-d h:i:s A");
                      dbi::project_picture($src, 'Active');

                    $data->res= "200";
                    $result = json_encode($data);
                    echo $result;
                    die();

                }else{
                    $data->note = "Error Uploading Images";
                    $data->res= "0";
                    $result = json_encode($data);
                    echo $result;
                    die();
                }
            }

}


 


if (isset($_POST['update_password'])) {extract($_POST);
        $data = new Data();                
        if(!empty($old_password)){$old_password= cf::clean_input($old_password); }else{$incomplete ="1";}
        if(!empty($new_passord)){$new_passord= cf::clean_input($new_passord); }else{$incomplete ="1";}
        if(!empty($confirm_password)){$confirm_password= cf::clean_input($confirm_password); }else{$incomplete ="1";}
            if (!empty($incomplete)) {header('Content-Type: application/json');             
                      $data->res= "300";
                      $data->note= "Incomplete Data";
                      $result = json_encode($data);
                      echo $result;
                      die();}else{if (empty($login_user)){header('Content-Type: application/json');             
                      $data->res= "300";
                      $data->note= "Please login to your account!";
                      $result = json_encode($data);
                      echo $result;
                      die();}else{
                          if($new_passord !== $confirm_password){
                          header('Content-Type: application/json');             
                          $data->res= "300";
                          $data->note= "Password not the same";
                          $result = json_encode($data);
                          echo $result;
                          die();
                        }else{
                          $hash_pass= cf::generate_hash($old_password,$login_user['password']);                           
                           if ($hash_pass !== $login_user['password']) {
                                header('Content-Type: application/json');             
                                $data->res= "300";
                                $data->note= "Incorrect Password";
                                $result = json_encode($data);
                                echo $result;
                                die();
                              }else{$newp = cf::generate_hash($new_passord);
                                cf::update_profile('password',$newp,$login_user['user_id']);
                                header('Content-Type: application/json');       
                                $data->res= "200";
                                $data->note= "New password successfully saved!";
                                $result = json_encode($data);
                                echo $result;
                                die();
                              }                              
                      }
                  }
            }
}




if (isset($_POST['make_upload'])) {

  header('Content-Type: application/json');  
    extract($_POST);
    $data = new Data();
    if (empty($login_user)){
        $data->res= "300";
        $data->note= "Please login to to your account!";
        $result = json_encode($data);
        echo $result;
        die();
    }else{

                      $stmt = $db->query("SELECT * FROM property_data WHERE property_id='$property_id'");
                      $prop = $stmt->fetch(PDO::FETCH_ASSOC);
                      
                      if(empty($prop)){
                            $data->res= "300";
                            $data->note= "<span>Invalid Property Authentication.</span>";
                            $result = json_encode($data);
                            echo $result;
                            die();
                        }else{

                                if($prop['owner'] !== $login_user['user_id']){
                                        $data->res= "300";
                                        $data->note= "<span> Invalid Property User</span>";
                                        $result = json_encode($data);
                                        echo $result;
                                        die();
                                }else{

                                  if (0 < $_FILES['inputimg']['error']) {
                                      $data->note = "Error Uploading Images";
                                      $data->res= "300";
                                      $result = json_encode($data);
                                      echo $result;
                                      die();
                                  }else{

                                    $temp = $_FILES['inputimg']['tmp_name'];
                                    $type = $_FILES['inputimg']['type'];
                                    $location="user_uploads/";  
                                    $filenam = "9property_role".$role."_" . cf::get_unique_code(5);
                                    $filename = $location.$filenam;
                                    $src = cf::save_image($temp,$location,$filename,$type);

                                      if(!empty($src)){
                                          $img = new imaging;
                                          $img->set_img($src);
                                          $img->set_size();
                                          $img->save_img($src);
                                          $img->clear_cache();
                                          $picture  =  cf::selany_plus('pic','property_pic','p_id',$property_id,'role',$role);
                                          $str_ln= strlen($location);
                                          $filenamss = substr($src,$str_ln,strlen($src));

                                          if(!empty($picture)){
                                                $picture  = $picture;
                                                if(file_exists($picture)){
                                                  unlink($picture); 
                                                }

                                                cf::update_plus('property_pic','pic',$filenamss,'user_id',$login_user['user_id'],'role',$role);
                                                $data->note = "Property Updated Successfully";
                                                $data->res= "200";
                                                $result = json_encode($data);
                                                echo $result;
                                                die();

                                          }else{

                                              $pic_id= cf::get_unique_code(8);
                                              $upl_date= date("Y-m-d h:i:s");
                                              
                                              dbi::property_pic($property_id, $login_user['user_id'],$pic_id,$role, $filenamss, $upl_date,1);  
                                              $data->note = "Property  Successfully Saved";
                                              $data->res= "200";
                                              $result = json_encode($data);
                                              echo $result;
                                              die();
                                          }
                                         

                                      }else{
                                          $data->note = "Error Uploading Images";
                                          $data->res= "300";
                                          $result = json_encode($data);
                                          echo $result;
                                          die();
                                      }
                                  }


                                }

                        }



            }

    }




    if (isset($_POST['contact_us'])) {
        extract($_POST);
        $data = new Data();
        if(!empty($name)){$name= cf::clean_input($name); }
        if(!empty($email)){$email= cf::clean_input($email); }
        if(!empty($phone)){$phone= cf::clean_input($phone); }
        if(!empty($subject)){$subject= cf::clean_input($subject); }
        if(!empty($message)){$message= cf::clean_input($message); }
        $date= date("Y-m-d h:i:s A");      
        dbi::contact_us($name, $email, $phone, $subject, $message, $date);
        sm::send_contact_us_mail($name, $email, $subject); 
        header('Content-Type: application/json');       
        $data->res = "200";
        $data->note = "Successfully Sent. Response will be Sent to your email.";
        $data->redirect = $homepage.'contact';
        $result = json_encode($data);
        echo $result;
        die();
    }



die();

?>

