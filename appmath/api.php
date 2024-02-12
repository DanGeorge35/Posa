<?php
header("Access-Control-Allow-Origin: *");

class Data {
      public $id ="";
      public $user = "";
      public $card = "";
      public $shop = "";
      public $staff = "";
      public $subscription = "";
      public $transaction = "";
      public $providers = "";
      public $banks = "";
      public $packages = "";
      public $note = "";
      public $status = "";
      public $code = "";
      public $notification = "";
      public $redirect  = "";
}


  if(!empty($_GET['app_id'])){$app_id = $_GET['app_id'];
            if($app_id !=='2021posa1234'){
              header('Content-Type: application/json');        
              $data->status= "0";
              $data->note= "Un-authorised Access Code";
              $result = json_encode($data);
              echo $result;
              die();
            }
  }else{
            header('Content-Type: application/json');        
            $data->status= "0";
            $data->note= "Un-authorised Access";
            $result = json_encode($data);
            echo $result;
            die();
  }


 require('engine/config.php'); 

// ---------------TEST----------------------------------------------------------------------------------------------------
    // $paystack_test_secret = "sk_test_1ce50295e90f704a86427b27eb07f8bb26e50b0b";
    // $paystack_test_public = "pk_test_afd95d6e4aa47f6b81e07fe1ac483690f50b5537";
// -------------------------------------------------------------------------------------------------------------------

// // ------------LIVE-------------------------------------------------------------------------------------------------------
    $paystack_test_secret = "sk_live_ac347095871b3f67603da600c50555794229cfef";
    $paystack_test_public = "pk_live_02ee03f65a4d3089915c6c69cf366d788b8f30e1";
// // -------------------------------------------------------------------------------------------------------------------





//sf_add_card
// data = 'sf_verify_card=1'+'&reference='+reference+'&response='+JSON.stringify(response);

if (isset($_POST['sf_verify_card'])) {
      
      extract($_POST);
      $data = new Data();

      if(!empty($phone)){
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);   

        
                $response= verify_payment($reference,$paystack_test_secret);
                
                if(!empty($response)){
                    $dcard = json_decode($response);
                    if($dcard->data->status == "success"){
                        $data->status= "200";
                        $authorization = $dcard->data->authorization;
                        $sig = $authorization->signature;
                        $u_id = $user['user_id'];

                        $sql ="SELECT * FROM credit_card WHERE signature='$sig' and owner_id='$u_id'";
                        $card_exx = $db->query($sql);
                        $card_exist = $card_exx->fetch(PDO::FETCH_ASSOC); 

                        if(empty($card_exist)){
                            dbi::credit_card($user['user_id'], $authorization->authorization_code, $sig , strtolower($authorization->card_type), $authorization->last4, $authorization->exp_month, $authorization->exp_year, $authorization->bin, $authorization->bank, $authorization->country_code, $authorization->account_name, $dcard->data->customer->customer_code, 'Active');
                        }

                       // $refunded_res = make_refund($reference, $paystack_test_secret);

                        if($refunded_res->data->status =="pending"){
                            dbi::payment_info($user['user_id'], "Card Verification", $pay_response, $response, $reference, "Success 2");
                        }else{
                            dbi::payment_info($user['user_id'], "Card Verification", $pay_response, $response, $reference, "Success 1");
                        }

                        if(!empty($pack_id)){
                              subscribe_to_package($user['user_id'],$pack_id,$sub_mode,$paystack_test_secret);
                        }

                        $data->note="Payment Successful";

                    }else{
                         $data->status= "300";
                         dbi::payment_info($user['user_id'], "Card Verification", $pay_response, $response, $reference, "Failed");
                        $data->note= "Payment Failed";
                    }

                  }else{
                       $data->status= "300";
                       dbi::payment_info($user['user_id'], "Card Verification", $pay_response, "Error In Verification", $reference, "Failed");
                      $data->note= "Payment Failed";
                  }


           
            }else{
                 $data->status= "300";
                  $data->note= "Please try login again";
            }


  

      
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die();  
}


function verify_payment($reference,$paystack_test_secret)
{
       $curl = curl_init();
        
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$paystack_test_secret,
                "Cache-Control: no-cache",
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            
            if ($err) {
                 $result= "";
            }else{
                  $result= $response;
            }

            return $result;
}


function make_refund($reference,$paystack_test_secret)
{
       $url = "https://api.paystack.co/refund";
            $fields = [
              'transaction' => $reference
            ];
            $fields_string = http_build_query($fields);
            //open connection
            $ch = curl_init();
            
            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer ".$paystack_test_secret,
              "Cache-Control: no-cache",
            ));
            
            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);             
            //execute post
            $result = curl_exec($ch);
            $response= json_decode($result);
            

            return $response;
}





if (isset($_POST['sub_freetrial'])) {
      
      extract($_POST);
      $data = new Data();

      if(!empty($phone)){
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);   

        if(!empty($email)){
        }
        
            if(!empty($pack_id)){
                subscribe_to_package($user['user_id'],$pack_id,"NEW",$paystack_test_secret);
                $data->status= "200";
            }else{
              $data->status= "300";
            }

      }  


        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die();      

}


function subscribe_to_package($owner_id,$pack_id,$sub_mode,$paystack_test_secret)
{
 
  $db=config::dbcon();
  $stmt = $db->query("SELECT * FROM package WHERE id='$pack_id'");
  $package = $stmt->fetch(PDO::FETCH_ASSOC);   
  $ddays = $package['duration'];
  $exp_date =  date("Y-m-d h:i:s A",strtotime('+'.$ddays.' Days'));
 

   if($sub_mode =="NEW"){
     $sub_date =  date("Y-m-d h:i:s A");  
     cf::update_plus('package_subscription','status','Expired','owner_id',$owner_id,'status','Active');  
     dbi::package_subscription($owner_id, $pack_id, $sub_date, $exp_date, "Active");
     $action_details = "Package Subscription  Successful!";

    }else if($sub_mode !=="UPD"){
     $sub_date =  date("Y-m-d h:i:s A");  
     cf::update_plus('package_subscription','status','Expired','owner_id',$owner_id,'status','Active');  
     dbi::package_subscription($owner_id, $pack_id, $sub_date, $exp_date, "Active");
     $action_details = "Package Subscription  Successful!";
  }else{
    $action_details = "Package Subscription  Successful!";
    cf::update_plus('package_subscription','status','Upgraded','owner_id',$owner_id,'status','Active');  
    $sub_date =  date("Y-m-d h:i:s A");

    dbi::package_subscription($owner_id, $pack_id, $sub_date, $exp_date, "Active");
  }


    dbi::notification($pack_id, "subscription", $action_details, $owner_id , date("Y-m-d h:i:s A"));
    return "Success";
}



if (isset($_POST['sf_verify_package_payment'])) {
      
      extract($_POST);
      $data = new Data();

      if(!empty($phone)){
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);   

        
                $response= verify_payment($reference,$paystack_test_secret);
                
                if(!empty($response)){
                    $dcard = json_decode($response);
                    if($dcard->data->status == "success"){
                        $data->status= "200";
                        $authorization = $dcard->data->authorization;
                        $sig = $authorization->signature;
                        $u_id = $user['user_id'];

                        $sql ="SELECT * FROM credit_card WHERE signature='$sig' and owner_id='$u_id'";
                        $card_exx = $db->query($sql);
                        $card_exist = $card_exx->fetch(PDO::FETCH_ASSOC); 

                        if(empty($card_exist)){
                            dbi::credit_card($user['user_id'], $authorization->authorization_code, $sig , strtolower($authorization->card_type), $authorization->last4, $authorization->exp_month, $authorization->exp_year, $authorization->bin, $authorization->bank, $authorization->country_code, $authorization->account_name, $dcard->data->customer->customer_code, 'Active');
                        }

                      //  $refunded_res = make_refund($reference, $paystack_test_secret);

                        dbi::payment_info($user['user_id'], "Package Subscription", $pay_response, $response, $reference, "Success");
                      
                        if(!empty($pack_id)){
                              subscribe_to_package($user['user_id'],$pack_id,$sub_mode,$paystack_test_secret);
                        }

                        $data->note="Payment Successful";

                    }else{
                       $data->status= "300";
                       dbi::payment_info($user['user_id'], "Package Subscription", $pay_response, "Error In Payment Verification", $reference, "Failed");
                       $data->note= "We cound not verify your payment, Please contact our support.";
                    }

                  }else{
                      $data->status= "300";
                      dbi::payment_info($user['user_id'], "Package Subscription", $pay_response, "Error In Payment Verification", $reference, "Failed");
                      $data->note= "We cound not verify your payment, Please contact our support.";
                  }


           
            }else{
                 $data->status= "300";
                  $data->note= "Please try login again";
            }


  

      
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die();  
}




if (isset($_POST['sf_pay_subscription_used_card'])) {
      $_SESSION['error'] ="";
      header('Content-Type: application/json');  
      extract($_POST);
      $data = new Data();

      if(!empty($phone)){
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  
        $user_id = $user['user_id']; 

        if(!empty($pack_id)){        
           if(update_subscription($user_id,$pack_id,$paystack_test_secret) == true){
              $data->status= "200";
              $data->note= "Successfully Done!";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
           }
        }

      }


        $data->status= "300";
        $data->note=  $_SESSION['error'];
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 

}


function bank_list($paystack_test_secret){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/bank",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer ".$paystack_test_secret,
      "Cache-Control: no-cache",
    ),
  ));
  
  $result = curl_exec($curl);
  $response = json_decode($result);
  return $response ;
}


