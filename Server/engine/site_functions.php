<?php 
 // Core Functions Class - This class contains the main functions of the website
 // to use, include thsi fiel in any page and refer to its functions like this sf::function_name()

// -------- declare class
class sf {


  public static function get_referals($mem_id) { $db=config::dbcon();
    $stmt = $db->query("SELECT id FROM posa_user where referal ='$mem_id'");
      $data = $stmt->rowCount();
    return $data;
  }



public static function  shop_balance($shop_id,$date ='')
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


public static function  check_closed_shop($shop_id,$owner_id,$ope_id)
{
          $db=config::dbcon();
           $last_t = $db->query("SELECT * FROM shop_account where shop_id = '" . $shop_id  . "' order by id desc limit 1")->fetch(PDO::FETCH_ASSOC );
            $amount = shop_balance($shop_id);
            if(!empty($last_t )){
                $last_d=date_create($last_t['dated']);
                $now_d=date_create(date("Y-m-d"));
                $diff=date_diff($last_d,$now_d);
                // echo $last_t['dated']. "<br>" ;
                // echo date("Y-m-d"). "<br>" ;
                $dat_dif = $diff->format("%a");
                // echo $dat_dif. "<br>" ;
                $dat_dif = intval($dat_dif);
                echo $dat_dif. "<br>" ;
                // die();
                $day= date("d", strtotime($last_t['dated']));
                $month= date("m", strtotime($last_t['dated']));
                $year= date("Y", strtotime($last_t['dated']));
                  

                if($amount != "0"){
                    $amount = (-1 * floatval($amount));
                }

                 $day= intval($day);
                 $dlen= $day + $dat_dif;
                  echo $day. " = DAY<br>" ;
                   echo $amount. " = amount<br>" ;                   
                    echo $last_t['dated'] . " = LAST DAY<br>" ;
                    echo date("Y-m-d") . " = NOW DAY<br>" ;
                  

                if($dat_dif !== 0){
                  for ($i=$day; $i < $dlen ; $i++) { 
                    $transaction_id = cf::get_unique_code('8');
                    $ddate = date("Y-m-d", mktime(11,59,0,$month,$i,$year));
                    $dtime = date("h:i:s A", mktime(11,59,0,$month,$i,$year));
                    
                     dbi::shop_account($transaction_id,$shop_id, $owner_id, $ope_id, $amount, '0', '0','0',  'Shop day closed', 'Shop day closed', '-', '-', $ddate,$dtime, 'Success');
                     $amount = 0;
                  }
                }                
            }

}







}




?>