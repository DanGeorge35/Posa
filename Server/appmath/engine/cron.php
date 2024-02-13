<?php 
	 include('config.php');
$_GET['app_id']='2021posa1234';
 
		  	$stmt = $db->query("SELECT * FROM posa_user WHERE user_type='owner'   ");
		   	while ($user = $stmt->fetch(PDO::FETCH_ASSOC)){
		   		echo $user['fname'] ."<br>";
		   		$dshop = $db->query("SELECT * FROM posa_shops WHERE owner_id='" . $user['user_id'] . "' and shop_status='Active'");
		   		while ($shops = $dshop->fetch(PDO::FETCH_ASSOC)){    
		   			echo $shops['shop_id'] ."<br>";
		   			$shop_id = $shops['shop_id'];
		           $last_t = $db->query("SELECT * FROM shop_account where shop_id = '" . $shop_id  . "' order by id desc limit 1")->fetch(PDO::FETCH_ASSOC );
		            $amount = sf::shop_balance($shop_id);
		            if(!empty($last_t )){

		                $last_d=date_create($last_t['dated']);
		                $now_d=date_create(date("Y-m-d"));
		                $diff=date_diff($last_d,$now_d);
		                echo "<div style='border:1px solid #ddd'> IN ".$shops['shop_name']." <br>";
		                echo $amount."<br>" ;
		                


						$dat_dif = $diff->format("%a");
						echo $dat_dif. "<br>" ;
						$dat_dif = intval($dat_dif);
						echo $dat_dif. "= DAYS DIFF<br>" ;
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
						echo $dlen . " = DAY LENTH<br>" ;

						if($dat_dif !== 0){
		                  for ($i=$day; $i < $dlen ; $i++) { 
		                    $transaction_id = cf::get_unique_code('8');
		                    $ddate = date("Y-m-d", mktime(11,59,0,$month,$i,$year));
		                    $dtime = date("h:i:s A", mktime(11,59,0,$month,$i,$year));
		                    echo $ddate. " = date<br>" ;                    
		                    echo $dtime. " = time<br>" ;                    
		                    dbi::shop_account($transaction_id,$shop_id, $user['user_id'], $user['user_id'], $amount, '0', '0','0',  'Shop day closed', 'Shop day closed', '-', '-', $ddate,$dtime, 'Success');
		                     $amount = 0;
		                  }
		                }else{
		                	echo "<br>none";
		                }     





		                echo "<br> </div>" ;
		               }
		            //sf::check_closed_shop($shops['shop_id'],$user['user_id'],$user['user_id']);
		      	}	
			} 



?>