function update_subscription($user_id,$pack_id,$paystack_test_secret){
    $db=config::dbcon();
    $amount = cf::selany('amount','package','id',$pack_id);
    $package_name = cf::selany('name','package','id',$pack_id);
    $package_status = cf::selany('status','package','id',$pack_id);
        if($package_status == 'open'){
            $posa_user = $db->query("SELECT * FROM `posa_user` WHERE user_id='$user_id'")->fetch(PDO::FETCH_ASSOC);
            $credit_card = $db->query("SELECT * FROM `credit_card` WHERE owner_id='$user_id'")->fetch(PDO::FETCH_ASSOC);
            $amount  = ($amount * 100);
            $url = "https://api.paystack.co/transaction/charge_authorization";
            $fields = [
              'authorization_code' => $credit_card['authorization_code'],
              'email' => $posa_user['email'],
              'amount' => $amount
            ];
            $fields_string = http_build_query($fields);
            //open connection
            $ch = curl_init();
            
            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer ".$paystack_test_secret,
              "Cache-Control: no-cache",
            ));
            
            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
            
            //execute post
            $result = curl_exec($ch);
            $response= json_decode($result);

            if($response->data->status == "success" ){
              dbi::payment_info($user_id, $package_name." Subscription Payment",$response->data->gateway_response, $result, $response->data->reference, "Success");
              subscribe_to_package($user_id,$pack_id,"SUB",$paystack_test_secret);
              return true;
            }else{
              $_SESSION['error'] = "Error processing your payment. Kindly, try with a different card";
              return false;              
            }
          }else{
            $_SESSION['error'] = "Package Closed! Kindly, Choose a different package";
            return false;
          }

}



function   upgrade_subscription($user_id ){
   $db=config::dbcon();
}




function is_sub_active($user_id,$paystack_test_secret)
{
    // return false;
      $db=config::dbcon();
      $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user_id . "' order by id DESC LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
      $days_remain = sub_days_remain($package_sub['id']);

      if( $days_remain > 2 ){
        return true;
      }else if( $days_remain >= 1 ){
        if($package_sub['package_id'] == '1'){
          return true;
        }
        
        return update_subscription($user_id,$package_sub['package_id'],$paystack_test_secret); 
       
      }else{
        if($package_sub['package_id'] == '1'){
          return false;
        }
        return update_subscription($user_id,$package_sub['package_id'],$paystack_test_secret);
      }  
}


