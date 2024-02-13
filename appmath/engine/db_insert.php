<?php

class dbi {

	
public static function posa_user( $user_id, $fname, $mname, $lname, $phone, $password, $email, $gender, $state, $address, $status){ 
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO posa_user(`user_id`,`fname`,`mname`,`lname`,`phone`,`password`,`email`,`gender`,`state`,`address`,`status`) VALUES(?,?,?,?,?,?,?,?,?,?,?)'); 
     $stmt->execute(array($user_id,$fname,$mname,$lname,$phone,$password,$email,$gender,$state,$address,$status)); 
} 
// dbi::posa_user($user_id, $fname, $mname, $lname, $phone, $password, $email, $gender, $state, $address, $status); 


 
public static function credit_card( $owner_id, $authorization_code, $signature, $card_type, $last4, $exp_month, $exp_year, $bin, $bank, $country_code, $account_name, $customer_code, $status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO credit_card(`owner_id`,`authorization_code`,`signature`,`card_type`,`last4`,`exp_month`,`exp_year`,`bin`,`bank`,`country_code`,`account_name`,`customer_code`,`status`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
     $stmt->execute(array($owner_id,$authorization_code,$signature,$card_type,$last4,$exp_month,$exp_year,$bin,$bank,$country_code,$account_name,$customer_code,$status));
}
//EXAMPLE// dbi::credit_card($owner_id, $authorization_code, $signature, $card_type, $last4, $exp_month, $exp_year, $bin, $bank, $country_code, $account_name, $customer_code, $status);


public static function package_subscription( $owner_id, $package_id, $sub_date, $exp_date, $status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO package_subscription(`owner_id`,`package_id`,`sub_date`,`exp_date`,`status`) VALUES(?,?,?,?,?)');
     $stmt->execute(array($owner_id,$package_id,$sub_date,$exp_date,$status));
}
//EXAMPLE// dbi::package_subscription($owner_id, $package_id, $sub_date, $exp_date, $status);



public static function payment_info( $owner_id, $reason, $payment_response, $verification_response, $pay_reference, $status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO payment_info(`owner_id`,`reason`,`payment_response`,`verification_response`,`pay_reference`,`status`) VALUES(?,?,?,?,?,?)');
     $stmt->execute(array($owner_id,$reason,$payment_response,$verification_response,$pay_reference,$status));
}
//EXAMPLE// dbi::payment_info($owner_id, $reason, $payment_response, $verification_response,  $pay_reference, $status);



public static function posa_shops( $shop_id, $owner_id, $subscription_id, $shop_name, $shop_address, $shop_state, $shop_city, $shop_status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO posa_shops(`shop_id`,`owner_id`,`subscription_id`,`shop_name`,`shop_address`,`shop_state`,`shop_city`,`shop_status`) VALUES(?,?,?,?,?,?,?,?)');
     $stmt->execute(array($shop_id,$owner_id,$subscription_id,$shop_name,$shop_address,$shop_state,$shop_city,$shop_status));
}
//EXAMPLE// dbi::posa_shops($shop_id, $owner_id, $subscription_id, $shop_name, $shop_phone, $shop_address, $shop_state, $shop_city, $shop_status);



public static function shop_account( $transaction_id, $shop_id, $owner_id, $staff_id, $amount, $charge, $profit, $transaction_cost, $transaction_type, $transaction_name, $bank_or_provider, $extra_info, $dated,$time, $status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO shop_account(`transaction_id`,`shop_id`,`owner_id`,`staff_id`,`amount`,`charge`,`profit`,`transaction_cost`,`transaction_type`,`transaction_name`,`bank_or_provider`,`extra_info`,`dated`,`time`,`status`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
     $stmt->execute(array($transaction_id,$shop_id,$owner_id,$staff_id,$amount,$charge,$profit,$transaction_cost,$transaction_type,$transaction_name,$bank_or_provider,$extra_info,$dated,$time,$status));
}
//EXAMPLE// dbi::shop_account($transaction_id, $shop_id, $owner_id, $staff_id, $amount, $charge, $profit, $transaction_cost, $transaction_type, $transaction_name, $bank_or_provider, $extra_info, $dated, $status);


public static function notification( $action_id, $action_type, $action_details, $user_id, $dated){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO notification(`action_id`,`action_type`,`action_details`,`user_id`,`dated`) VALUES(?,?,?,?,?)');
     $stmt->execute(array($action_id,$action_type,$action_details,$user_id,$dated));
}
//EXAMPLE// dbi::notification($action_id, $action_type, $action_details, $user_id, $dated);


public static function otp_list( $phone, $code, $expired_date, $response){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO otp_list(`phone`,`code`,`expired_date`,`response`) VALUES(?,?,?,?)');
     $stmt->execute(array($phone,$code,$expired_date,$response));
}
//EXAMPLE// dbi::otp_list($phone, $code, $expired_date);


public static function posa_marketer( $marketer_id, $name, $encrypt_id, $email, $state, $city, $status){
     $db=config::dbcon();
     $stmt = $db->prepare('INSERT INTO posa_marketer(`marketer_id`,`name`,`encrypt_id`,`email`,`state`,`city`,`status`) VALUES(?,?,?,?,?,?,?)');
     $stmt->execute(array($marketer_id,$name,$encrypt_id,$email,$state,$city,$status));
}
//EXAMPLE// dbi::posa_marketer($marketer_id, $name, $encrypt_id, $email, $state, $city, $status);




}


?>