function sub_days_remain($id)
{
  $db=config::dbcon();
  $package_sub = $db->query("SELECT * FROM package_subscription WHERE id='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
   $exp_date = $package_sub['exp_date'];
  $exp_date = strtotime($exp_date);
  $timeleft = $exp_date-time();
  $daysleft = round((($timeleft/24)/60)/60);
   return $daysleft ;
}

function  get_provider_charge($damount, $charge, $provider_name)
{

  $db=config::dbcon();
  $stmt = $db->query("SELECT * FROM providers WHERE charge_type='withdrawal' and  provider='" . $provider_name . "'");
  $charge =0;


   while ($Prov = $stmt->fetch(PDO::FETCH_ASSOC)){

      $dcharge = $Prov['charge_code'];
        $dcharge = json_decode($dcharge);
        foreach($dcharge as $item) { 
          
          if($damount >=  floatval($item->a)){
              $pos = strpos($item->charge, '%');
              if ($pos === false) {
                  $charge = $item->charge;
              }else{
                  $charge = substr( $item->charge ,0,-1);
                  $charge =  (floatval($damount) * floatval($charge)) / 100 ;
              }

          }

        }


        
  }

  return $charge;
}



if(isset($_POST['sf_sql_shop_account'])){
              extract($_POST);
              $data = new Data();
              $data->transaction =  get_transaction($sql,3);
              $data->note = $sql; 
              $data->status= "200";                
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die();
}



 if (isset($_POST['sf_search_shop_account'])) {
        extract($_POST);
        $data = new Data();
        $phone= cf::clean_input($phone); 
        $search_trans = cf::clean_input($search_trans ); 
  
        $phone = '+234'.($phone * 1);



        if(empty($status)){
           $status ="All Status";
        }

        if(empty($shop)){
           $shop ="All Shops";
        }

        if(empty($transact_from)){
           $transact_from ="all";
        }
        if(empty($transact_to)){
           $transact_to ="all";
        }
        if(empty($search_trans)){
           $search_trans ="";
        }

        if(empty($category)){
           $category = " and transaction_type !='' ";
        }


        if($status == "All Status"){
          $status =" and status !='' ";
        }else{
          $status =" and status = '$status' ";
        }

        if($shop == "All Shops"){
          $shop =" and shop_id !='' ";
        }else{
          $shop =" and shop_id = '$shop' ";
        }


        if($category == "All Categories"){
          $category =" and transaction_type !='' ";
        }else if($category =="Cash to Shop"){
           $category =" and transaction_type ='add cash to shop' ";
        }else if($category =="Withdrawal"){
           $category =" and transaction_type ='withdrawal' ";
        }else if($category =="Deposit"){
           $category =" and transaction_type ='deposit' ";
        }else if($category =="Bill Payment"){
           $category =" and transaction_type ='bill payment' ";
        }else if($category =="Expenditure"){
           $category =" and transaction_type ='expenditure' ";
        }
 
       

        if($transact_from == "all"){
          $transact_from ="";
        }else{
            $transact_from =" and dated >= '$transact_from' ";
        }

        if($transact_to == "all"){
          $transact_to ="";
        }else{
            $transact_to =" and dated <= '$transact_to' ";
        }
        $limit = " limit 12";
        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'  ")->fetch(PDO::FETCH_ASSOC);

        if(!empty($user)){


            if($user['power'] =='1'){
              $duser_id =   $user['user_id']; //cf::selany('owner_id','shop_account','id',$id);
            }else{
              $duser_id = $user['user_id'] ;
            }

              if($search_trans == ""){
                 $sql = "SELECT * FROM shop_account where id > 0  $status  $shop   $category $transact_from   $transact_to and (staff_id = '". $user['user_id']."' or owner_id = '" . $duser_id . "') order by id desc ";
              }else{
                $ddate = date('Y-m',strtotime($search_trans));
                // $year = date('Y',strtotime($search_trans));
                if($user['power'] =='1'){
                  $duser_id = $user['user_id'] ;//$duser_id =   $user['owner_id'];
                }else{
                  $duser_id = $user['user_id'] ;
                }

                 $sql = "SELECT * FROM shop_account where id > 0 and (staff_id = '". $user['user_id']."' or owner_id = '" . $duser_id . "') and ( (transaction_type like '%$search_trans%') or (transaction_name like  '%$search_trans%')  or (bank_or_provider like '%$search_trans%') or (extra_info like '%$search_trans%') or (status like '%$search_trans%')  or (dated like '%$ddate%')  ) order by id desc ";
              }

              $data->transaction =  get_transaction($sql.$limit,3);
              $data->code = $sql; 
              $data->status= "200";                
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die();

        }else{

              $data->status = "300";   
              $data->note = "No data found";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die();

        }

  }



function get_transaction($user_id,$type)
{       
    $db=config::dbcon();
                                  if($type ==1){
                                    $transaction = $db->query("SELECT * FROM shop_account where owner_id = '" . $user_id . "' order by id desc limit 12")->fetchAll(PDO::FETCH_ASSOC );
                                  }else if($type ==2){
                                      $user = $db->query("SELECT * FROM posa_user where user_id = '".$user_id."'")->fetch(PDO::FETCH_ASSOC);
                                      if($user['power']=='1'){
                                          $transaction = $db->query("SELECT * FROM shop_account where owner_id = '" . $user['owner_id'] . "' order by id desc limit 12")->fetchAll(PDO::FETCH_ASSOC);
                                      }else{
                                          $transaction = $db->query("SELECT * FROM shop_account where staff_id = '".$user_id."' order by id desc limit 12")->fetchAll(PDO::FETCH_ASSOC);
                                      }                                    
                                   }else if($type ==3){
                                    $transaction = $db->query($user_id)->fetchAll(PDO::FETCH_ASSOC );

                                  }else{
                                    $transaction = $db->query("SELECT * FROM shop_account where owner_id = '" . $user_id . "' order by id desc limit 12")->fetchAll(PDO::FETCH_ASSOC );
                                  }
                                    
                                    if(!empty($transaction)){
                                       foreach($transaction as $key => $value) {

                                        $transaction[$key]['dated_time'] = date('F d Y ',strtotime($transaction[$key]['dated'])) . $transaction[$key]['time'] ;

                                           if(date('F d Y',strtotime($transaction[$key]['dated'])) == date('F d Y')){
                                              $transaction[$key]['dated'] = "Today";
                                           }else{

                                                $diff = date_diff( date_create(date('F d Y')) , date_create(date('F d Y',strtotime($transaction[$key]['dated']))) );

                                                $ddiff = $diff->format("%a");
                                                if($ddiff == 1){
                                                   $transaction[$key]['dated'] = "Yesterday";

                                                }else{
                                                   $transaction[$key]['dated'] = date('F d Y',strtotime($transaction[$key]['dated']));
                                                  
                                                }                                             
                                           }

                                            

                                              $transaction[$key]['shop_name'] =  cf::selany('shop_name','posa_shops','shop_id',$transaction[$key]['shop_id'] );

                                              $fname =  cf::selany('fname','posa_user','user_id',$transaction[$key]['staff_id'] );
                                              $lname =  cf::selany('lname','posa_user','user_id',$transaction[$key]['staff_id'] );
                                              $transaction[$key]['staff_name'] = $fname . " " . $lname;

                                            if( $transaction[$key]['transaction_type'] =="withdrawal"){
                                              $transaction[$key]['img'] = "images/withdrawal.png";
                                            }else if( $transaction[$key]['transaction_type'] =="deposit"){
                                              $transaction[$key]['img'] = "images/transfer2.png";
                                            }else if( $transaction[$key]['transaction_type'] =="add cash to shop"){
                                              $transaction[$key]['img'] = "images/add_cash.png";
                                            }else if( $transaction[$key]['transaction_type'] =="expenditure"){
                                              $transaction[$key]['img'] = "images/expenditure.png";
                                            }else if( $transaction[$key]['transaction_type'] =="bill payment"){
                                                $transaction[$key]['transaction_type'] = $transaction[$key]['transaction_name'] ;
                                                if(($transaction[$key]['transaction_name'] == "Airtime") || ($transaction[$key]['transaction_name'] == "Data")){
                                                  $transaction[$key]['transaction_type'] = " Airtime & Data";
                                                  $transaction[$key]['img'] = "images/phone.png";

                                                }else if($transaction[$key]['transaction_name'] == "Tv Subscription"){
                                                  $transaction[$key]['img'] = "images/tv.png";
                                                }else if($transaction[$key]['transaction_name'] == "Electricity"){
                                                  $transaction[$key]['img'] = "images/electricity.png";
                                                }else if($transaction[$key]['transaction_name'] == "Internet Subscription"){
                                                  $transaction[$key]['img'] = "images/internet.png";
                                                }else{
                                                  $transaction[$key]['img'] = "images/subscription.png";
                                                } 
                                              

                                            }
                                            
                                                
                                        }
                                    }
                                      
                        return $transaction;

}


function get_shops($did,$type,$dated='')
{

    $db=config::dbcon();
    if($type ==1){
         $dshop = $db->query("SELECT * FROM posa_shops WHERE owner_id='" . $did. "'")->fetchAll(PDO::FETCH_ASSOC );
    }else{
         $dshop = $db->query("SELECT * FROM posa_shops WHERE shop_id='" . $did . "'")->fetchAll(PDO::FETCH_ASSOC );
    }

      if(!empty($dshop)){
          foreach($dshop as $key => $value) {
                  $dshop[$key]['amount'] = shop_balance($dshop[$key]['shop_id']);
                  $dshop[$key]['available_staff'] = available_staff($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit'] = total_profit($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit_today'] = total_profit_today($dshop[$key]['shop_id']);
                  $dshop[$key]['statistics'] = get_statistics($dshop[$key]['shop_id'], $dated );
          }
          
          return $dshop;
      }else{
          return '';
      }  
}


function get_statistics($shop_id,$dated)
{       


 $db=config::dbcon();
 
 if(empty($dated)){  
  $dated = date("Y-m-d");
 }
 


  $cash_today = $db->query("SELECT sum(amount) as damount FROM shop_account WHERE  amount > 0 and shop_id='" . $shop_id . "'   and status ='Success' and dated like '%".$dated."%'  ")->fetch(PDO::FETCH_ASSOC);



  $today_charge = $db->query("SELECT sum(charge) as charge FROM shop_account WHERE shop_id='" . $shop_id . "' and status ='Success'  and dated like '%".$dated."%' ")->fetch(PDO::FETCH_ASSOC);

  $cash_today = floatval($cash_today['damount']) +  floatval($today_charge['charge']);


 $profit_today = $db->query("SELECT sum(profit) as profit  FROM shop_account WHERE shop_id='" . $shop_id . "' and status ='Success'  and dated like '%".$dated."%' ")->fetch(PDO::FETCH_ASSOC);
  $profit_today = $profit_today['profit'];


  $cash_today =  round($cash_today,2) ;
  $cash_left =  round(shop_balance($shop_id,$dated),2);
  $profit_today = round($profit_today,2) ;

  $profit_chart = $db->query("SELECT sum(profit) as profit, dated FROM shop_account WHERE shop_id='" . $shop_id. "' and status ='Success'  and dated <= '$dated' GROUP by dated order by id desc limit 12")->fetchAll(PDO::FETCH_ASSOC );



  if(!empty($profit_chart)){
     foreach($profit_chart as $key => $value) {
      $profit_chart[$key]['dated'] = date('M d y',strtotime($profit_chart[$key]['dated'])) ;
    }
  }

$profit_chart = array_reverse($profit_chart);

  $transaction_stat = $db->query(" SELECT transaction_type, count(transaction_type) as counter , sum(amount) as total_amount FROM `shop_account`  where status ='Success' and  shop_id='" . $shop_id . "' and dated like '%".$dated."%' GROUP by transaction_type")->fetchAll(PDO::FETCH_ASSOC );


  $statistics = array("cash_today", "cash_left","profit_today", "profit_chart","transaction_stat");
  $statistics = compact($statistics);
  return $statistics;

}





 if (isset($_POST['sf_add_cash'])) {
        extract($_POST);
        $data = new Data();
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
        $transaction_id = cf::get_unique_code('8');
        dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $amount, '0', '0','0',  'add cash to shop', 'Add Cash to ' .$shop['shop_name'] .' - Shop ', '-', '-', date("Y-m-d"),date("h:i:s A"), 'Success');

        if($shop['owner_id'] ==  $user['user_id'] ){
          $users_id =  $user['user_id'];     
          $action_details = "You successfully added ₦".$amount." cash to - " . $shop['shop_name'] . " Shop";
          dbi::notification($transaction_id, "deposit", $action_details, $users_id , date("Y-m-d h:i:s A"));
        }else{
          $users_id = $shop['owner_id'];     
          $action_details = $user['fname'] . " " . $user['lname']." added ₦".$amount." cash to - " . $shop['shop_name'] . " Shop";
          dbi::notification($transaction_id, "deposit", $action_details, $users_id , date("Y-m-d h:i:s A"));
        }        


        $data->status= "200";
        $data->note= "Cash added successfully !";
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}


 if (isset($_POST['sf_save_expenditure'])) {
        extract($_POST);
        $data = new Data();
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);

        if(  floatval(shop_balance($shop['shop_id'])) >= floatval($amount)){
            $extra_info = $reason;
            $transaction_id = cf::get_unique_code('8');
            $action_details =  $user['fname'] . " " . $user['lname']." took  ₦".$amount." cash from ". $shop['shop_name']." - Shop" ;
            $damount = ($amount * -1);
            dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $damount , '0', '0','0', 'expenditure', $action_details , '-', $extra_info , date("Y-m-d"),date("h:i:s A"), 'Success');

            if($shop['owner_id'] ==  $user['user_id'] ){
              $users_id =  $user['user_id'];     
              $action_details = "You took  ₦".$amount." cash from ". $shop['shop_name']." - Shop" ;
              dbi::notification($transaction_id, "expenditure", $action_details, $user['user_id'] , date("Y-m-d h:i:s A"));
            }else{
              dbi::notification($transaction_id, "expenditure", $action_details, $user['user_id'] , date("Y-m-d h:i:s A"));
            }
             $data->status= "200";
             $data->note= "Expenditure Saved !";
        }else{
           $data->status= "300";
           $data->note= "Insufficient fund in shop";
        }        


        
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}


 if (isset($_POST['sf_make_bank_withdrawal'])) {
        extract($_POST);
        $data = new Data();
        
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 

        $withdrawal_form_bank_name = cf::clean_input($bank_name); 
        $amount= cf::clean_input($amount); 
        $charge= cf::clean_input($charge);

        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
        


           $shop_bal = shop_balance($shop_id);

        if( $shop_bal < $amount ){
            $data->status= "300";
            $data->note= "Insufficient fund in shop!";
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die(); 
        }


             
        $transaction_id = cf::get_unique_code('8');
        $damount = ($amount * -1);

        $transaction_cost = 0;
        $profit = floatval($charge) - $transaction_cost;   
        $extra_info = $user['fname'] . " " . $user['lname']." attended to a customer to withdraw ₦".$amount." cash at - " . $shop['shop_name'] . " Shop through Transfer";

        dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $damount, $charge, $profit ,$transaction_cost, 'withdrawal', 'Withdraw cash in '. $shop['shop_name'], $withdrawal_form_bank_name, $extra_info , date("Y-m-d"),date("h:i:s A"), 'Pending');




        $users_id = $shop['owner_id'] . "," . $user['user_id'];
        $action_details = $user['fname'] . " " . $user['lname']." attended to a customer to withdraw ₦".$amount." cash at - " . $shop['shop_name'] . " Shop through Transfer";
        dbi::notification($transaction_id, "withdrawal", $action_details, $users_id , date("Y-m-d h:i:s A"));


        $data->status= "200";
        $data->note= "Successfully Done!";
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}



 if (isset($_POST['sf_make_provider_withdrawal'])) {
        extract($_POST);
        $data = new Data();
        
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 

        $provider_name= cf::clean_input($provider_name); 
        $amount= cf::clean_input($amount); 
        $charge= cf::clean_input($charge);

        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
        

        $shop_bal = shop_balance($shop_id);

        if( $shop_bal < $amount ){
            $data->status= "300";
            $data->note= "Insufficient fund in shop!";
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die(); 
        }


             
        $transaction_id = cf::get_unique_code('8');
        $damount = ($amount * -1);
        $transaction_cost = get_provider_charge($amount, $charge, $provider_name);


        if( $charge <= $transaction_cost ){
            $data->status= "300";
            $data->note= "<b> Invalid charge </b> <br> Must be greater than the transaction cost of <br> ₦ <b>".$transaction_cost."</b>";
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die(); 
        }




        $profit = floatval($charge) - $transaction_cost;   

        $extra_info = $user['fname'] . " " . $user['lname']." attended to a customer to withdraw ₦".$amount." cash at - " . $shop['shop_name'] . " Shop";

        dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $damount, $charge, $profit ,$transaction_cost, 'withdrawal', 'Withdraw cash in '. $shop['shop_name'], $provider_name, $extra_info , date("Y-m-d"),date("h:i:s A"), 'Success');


        $users_id = $shop['owner_id'] . "," . $user['user_id'];
        $action_details = "Deposit of ₦" . $amount . " cash at - " . $shop['shop_name'] . " Awaiting Confirmation";
        dbi::notification($transaction_id, "withdrawal", $action_details, $users_id , date("Y-m-d h:i:s A"));
      


        $data->status= "200";
        $data->note= "Successfully Done!";
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}




 if (isset($_POST['sf_update_shop_account'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and (user_type ='owner' OR power='1') ")->fetch(PDO::FETCH_ASSOC);
          
          if(!empty($user)){
              $status = ucwords($status);
                cf::update('shop_account','status',$status,'id',$id);
                $data->status= "200";
                $data->note= "Successfully Done!";
                  


                // $transaction_id = cf::selany('transaction_id','shop_account','id',$id);
                // $dseen = cf::selany('seen','notification','transaction_id',$transaction_id);
                // $pos = strpos($dseen, $user['user_id']);
                // if ($pos === false) {
                //   if(empty($dseen)){
                //     $dseen = $user['user_id'];
                //   }else{
                //     $dseen = $dseen . "," . $user['user_id'];
                //   }
                //   cf::update('notification','seen',$dseen,'transaction_id',$transaction_id);  
                // }


              $drow=0;
              $stmt = $db->query("SELECT * FROM notification WHERE user_id like '%".$user['user_id']."%' order by id");
               while($not = $stmt->fetch(PDO::FETCH_ASSOC)){
                  $dseen = $not['seen'];
                   $pos = strpos($dseen , $user['user_id']);
                    if ($pos === false) {
                        if(empty($dseen)){
                          $dseen = $user['user_id'];
                        }else{
                          $dseen = $dseen . "," . $user['user_id'];
                        }
                        cf::update('notification','seen',$dseen,'id',$not['id']);  
                    }else{
                        if($drow > 7){
                          $db->query("DELETE FROM notification WHERE id='" . $not['id'] . "' and user_type='staff'");
                        }
                    }

                    $drow = $drow +1;
                }



                $owner_id = $user['user_id'];
                if(empty($sql)){
                  $sql = "SELECT * FROM shop_account where (owner_id = '" . $owner_id . "') or (staff_id = '" . $user['user_id'] . "')   order by id desc limit 12" ;
                }

                $data->transaction =  get_transaction($sql,3);
                $data->code = $sql;
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}


 if (isset($_POST['save_staff_shop'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);
          
          if(!empty($user)){
                cf::update('posa_user','shop_id',$shop_id,'user_id',$user_id);
                $data->status= "200";
                $data->note= "Successfully Done!";
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}


if (isset($_POST['sf_activate_power'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);
          
          if(!empty($user)){
                cf::update('posa_user','power',$power,'user_id',$user_id);
                $data->status= "200";
                $data->note= "Successfully Done!";
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}



if (isset($_POST['sf_seen_note_all'])) {
    header('Content-Type: application/json');   
        extract($_POST);
         $data = new Data();
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $pos = strpos($phone, '+');

        if ($pos === false) {
              $phone = "+".$phone;
        }

        $is_user = cf::countrow('phone','posa_user','phone',$phone);

        if($is_user <= 0) {
          $data->status= "300";
          $data->note= "Account not registered.";
          $result = json_encode($data);
          echo $result;
          die();
        }

        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  
        $drow=0;
        $stmt = $db->query("SELECT * FROM notification WHERE user_id like '%".$user['user_id']."%' order by id");
         while($not = $stmt->fetch(PDO::FETCH_ASSOC)){
            $dseen = $not['seen'];
             $pos = strpos($dseen , $user['user_id']);
              if ($pos === false) {
                if(empty($dseen)){
                  $dseen = $user['user_id'];
                }else{
                  $dseen = $dseen . "," . $user['user_id'];
                }
                cf::update('notification','seen',$dseen,'id',$not['id']);  
              }else{
                if($drow > 7){
                  $db->query("DELETE FROM notification WHERE id='" . $not['id'] . "' and user_type='staff'");
                }
              }

              $drow = $drow +1;
          }


       
        $data->status= "200";
        $result = json_encode($data);
        echo $result;
        die();

}



if (isset($_POST['sf_find_new_noti'])) {

        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
          
        if(!empty($user)){
              $sql = "SELECT * FROM notification where user_id like '%".$user['user_id']."%'  order by id desc limit 4 ";

              

              $notification = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

               if(!empty($notification)){
                   foreach($notification as $key => $value) { 
                          $pos = strpos($notification[$key]['seen'], $user['user_id']);
                          if ($pos === false) {
                           $notification[$key]['action_type'] = strtoupper($notification[$key]['action_type']);
                          }else{
                             unset($notification[$key]);
                          }
                            
                    }
                  }

              $notification = array_values($notification);
              $data->notification = $notification;
              $data->code = $sql;
              $data->status= "200";
              $data->note= "Successfully Done!";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die();

        }else{

              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 

        }
}




if (isset($_POST['sf_delete_user_staff'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);
          
          if(!empty($user)){
                $db->query("DELETE FROM posa_user WHERE user_id='" . $user_id . "' and user_type='staff'");
                $data->status= "200";
                $data->note= "Successfully Done!";
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}



if (isset($_POST['sf_deactivate_act'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);
          
          if(!empty($user)){
                cf::update('posa_user','status',$deactivate,'user_id',$user_id);
                $data->status= "200";
                $data->note= "Successfully Done!";
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}

                

                


 if (isset($_POST['sf_edit_transaction'])) {
        extract($_POST);
        $data = new Data();   
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        // $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);
        
        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and (user_type ='owner' OR power='1') ")->fetch(PDO::FETCH_ASSOC);


          if(!empty($user)){

                

                if (!empty($trans_id)) {
                  if (!empty($amount)) {
                    $damt = cf::selany('amount','shop_account','id',$trans_id);
                    if( intval($damt) < 0){
                      $amount = ($amount * -1);
                    }
                    
                    cf::update('shop_account','amount',$amount,'id',$trans_id);
                  }

                   if (!empty($charge)) {
                    cf::update('shop_account','charge',$charge,'id',$trans_id);
                  }
                   if (!empty($transaction_cost)) {
                    cf::update('shop_account','transaction_cost',$transaction_cost,'id',$trans_id);
                  }
               }
             
                $data->status= "200";
                $data->note= "Successfully Done!";

                if(empty($sql)){
                  $sql = "SELECT * FROM shop_account where owner_id = '" . $user['user_id'] . "' OR  staff_id = '" . $user['user_id'] . "'  order by id desc limit 12" ;
                }
                

                // $owner_id = cf::selany('owner_id','shop_account','id',$trans_id);
                // if(empty($sql)){
                //   $sql = "SELECT * FROM shop_account where owner_id = '" . $owner_id . "' order by id desc limit 12" ;
                // }


                $data->transaction =  get_transaction($sql,3);
                $tra_type = cf::selany('transaction_type','shop_account','id',$trans_id);
                $shop_id = cf::selany('shop_id','shop_account','id',$trans_id);

                dbi::notification($trans_id, $tra_type , "Updated transaction information ", $shop_id , date("Y-m-d h:i:s A"));
                $data->code = $sql;
                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}


function  get_provider_depcharge($damount, $provider_name)
{

  $db=config::dbcon();
  $stmt = $db->query("SELECT * FROM providers WHERE charge_type='deposit' and  provider='" . $provider_name . "'");
  $charge =0;


   while ($Prov = $stmt->fetch(PDO::FETCH_ASSOC)){

      $dcharge = $Prov['charge_code'];
        $dcharge = json_decode($dcharge);
        foreach($dcharge as $item) { 
          
          if($damount >=  floatval($item->a)){
              $pos = strpos($item->charge, '%');
              if ($pos === false) {
                  $charge = $item->charge;
              }else{
                  $charge = substr( $item->charge ,0,-1);
                  $charge =  (floatval($damount) * floatval($charge)) / 100 ;
              }
          }
        }     
  }

  return $charge;
}







 if (isset($_POST['sf_update_provider_deposit'])) {
        extract($_POST);
        $data = new Data();       
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);

        // $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and user_type ='owner' ")->fetch(PDO::FETCH_ASSOC);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone' and (user_type ='owner' OR power='1') ")->fetch(PDO::FETCH_ASSOC);

        $transs = $db->query("SELECT * FROM shop_account WHERE id='$id' ")->fetch(PDO::FETCH_ASSOC);
        $damount = $transs['amount'];

        $dextra_info = json_decode($transs['extra_info']);

        if($provider_name == "Firstmonie"){
           if($dextra_info->bank_name == "First Bank of Nigeria"){
             $provider_name = "Firstmonie-First-Bank";
           }
         }

        $transaction_cost =  get_provider_depcharge($damount ,$provider_name);

        $profit =  floatval($transs['charge']) - floatval($transaction_cost);
          
          if( floatval($transs['charge']) <= $transaction_cost ){
            $data->status= "300";
            $data->note= "<b> Invalid charge </b> <br> Must be greater than the transaction cost of <br> ₦ <b>".$transaction_cost."</b>";
            header('Content-Type: application/json');       
            $result = json_encode($data);
            echo $result;
            die(); 
        }


          if(!empty($user)){
                cf::update('shop_account','transaction_cost',$transaction_cost,'id',$id);
                cf::update('shop_account','profit',$profit,'id',$id);
                cf::update('shop_account','status','Success','id',$id);
                cf::update('shop_account','bank_or_provider',$provider_name,'id',$id);
                $data->status= "200";
                $data->note= "Successfully Done!";
                
                $limit = " limit 12";
                $sql = "SELECT * FROM shop_account where (owner_id = '" . $user['user_id'] . "') OR (staff_id = '" . $user['user_id'] . "') order by id desc ";

                // $owner_id = cf::selany('owner_id','shop_account','id',$id);
                // $sql = "SELECT * FROM shop_account where owner_id = '" . $owner_id . "' order by id desc" ;
                

                $data->transaction =  get_transaction($sql.$limit,3);
                $data->code = $sql;

                header('Content-Type: application/json');       
                $result = json_encode($data);
                echo $result;
                die(); 
          }else{
              $data->status= "300";
              $data->note= "Not authorized";
              header('Content-Type: application/json');       
              $result = json_encode($data);
              echo $result;
              die(); 
          }
}




 if (isset($_POST['sf_make_deposit'])) {
        extract($_POST);
        $data = new Data();
        
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 

        $account_name= cf::clean_input($account_name); 
        $sender_phone= cf::clean_input($sender_phone);
        $bank_name= cf::clean_input($bank_name); 
        $account_number= cf::clean_input($account_number);
        $amount= cf::clean_input($amount); 
        $charge= cf::clean_input($charge);

        $extra_info = array("account_name", "sender_phone","bank_name", "account_number");
        $extra_info = compact($extra_info);
        $extra_info = json_encode($extra_info);  


        $phone = '+234'.($phone * 1);

        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
        
        $transaction_id = cf::get_unique_code('8');
        dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $amount, $charge, '0','0', 'deposit', 'Deposit cash to shop', '-', $extra_info , date("Y-m-d"),date("h:i:s A"), 'Pending');

      

        $users_id = $shop['owner_id'] . "," . $user['user_id'];
        $action_details = "Deposit of ₦".$amount." cash at - " . $shop['shop_name'] . " Awaiting Confirmation";
        dbi::notification($transaction_id, "deposit", $action_details, $users_id , date("Y-m-d h:i:s A"));
      


        $data->status= "200";
        $data->note= "Successfully Done! <br> Awaiting Confirmation";
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}


















 if (isset($_POST['sf_airtime_data'])) {
    $_POST['sf_make_bill'] = 1;
 }

  if (isset($_POST['sf_electricity_data'])) {
    $_POST['sf_make_bill'] = 1;
 }

if (isset($_POST['sf_tv_data'])) {
    $_POST['sf_make_bill'] = 1;
    // company card_number amount charge
 }

  if (isset($_POST['sf_internet_data'])) {
    $_POST['sf_make_bill'] = 1;
    //company number amount charge
 }

  if (isset($_POST['sf_other_sub'])) {
    $_POST['sf_make_bill'] = 1;
    //company about amount charge
 }




 if (isset($_POST['sf_make_bill'])) {
        extract($_POST);
        $data = new Data();
        
        $phone= cf::clean_input($phone); 
        $shop_id= cf::clean_input($shop_id); 

        $bill_type= cf::clean_input($bill_type); 
        $amount= cf::clean_input($amount); 
        $charge= cf::clean_input($charge);
        $utility= $bill_type;
        $amount = cf::clean_input($amount); 


        if(!empty($_POST['sf_airtime_data'])){
                $network_provider = cf::clean_input($network_provider); 
                $comment = cf::clean_input($comment); 
                $customer_phone = cf::clean_input($cusphone); 
                $extra_info = array("utility","customer_phone", "network_provider", "amount", "comment");
                $extra_info = compact($extra_info);
                $extra_info = json_encode($extra_info);

        }else if(!empty($_POST['sf_electricity_data'])){
              // company meter amount charge
               $company = cf::clean_input($company); 
                $meter = cf::clean_input($meter); 
                $extra_info = array("utility","company", "meter", "amount");
                $extra_info = compact($extra_info);
                $extra_info = json_encode($extra_info);
                $network_provider = $company;
        }else if(!empty($_POST['sf_tv_data'])){
                // company card_number amount charge
                $company = cf::clean_input($company); 
                $card_number = cf::clean_input($card_number); 
                $extra_info = array("utility","company", "card_number", "amount");
                $extra_info = compact($extra_info);
                $extra_info = json_encode($extra_info);
                $network_provider = $company;

        }else if(!empty($_POST['sf_internet_data'])){
                //company number amount charge
                $company = cf::clean_input($company); 
                $number = cf::clean_input($number); 
                $extra_info = array("utility", "company", "number", "amount");
                $extra_info = compact($extra_info);
                $extra_info = json_encode($extra_info);
                $network_provider = $company;

        }else if(!empty($_POST['sf_other_sub'])){
                //company about amount charge
                $company = cf::clean_input($company); 
                $about = cf::clean_input($about); 
                $extra_info = array("utility", "company", "about", "amount");
                $extra_info = compact($extra_info);
                $extra_info = json_encode($extra_info);
                $network_provider = $company;

        }


        $phone = '+234'.($phone * 1);
        $user = $db->query("SELECT * FROM posa_user WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
        
             
        $transaction_id = cf::get_unique_code('8');
        $transaction_cost = 0;
        
        $profit = floatval($charge) - $transaction_cost;   
        dbi::shop_account($transaction_id,$shop_id, $shop['owner_id'], $user['user_id'], $amount, $charge, $profit ,$transaction_cost, 'bill payment', $bill_type,   $network_provider, $extra_info , date("Y-m-d"),date("h:i:s A"), 'Pending');



        $users_id = $shop['owner_id'] . "," . $user['user_id'];
        $action_details = " Bill payment of  ₦".$amount." cash at - " . $shop['shop_name'] . " Shop ";
        dbi::notification($transaction_id, "Bill payment", $action_details, $users_id , date("Y-m-d h:i:s A"));


        $data->status= "200";
        $data->note= "Successfully Done!";
        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}







function shop_balance($shop_id,$date ='')
{
  if(!empty($date)){
    $date=" and dated <= '$date'";
  }
  $db=config::dbcon();
  $shop_amount = $db->query("SELECT sum(amount) as amount FROM shop_account WHERE shop_id='" . $shop_id . "' and status ='Success' $date")->fetch(PDO::FETCH_ASSOC);
  $shop_charge = $db->query("SELECT sum(charge) as charge FROM shop_account WHERE shop_id='" . $shop_id . "' and status ='Success' $date")->fetch(PDO::FETCH_ASSOC);

  $Balance = floatval($shop_amount['amount']) +  floatval($shop_charge['charge']);

   if(empty($Balance)){
    return "0";
  }else{
    return $Balance;
  }
}

function available_staff($shop_id)
{
  $db=config::dbcon();
  $user_count = $db->query("SELECT count(id) as id FROM posa_user WHERE shop_id='" . $shop_id . "'")->fetch(PDO::FETCH_ASSOC);
  
  if(empty($user_count['id'])){
    return "0";
  }else{
    return $user_count['id'];
  }
}

function total_profit($shop_id)
{
  $db=config::dbcon();
  $profit = $db->query("SELECT sum(profit) as profit FROM shop_account WHERE shop_id='" . $shop_id . "'")->fetch(PDO::FETCH_ASSOC);
  if(empty($profit['profit'])){
    return "0";
  }else{
    return  number_format($profit['profit'],2);
  }
}



function total_profit_today($shop_id)
{
  $db=config::dbcon();
  $profit = $db->query("SELECT sum(profit) as profit FROM shop_account WHERE shop_id='" . $shop_id . "' and dated ='". date("Y-m-d") ."' ")->fetch(PDO::FETCH_ASSOC);
  if(empty($profit['profit'])){
    return "0";
  }else{
    return  number_format($profit['profit'],2);
  }
}


function total_profit_staff($user_id)
{
  $db=config::dbcon();
  $profit = $db->query("SELECT sum(profit) as profit FROM shop_account WHERE  staff_id='" . $user_id . "'")->fetch(PDO::FETCH_ASSOC);
  if(empty($profit['profit'])){
    return "0";
  }else{
    return number_format($profit['profit'],2);
  }
}


function total_day_profit_staff($user_id)
{
  $db=config::dbcon();
  $profit = $db->query("SELECT sum(profit) as profit FROM shop_account WHERE  staff_id='" . $user_id . "' and dated ='". date("Y-m-d") ."' ")->fetch(PDO::FETCH_ASSOC);
  if(empty($profit['profit'])){
    return "0";
  }else{
    return  number_format($profit['profit'],2);
  }
  
}



function can_add_shop($user_id)
{
  $db=config::dbcon();
 $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user_id . "' and status ='Active' order by id DESC LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
 if(empty($package_sub )){
  return 0;
 }else{
      $posa_shop_num = cf::countrow_plus('owner_id','posa_shops','owner_id',$user_id,'shop_status','Active');
      $shop_limit = cf::selany('shop_limit','package','id',$package_sub['package_id']);
      if($shop_limit > $posa_shop_num ){
        return 1;
      }else if($shop_limit < $posa_shop_num ){
        // $db->query("UPDATE `posa_shops` SET `shop_status` = 'Expired' WHERE owner_id = '" . $user_id . "'");
        return 0;
      }else{
        return 0;
      }

 }
}


function can_add_staff($user_id)
{
  $db=config::dbcon();
 $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user_id . "' and status ='Active' order by id DESC LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
 if(empty($package_sub )){
  return 0;
 }else{
      $posa_staff_num = cf::countrow_plus('owner_id','posa_user','owner_id',$user_id,'user_type','staff');
      $staff = cf::selany('staff_limit','package','id',$package_sub['package_id']);
      if($staff > $posa_staff_num ){
        return 1;
      }else if($staff < $posa_staff_num ){
        //$dcount = $posa_staff_num -$staff;
        //$db->query("UPDATE `posa_shops` SET `shop_status` = 'Expired' WHERE owner_id = '" . $user_id . "' limit 0,".$dcount );
        return 0;
      }else{
        return 0;
      }

 }
}




if (isset($_POST['sf_reg_shop'])) {
//data = 'sf_reg_shop=1&phone='+User_phone +'&shop_name='+dform.shop_name.value+'&shop_number='+dform.shop_number.value+'&state='+dform.state.value+'&city='+dform.city.value+'&address='+dform.address.value;
          extract($_POST);
       if( !empty($shop_name) && !empty( $state ) && !empty( $city ) && !empty( $address )){
        $data = new Data();
        $phone= cf::clean_input($phone); 

        $shop_name= cf::clean_input($shop_name);
        $state= cf::clean_input($state);
        $city= cf::clean_input($city);
        $address= cf::clean_input($address);

         $phone = '+234'.($phone * 1);

              $is_user = cf::countrow('phone','posa_user','phone',$phone);
                if($is_user <= 0) {
                  $data->status= "300";
                  $data->note= "Error authenticating, Please login again.";
                }else{

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);    
                     
                    if($user['user_type'] =='owner'){

                        $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user['user_id'] . "' and status ='Active' order by id DESC LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
                        $shop_id = cf::get_unique_code('6');
                        dbi::posa_shops($shop_id, $user['user_id'], $package_sub['id'], $shop_name, $address, $state, $city, "Active");
                        $data->status= "200";

                    }else{
                         $data->status= "300";
                         $data->note= "Un-authorised Account";
                    }

                }
        }else{
              $data->status= "300";
              $data->note= "Incomplete Data!";
        }

        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}



if (isset($_POST['sf_new_reg_shop'])) {
//data = 'sf_reg_shop=1&phone='+User_phone +'&shop_name='+dform.shop_name.value+'&shop_number='+dform.shop_number.value+'&state='+dform.state.value+'&city='+dform.city.value+'&address='+dform.address.value;
          extract($_POST);
       if( !empty($shop_name) && !empty( $state ) && !empty( $city ) && !empty( $address )){
        $data = new Data();
        $phone= cf::clean_input($phone); 

        $shop_name= cf::clean_input($shop_name);
        $state= cf::clean_input($state);
        $city= cf::clean_input($city);
        $address= cf::clean_input($address);

         $phone = '+234'.($phone * 1);

              $is_user = cf::countrow('phone','posa_user','phone',$phone);
                if($is_user <= 0) {
                  $data->status= "300";
                  $data->note= "Error authenticating, Please login again.";
                }else{

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);    
                     
                    if($user['user_type'] =='owner'){

                        $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user['user_id'] . "' and status ='Active' order by id DESC LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
                        $shop_id = cf::get_unique_code('6');
                        if(can_add_shop( $user['user_id']) > 0){
                          $dstatus ="Active";
                        }else{
                          $dstatus ="Expired";
                        }
                        dbi::posa_shops($shop_id, $user['user_id'], $package_sub['id'], $shop_name, $address, $state, $city, $dstatus);
                        $data->status= "200";

                      $action_details = "Shop successfully added";
                      dbi::notification($shop_id, "shop3", $action_details, $user['user_id'] , date("Y-m-d h:i:s A"));
                      $dshop =  get_shops($user['user_id'],1);
                      $data->shop = $dshop;  

                    }else{
                         $data->status= "300";
                         $data->note= "Un-authorised Account";
                    }

                }
        }else{
              $data->status= "300";
              $data->note= "Incomplete Data!";
        }

        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die(); 
}



if (isset($_POST['sf_activate_shop'])) {

        extract($_POST);
        $data = new Data();
        $shop_id= cf::clean_input($shop_id); 
        $stmt = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'");
        $shop = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($action == '1'){
           if(can_add_shop($shop['owner_id']) > 0){
              $dstatus ="Active";
              cf::update('posa_shops','shop_status',$dstatus,'shop_id',$shop_id);
              $data->status= "200";
              $data->note= "Successfully Activated";
            }else{
              $dstatus ="Expired";
              $data->status= "300";
              $data->note= "You have reached your maximum shop limit, upgrade your package to add more shop";
            }
        }else{
           $dstatus ="Expired";
            cf::update('posa_shops','shop_status',$dstatus,'shop_id',$shop_id);
            $data->status= "200";
            $data->note= "Successfully Deactivated";
        }

        

        $dshop = $db->query("SELECT * FROM posa_shops WHERE owner_id='" . $shop['owner_id']. "'")->fetchAll(PDO::FETCH_ASSOC );
        if(!empty($dshop)){
         foreach($dshop as $key => $value) {      
                  $dshop[$key]['amount'] = shop_balance($dshop[$key]['shop_id']);
                  $dshop[$key]['available_staff'] = available_staff($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit'] = total_profit($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit_today'] = total_profit_today($dshop[$key]['shop_id']);
                  
          }
        }
        $data->shop = $dshop;                                         

        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die();    


     
}


if (isset($_POST['sf_update_shop'])) {

        extract($_POST);
     
        $data = new Data();
        $shop_id= cf::clean_input($shop_id); 
        $shop_name= cf::clean_input($shop_name);
        $shop_address= cf::clean_input($address);
        $shop_state= cf::clean_input($state);
        $shop_city= cf::clean_input($city);

        cf::update('posa_shops','shop_name',$shop_name,'shop_id',$shop_id);  
        cf::update('posa_shops','shop_address',$shop_address,'shop_id',$shop_id);
        cf::update('posa_shops','shop_state',$shop_state,'shop_id',$shop_id);  
        cf::update('posa_shops','shop_city',$shop_city,'shop_id',$shop_id);  
            
        $data->status= "200";
        
        $stmt = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'");
        $shop = $stmt->fetch(PDO::FETCH_ASSOC); 

       $dshop = $db->query("SELECT * FROM posa_shops WHERE owner_id='" . $shop['owner_id']. "'")->fetchAll(PDO::FETCH_ASSOC );
        if(!empty($dshop)){
         foreach($dshop as $key => $value) {      
                  $dshop[$key]['amount'] = shop_balance($dshop[$key]['shop_id']);
                  $dshop[$key]['available_staff'] = available_staff($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit'] = total_profit($dshop[$key]['shop_id']);
                  $dshop[$key]['total_profit_today'] = total_profit_today($dshop[$key]['shop_id']);
                  
          }
        }
        $data->shop = $dshop;                                         

        header('Content-Type: application/json');       
        $result = json_encode($data);
        echo $result;
        die();     
}




 if (isset($_POST['sf_add_new_staff'])) {
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone); 
          $password= cf::clean_input($password);
          $phone = '+234'.($phone * 1);
          $owner_id = cf::selany('user_id','posa_user','phone',$phone);


           if(!empty($user_phone)){
              $user_phone= cf::clean_input($user_phone); 
              $user_phone = '+234'.($user_phone * 1);
              $user_exist = cf::countrow('phone','posa_user','phone',$user_phone);

                if($user_exist >= 1) {
                  $data->status= "300";
                  $data->note= "Phone number already exist.";
                  header('Content-Type: application/json');       
                  $result = json_encode($data);
                  echo $result;
                  die(); 
               }
          }
          
          if(can_add_staff($owner_id) > 0){
                  $user_id = cf::get_unique_code(9);
                  $password =  cf::generate_hash($password);
                dbi::posa_user($user_id, $staff_fname,'',  $staff_lname, $user_phone, $password, '', '', '', '', 'new');
                 cf::update('posa_user','owner_id',$owner_id,'user_id',$user_id);  
                 cf::update('posa_user','shop_id ',$shop_id ,'user_id',$user_id);  
                 cf::update('posa_user','user_type','staff' ,'user_id',$user_id);  
                 $data->status= "200";
                 $data->note= "Successfully Saved";


                  $dstaff = $db->query("SELECT * FROM posa_user WHERE owner_id='" . $owner_id . "'")->fetchAll(PDO::FETCH_ASSOC );
                                      if(!empty($dstaff)){
                                       foreach($dstaff as $key => $value) {      
                                                $dstaff[$key]['total_profit'] = total_profit_staff($dstaff[$key]['user_id']);
                                                $dstaff[$key]['total_day_profit'] = total_day_profit_staff($dstaff[$key]['user_id']);
                                                
                                                  $dstaff[$key]['shop'] = $db->query("SELECT * FROM posa_shops WHERE shop_id='" . $dstaff[$key]['shop_id'] . "'")->fetch(PDO::FETCH_ASSOC);
                                                
                                        }
                                      }
                                      if(!empty($dstaff)){
                                        $data->staff= $dstaff;
                                      }

                              $shop = $db->query("SELECT * FROM posa_shops WHERE shop_id='$shop_id'")->fetch(PDO::FETCH_ASSOC);
                              $action_details = $staff_fname . " ". $staff_lname ." successfully  added as staff to ".  $shop['shop_name'] ." - Shop";
                              dbi::notification($owner_id, "staff", $action_details, $owner_id , date("Y-m-d h:i:s A"));
                              

                              $action_details = "You are successfully  added as staff to ".$shop['shop_name'];
                              dbi::notification($user_id, "staff", $action_details, $user_id , date("Y-m-d h:i:s A"));
                              




          }else{

              $data->status= "300";
               $data->note= "You have reached your maximum staff limit, upgrade your package to add more staff";
                
          }

          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     
  }


if (isset($_POST['sf_update_profile'])) {

        extract($_POST);
       if( !empty($fname) && !empty( $lname ) && !empty( $gender ) && !empty( $email ) && !empty( $state ) && !empty( $address )){
        $data = new Data();
        $phone= cf::clean_input($phone); 
        $fname= cf::clean_input($fname);
        $mname= cf::clean_input($mname);
        $lname= cf::clean_input($lname);
        $state= cf::clean_input($state);
        $email= cf::clean_input($email);
        $address= cf::clean_input($address);

        if(!empty($referal)){
          $referal= cf::clean_input($referal);
        }

        $phone = '+234'.($phone * 1);
        $is_user = cf::countrow('phone','posa_user','phone',$phone);

                if($is_user <= 0) {
                  $data->status= "300";
                  $data->note= "Account not registered.";
                }else{

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);    
                     
                    if($user['user_type'] =='owner'){
                      cf::update('posa_user','fname',$fname,'user_id',$user['user_id']);  
                      cf::update('posa_user','mname',$mname,'user_id',$user['user_id']);
                      cf::update('posa_user','lname',$lname,'user_id',$user['user_id']);  
                      cf::update('posa_user','state',$state,'user_id',$user['user_id']);  
                      cf::update('posa_user','email',$email,'user_id',$user['user_id']);  
                      cf::update('posa_user','gender',$gender,'user_id',$user['user_id']); 
                      cf::update('posa_user','address',$address,'user_id',$user['user_id']);  

                      if(!empty($referal)){
                        cf::update('posa_user','referal',$referal,'user_id',$user['user_id']);  
                      }

                      $data->status= "200";                      
                      $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                      $user = $stmt->fetch(PDO::FETCH_ASSOC); 
                      $data->user = $user;

                    }else{
                         $data->status= "300";
                         $data->note= "Un-authorised Account";
                    }


                }
        }else{
              $data->status= "300";
              $data->note= "Incomplete Data!";
        }

          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     
}




 if (isset($_POST['sf_seen_notification'])) {
        header('Content-Type: application/json');   
        extract($_POST);
         $data = new Data();
        $phone= cf::clean_input($phone); 
        $phone = '+234'.($phone * 1);
        $pos = strpos($phone, '+');

        if ($pos === false) {
              $phone = "+".$phone;
        }

        $is_user = cf::countrow('phone','posa_user','phone',$phone);

        if($is_user <= 0) {
          $data->status= "300";
          $data->note= "Account not registered.";
          $result = json_encode($data);
          echo $result;
          die();
        }

        $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  

        $dseen = cf::selany('seen','notification','id',$id);
        $pos = strpos($dseen, $user['user_id']);
        if ($pos === false) {
          if(empty($dseen)){
            $dseen = $user['user_id'];
          }else{
            $dseen = $dseen . "," . $user['user_id'];
          }
          cf::update('notification','seen',$dseen,'id',$id);  
        }

        $data->status= "200";
        $result = json_encode($data);
        echo $result;
        die();
}





 if (isset($_POST['sf_reset_pass_pin'])) {
      header('Content-Type: application/json');   
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone); 

          $password= cf::clean_input($password);
          $phone = '+234'.($phone * 1);
           $pos = strpos($phone, '+');

            if ($pos === false) {
                  $phone = "+".$phone;
            }

              $is_user = cf::countrow('phone','posa_user','phone',$phone);
                  if($is_user <= 0) {
                    $data->status= "300";
                    $data->note= "Account not registered.";
                    $result = json_encode($data);
                    echo $result;
                    die();
                  }
         
                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);  
                  if(!empty($user['user_id'])){
                    $hash_pass= cf::generate_hash($password);
                    cf::update('posa_user','password',$hash_pass,'user_id',$user['user_id']);  
                    $data->status= "200";
                    $data->note= "Password Successfully Updated";
                    $db->query("DELETE FROM otp_list WHERE phone='" . $phone . "'");
                      $action_details = "Account password successfully updated";
                      dbi::notification($user['user_id'], "user2", $action_details, $user['user_id'] , date("Y-m-d h:i:s A"));
                      
                      

                    $result = json_encode($data);
                    echo $result;
                    die();
                  }
                  
              
      }


 if (isset($_POST['sf_change_pass_pin'])) {
      header('Content-Type: application/json');   
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone); 

          $password= cf::clean_input($password);
          $phone = '+234'.($phone * 1);
           $pos = strpos($phone, '+');

            if ($pos === false) {
                  $phone = "+".$phone;
            }

              $is_user = cf::countrow('phone','posa_user','phone',$phone);
                  if($is_user <= 0) {
                    $data->status= "300";
                    $data->note= "Account not registered.";
                    $result = json_encode($data);
                    echo $result;
                    die();
                  }
         
               
              

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);    

       
                  $user_pass= $user['password'];
                  $hash_pass= cf::generate_hash($password,$user_pass);
                  if ($user_pass !== $hash_pass) {
                        
                    $data->status= "300";
                    $data->note= "Incorrect password.";
                    $result = json_encode($data);
                    echo $result;
                    die();
                  }else{
                      $data->status= "200";
                      $result = json_encode($data);
                      echo $result;
                      die();
                  }
              
      }


 if (isset($_POST['sf_get_shop'])) {
      header('Content-Type: application/json');   
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone);         
           $phone = '+234'.($phone * 1);
           $pos = strpos($phone, '+');
            if ($pos === false) {
                  $phone = "+".$phone;
            }


          if(empty($dated)){
            $dated ="";
          }else{
            $dated = date('Y-m-d',strtotime($dated));
          }
              

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);

                  
                   $data->shop=get_shops($user['user_id'],1,$dated);
                    
                $data->status= "200";
                $result = json_encode($data);
                echo $result;
                die();     

}

 if (isset($_POST['sf_login'])) {
      header('Content-Type: application/json');   
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone); 

          

              if(empty($reload_account)){
                  $password= cf::clean_input($password);
                  $phone = '+234'.($phone * 1);
                  $is_user = cf::countrow('phone','posa_user','phone',$phone);
                  if($is_user <= 0) {
                    $data->status= "500";
                    $data->note= "Account not registered.";
                    $result = json_encode($data);
                    echo $result;
                    die();
                  }
              }else{
                $pos = strpos($phone, '+');

                if ($pos === false) {
                      $phone = "+".$phone;
                }
              }

                  $stmt = $db->query("SELECT * FROM posa_user WHERE phone='$phone'");
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);    

              if(empty($reload_account)){
                  $user_pass= $user['password'];
                  $hash_pass= cf::generate_hash($password,$user_pass);
                  if ($user_pass !== $hash_pass) {
                        
                    $data->status= "500";
                    $data->note= "Incorrect phone or password.";
                    $result = json_encode($data);
                    echo $result;
                    die();
                  }
              }
              if(!empty($user)){
                  $data->user = $user;

                  $data->banks = bank_list($paystack_test_secret);
                  $data->providers_with = $db->query("SELECT * FROM providers where charge_type='withdrawal'")->fetchAll(PDO::FETCH_ASSOC );
                  $data->providers_depo = $db->query("SELECT * FROM providers where charge_type='deposit'")->fetchAll(PDO::FETCH_ASSOC );

                    if($user['user_type'] =='owner'){

                      $package_sub = $db->query("SELECT * FROM package_subscription WHERE owner_id='" . $user['user_id'] . "' order by id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

                        
                        if( empty($user['fname'] ) || empty($user['lname'])  || empty($user['email'])  || empty($user['gender']) || empty($user['state']) || empty($user['address']) ){

                           $data->status= "100";
                           

                        }else{

                          if(empty($package_sub)){
                            $data->status= "300";
                          }else{
                              
                                if(is_sub_active($user['user_id'],$paystack_test_secret)){

                                      $dshop =  get_shops($user['user_id'],1);

                                      $dstaff = $db->query("SELECT * FROM posa_user WHERE owner_id='" . $user['user_id'] . "'")->fetchAll(PDO::FETCH_ASSOC );
                                      if(!empty($dstaff)){
                                       foreach($dstaff as $key => $value) {      
                                                $dstaff[$key]['total_profit'] = total_profit_staff($dstaff[$key]['user_id']);
                                                $dstaff[$key]['total_day_profit'] = total_day_profit_staff($dstaff[$key]['user_id']);
                                                
                                                  $dstaff[$key]['shop'] = $db->query("SELECT * FROM posa_shops WHERE shop_id='" . $dstaff[$key]['shop_id'] . "'")->fetch(PDO::FETCH_ASSOC);
                                                
                                        }
                                      }
                                      if(!empty($dstaff)){
                                        $data->staff= $dstaff;
                                      }



                                    if(!empty($dshop)){
                                      $data->status= "200";
                                      $data->shop=$dshop;

                                       $notification = $db->query("SELECT * FROM notification where user_id like '%".$user['user_id']."%' order by id desc limit  12")->fetchAll(PDO::FETCH_ASSOC );
                                        $data->notification = $notification;



                                    }else{
                                      $data->status= "250";
                                    }






                                }else{
                                   $db->query("UPDATE `package_subscription` SET `status` = 'Expired' WHERE id = '" . $package_sub['id'] . "'");
                                    $db->query("UPDATE `posa_shops` SET `shop_status` = 'Expired' WHERE owner_id = '" . $user['user_id'] . "'");
                                    $data->status= "400";
                                }

                                  $package_sub['package'] = $db->query("SELECT * FROM package WHERE id='" . $package_sub['package_id'] . "'")->fetch(PDO::FETCH_ASSOC);
                                  $package_sub['days_remain'] = sub_days_remain($package_sub['id']);

                                  $data->subscription = $package_sub;

                                  $card = $db->query("SELECT * FROM credit_card where  owner_id='" . $user['user_id'] . "'")->fetchAll(PDO::FETCH_ASSOC);
                                  $data->card = $card;
                                  

                          }
                            
                        }


                        $packages = $db->query("SELECT * FROM package where status ='open'")->fetchAll(PDO::FETCH_ASSOC);

                        $data->packages = $packages;
                      


                        // $data->transaction =  get_transaction($user['user_id'],1);

                        $limit = " limit 12";
                        $sql = "SELECT * FROM shop_account where (owner_id = '" . $user['user_id'] . "')  OR (staff_id = '" . $user['user_id'] . "') order by id desc ";
                        $data->transaction =  get_transaction($sql.$limit,3);
                        $data->code = $sql;


                    }else if( $user['user_type'] =='staff'){
                      
                      if( $user['status'] !== 'deactivate'){
                      $dshop = $db->query("SELECT * FROM posa_shops WHERE shop_id='" . $user['shop_id'] . "'")->fetch(PDO::FETCH_ASSOC);

                        if(!empty($dshop)){
                            
                            if(is_sub_active($dshop['owner_id'],$paystack_test_secret)){
                                if($dshop['shop_status'] =="Active"){
                                   
                                   $dshop = get_shops($user['shop_id'],2);

                                   $data->status= "200";
                                   $data->shop = $dshop;


                                       $notification = $db->query("SELECT * FROM notification where user_id like '%".$user['user_id']."%' order by id desc  limit 12 ")->fetchAll(PDO::FETCH_ASSOC );
                                        $data->notification = $notification;


                                        //$data->transaction =  get_transaction($user['user_id'],2);
                                        $limit = " limit 12";

                                        // if($user['power']=='1'){
                                        //   $sql = "SELECT * FROM shop_account where owner_id = '" . $user['owner_id'] . "' order by  id desc ";
                                        // }else{
                                          $sql = "SELECT * FROM shop_account where shop_id = '" . $user['shop_id'] . "' order by id desc ";
                                        // }
                                        

                                        $data->transaction =  get_transaction($sql.$limit,3);
                                        $data->code = $sql;



                                }else{
                                  $data->status= "500";
                                  $data->note= "Account Deactivated, Please contact shop owner.";
                                }                            
                            }else{
                              $db->query("UPDATE `posa_shops` SET `shop_status` = 'Expired' WHERE owner_id = '" . $dshop['owner_id'] . "'");
                                $data->status= "450";
                                $data->note= "Shop subscription expired";
                            }
                        }else{
                         $data->status= "500";
                         $data->note= "Un-authorised Account";
                        }

                      }else{
                         $data->status= "500";
                         $data->note= "Account Is Deactivated By Shop Owner.";
                      }

                    }else{
                         $data->status= "500";
                         $data->note= "Un-authorised Account";
                    }
                }else{
                  $data->status= "500";
                  $data->note= "Incorrect phone or password.";
                }


          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     
  }




 if (isset($_POST['save_set_pass'])) {
          extract($_POST);
          $data = new Data();
          $phone= cf::clean_input($phone); 
          $password= cf::clean_input($password);
          $phone = '+234'.($phone * 1);

          $is_user = cf::countrow('phone','posa_user','phone',$phone);
          if($set_forget_pass == '1'){

                if($is_user >= 1) {
                  $data->status= "200";
                  $password =  cf::generate_hash($password);
                  cf::update('posa_user','password',$password,'phone',$phone);  
                  $db->query("DELETE FROM otp_list WHERE phone='" . $phone . "'");
                }else{
                  $data->status= "300";
                  $data->note= "Phone number does not exist.";
                }

          }else{

                if($is_user >= 1) {
                  $data->status= "300";
                  $data->note= "Phone number already exist.";
                }else{
                  $data->status= "200";
                  $data->code= $phone;
                  $user_id = cf::get_unique_code(9);
                  $password =  cf::generate_hash($password);
                  dbi::posa_user($user_id, '', '', '', $phone, $password, '', '', '', '', 'new');
                  cf::update('posa_user','user_type','owner','user_id',$user_id);  
                  cf::update('posa_user','shop_id','all','user_id',$user_id);  
                  $db->query("DELETE FROM otp_list WHERE phone='" . $phone . "'");
                }
          }

          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     
  }


 if (isset($_POST['sf_register'])) {

          extract($_POST);
          $data = new Data();

          if(!empty($phone)){

              $phone= cf::clean_input($phone); 
              $phone = '+234'.($phone * 1);
              $is_user = cf::countrow('phone','posa_user','phone',$phone);

                if($is_user >= 1) {

                  $data->status= "300";
                  $data->note= "Phone number already exist.";

                }else{

                    $dotp = cf::countrow('phone','otp_list','phone',$phone);
                    if($dotp >= 1) {
                       $data->status= "200";
                    }else{
                        $data->status= "300";
                        $data->note= "Invalid OTP, Kindly Get another ";
                    }
                }

          }else{

              $data->status= "300";
              $data->note= "Invalid phone number";

          }

          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     

  }




 if (isset($_POST['sf_forget_pass'])) {
          extract($_POST);
          $data = new Data();

          if(!empty($phone)){
              $phone= cf::clean_input($phone); 
              $phone = '+234'.($phone * 1);
              $is_user = cf::countrow('phone','posa_user','phone',$phone);

                if($is_user >= 1) {
                    
                      $data->status= "200";
                      $res  = send_otp($Otp_code,$phone);
                      $data->code = $res;

                      if($res != "done"){
                          if($res != "error"){
                            $data->note="OTP is already sent to this phone number, <br>Kindly use the one sent, Or wait for some hours";
                          }else{
                             $data->note="Your phone number is not recieving OTP, Kindly use another";
                          }
                      }else{
                         $data->note= "Success ". $Otp_code . " sent to ". $phone; 
                      }
                  
                      

                }else{
                  $data->status= "300";
                  $data->note= "Phone number is not registered.";
                }

          }else{
              $data->status= "300";
              $data->note= "invalid phone number";
          }

          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();     
  }

function send_otp($otp,$phone)
{

      $expire = cf::selany('expired_date','otp_list','phone',$phone);
      if(!empty($expire)){
        
        $expire = strtotime($expire);
        $now = strtotime('now');

        if($now > $expire){
            $code= cf::selany('code','otp_list','phone',$phone);
            return $code;            
        }

      }
     $db=config::dbcon();
      $db->query("DELETE FROM otp_list WHERE phone='" . $phone . "'");

      $message = 'Welcome to POSA. Your OTP IS - ' . $otp;
      $senderid = 'POSA';
      $to = $phone;
      $token = '8o6VfFlxHV5LVgbt3DzRzk0K8EqlIltzBNI8OmB4AA3w6CGsOX';
      $baseurl = 'https://app.smartsmssolutions.ng/io/api/client/v1/sms/';

      $sms_array = array 
        (
        'sender' => $senderid,
        'to' => $to,
        'message' => $message,
        'type' => '0',
        'routing' => 2,
        'token' => $token
      );

      $params = http_build_query($sms_array);
      $ch = curl_init(); 

      curl_setopt($ch, CURLOPT_URL,$baseurl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

      $dresponse = curl_exec($ch);
      curl_close($ch);
      $response = json_decode($dresponse);
      $response_code = $response->code;

      if ($response_code == '1000') {
          dbi::otp_list($phone, $otp, date("Y-m-d h:i:s",strtotime('+4 hours')), $dresponse);
          return "done";        
      }
      else
      {
          return "error";
      }

}



 if (isset($_POST['get_otp'])) {

          extract($_POST);
          $data = new Data();

          if(!empty($phone)){
            $phone= cf::clean_input($phone); 
            $phone = '+234'.($phone * 1);

            if(strlen($phone) == 14){

                $is_user = cf::countrow('phone','posa_user','phone',$phone);
                if($is_user >= 1) {
                  $data->status= "300";
                  $data->note= "Phone number already exist.";
                }else{
                  $res  = send_otp($otp,$phone);
                  $data->code = $res;
                  if($res != "done"){
                    if($res != "error"){
                       $data->note="OTP is already sent to this phone number, <br>Kindly use the one sent, Or wait for some hours";
                    }else{
                       $data->note="Your phone number is not recieving OTP, Kindly use another";
                    }
                  }else{
                       $data->note= "Success ". $otp . " sent to ". $phone; 
                  }
                  
                  $data->status= "200";
                  
                }
            }else{
               $data->status= "300";
               $data->note= "Phone number is Invalid";
            }

          }else{
            $data->status= "300";
            $data->note= "Phone number is Invalid";
          }
          header('Content-Type: application/json');       
          $result = json_encode($data);
          echo $result;
          die();
     
   }

   

 




  





if (isset($_POST['update_profile'])) {extract($_POST);
        $data = new Data();
                
        if(!empty($firstname)){$firstname= cf::clean_input($firstname); }else{$incomplete ="1";}
        if(!empty($surname)){$surname= cf::clean_input($surname); }else{$incomplete ="1";}
        if(!empty($phone)){$phone= cf::clean_input($phone); }else{$incomplete ="1";}
        if(!empty($country)){$country= cf::clean_input($country); }else{$incomplete ="1";}
        if(!empty($state)){$state= cf::clean_input($state); }else{$incomplete ="1";}
        if(!empty($city)){$city= cf::clean_input($city); }else{$incomplete ="1";}
    
 
            if (!empty($incomplete)) {
                      header('Content-Type: application/json');             
                      $data->status= "300";
                      $data->note= "Incomplete Data";
                      $result = json_encode($data);
                      echo $result;
                      die();
                    }else{
                      if (empty($login_user)){
                        header('Content-Type: application/json');             
                        $data->status= "300";
                        $data->note= "Please Login to to your account!";
                        $result = json_encode($data);
                        echo $result;
                        die();
                      }else{

                        $country= substr($country,(strpos($country,'~') +1),(strlen($country)-1));
                        cf::update_profile('firstname',$firstname,$login_user['member_id']);
                        cf::update_profile('surname',$surname,$login_user['member_id']);
                        cf::update_profile('phone',$phone,$login_user['member_id']);
                        cf::update_profile('country',$country,$login_user['member_id']);
                        cf::update_profile('state',$state,$login_user['member_id']);
                        cf::update_profile('city',$city,$login_user['member_id']);
                        cf::update_profile('owner_id','owner');
                        
                        header('Content-Type: application/json');       
                        $data->status= "200";
                        $data->redirect = 'account';      
                        $data->note= "Successfully Saved!";
                        $result = json_encode($data);
                        echo $result;
                        die();
                    }
              
        
            }

}




  if (isset($_POST['reset_pass'])) {$data = new Data(); 
        header('Content-Type: application/json');
        extract($_POST);
        $stmt = $db->query("SELECT * FROM property_users WHERE email='$email'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){$dcode= cf::generate_hash($user['member_id']);
                cf::update_profile('code',$dcode,$user['member_id']);
                $code="http://9property.net/reset_pass.php?&dcode=".$dcode;                  
                sm::send_reset_mail($email,$code,$user['firstname']);
                header('Content-Type: application/json');       
                $data->status= "200";
                $data->note= "A reset link has been sent your mail <br> ($email)";
                $result = json_encode($data);
                echo $result;
                die();}else{header('Content-Type: application/json');       
                $data->status= "500";
                $data->note= "Incorrect Or Invalid  email ($email).";
                $result = json_encode($data);
                echo $result;
                die();}
  }




if (isset($_POST['package_purchase'])) {
    header('Content-Type: application/json');  
    extract($_POST);
    $data = new Data();
    $stmt_pk = $db->query("SELECT * FROM package_tb  WHERE id= '" . $package_id ."'");
    $package_tb = $stmt_pk->fetch(PDO::FETCH_ASSOC);
    if(!empty($package_tb)){
        $wallet = sf::total_wallet_value($login_user['member_id']);
        if(intval($wallet) >= intval($package_tb['price'])){
          $dpack_price = (intval($package_tb['price']) * -1);
          dbi::package_sub($login_user['member_id'], $package_id, time(), intval($package_tb['price']),'', 1); 

          dbi::wallet_usr($login_user['member_id'], $dpack_price,"Debited", time(), "PURCHASE OF ".$package_tb['name']." PROMOTIONAL PACKAGE", 'Package ID-'.$package_id);
            
            $data->status= "200";
            $data->note= "Success change Status";
            $result = json_encode($data);
            echo $result;
            die();


        }else{
            $data->status= "300";
            $data->note= "Insufficient Balance";
            $result = json_encode($data);
            echo $result;
            die();
        }

    }
            $data->status= "500";
            $data->note= "Unknown Error";
            $result = json_encode($data);
            echo $result;
            die();
}




// die();

?>

