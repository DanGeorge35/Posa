<?php

if(!empty($_GET['code'])){
	$code = $_GET['code'];
}else{
	$code ="";
}

if(!empty($_POST['make_refer'])){
	require('engine/config.php'); 
	extract($_POST);
	$phone = '+234'.($phone * 1);
	$posa_user = cf::selany('phone','posa_user','phone',$phone); 
	$ref_linker = cf::selany('phone','ref_linker','phone',$phone); 

	if(empty($posa_user)){
		if(empty($ref_linker)){
			 dbi::ref_linker( $phone, $code);
		}
	}
	die();
}


?>
<!DOCTYPE html>
<html lang="eng">
    
<head>
<title>POSA APP</title>
	<!-- You can use Open Graph tags to customize link previews. Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
 	  <meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta property="og:title" content="POSA  |  Your No 1 Pos Accounting Application   ">
    <meta property="og:description" content="POSA  |  Your No 1 Pos Accounting Application  for all mobile money Agents in Nigeria.">
    <meta content='Automate Your POS shop with our POSA app and make smarter decisions by having real-time reports at your fingertips and keeping track of the financial health of your business.' name='description'>
	<!-- SEO-MODEL | WEBSITE INFOMATION SET UP -->
    <meta name="twitter:card" content="POSA  |  Your No 1 Pos Accounting Application ">
    <meta property="og:site_name" content="POSA  |  Your No 1 Pos Accounting Application ">
    <meta name="twitter:image:alt" content="POSA  |  Your No 1 Pos Accounting Application">
	<!-- SEO-MODEL |  IMAGE VIEW -->
    <meta property="og:image" content="https://posaccountant.com/images/icon2.png">
    <img src="https://posaccountant.com/images/icon2.png" style="display: none" alt="POSA  |  Your No 1 Pos Accounting Application">
    <meta name="twitter:image" content="https://posaccountant.com/images/icon2.png">
    <meta property="og:title" content="POSA  |  Your No 1 Pos Accounting Application   ">

    <meta property="fb:app_id" content="283886883185917">
	<meta property="og:url" content="https://posaccountant.com" />
	<meta property="og:type" content="POSA APP" />

	<meta property="og:title"   content="Your Pos Accounting Application for all mobile money Agents in Nigeria." />
	<meta property="og:description"   content="Automate Your POS shop with our POSA app and make smarter decisions by having real-time reports at your fingertips and keeping track of the financial health of your business. " />

	<meta property="og:image"  content="https://posaccountant.com/images/icon2.png" />
	

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>


<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Chango&display=swap" rel="stylesheet">

</head>
<body>

<!-- Load Facebook SDK for JavaScript -->

<!-- <a href="#"   onclick="window.open('https://www.facebook.com/sharer.php?u='+encodeURIComponent('https://posaccountant.com/share?code=3000'), 
      'facebook-share-dialog', 'width=626,height=436'); 
    return false;">  Share on Facebook </a>
 -->
    <div class="pl-3 pr-3" >
    	<div class="row">
    		<div class="col-lg-6 offset-lg-3 p-0">


    			<div class="p-3 bg-warning text-center" style="min-height: 100vh">
    					<div class="text-center pt-3">
				    		<img src="images/icon.png" style="height:60px">
				    		
			   			</div>

			   		<div class="text-white text-center p-4" style="margin-top: 70px">
    					<span class="h4 text-dark" style="font-family: 'Chango', cursive;">DO YOU HAVE A POS SHOP?</span><br><br>
    					<span class="w3-small font-weight-bold">RECIEVE A FREE <br>FULL ACCOUNTING MANAGEMENT SYSTEM ON POSA</span>
    				</div>

    				<!-- <img src="images/email.png" style="width: 100%;position: relative;z-index: 0" > -->
    				<div style="display: block;" id="register_num">

    			<form onsubmit=" return sf_make_refer(this,this.proceed)">
    				<div class="p-3 w3-display-container mt-4" style="border-radius: 20px; background-color: #ffae07;padding-bottom: 30px !important;padding-top: 30px !important;box-shadow: 0px 0px 20px #ffdc75;">
			    			<label class="pl-1 standard_font text-white no-line">Enter Your Phone Number</label>
			    			<input type="number" name="phone" class="form-control" style="padding-left: 100px"  pattern="[0-9]*" >
			    			<span  class="w3-display-left pr-2 border-right" style="margin-left: 30px;margin-top: 12px;">
			    				<img src="images/flag.png" style="height: 14px;"> +234
			    			</span>

			    		</div>

			    		<div class="text-center p-0">
			    			<br>
			    			<button class="btn btn-dark btn-block p-2 border-0" style="background-color: #ffae07;box-shadow: 0px 0px 5px #ffdc75;border-radius: 10px" name="proceed" >PROCEED</button>
			    			
			    		</div>
			    </form>

			   		</div>

			   		<div class="pt-5" style="display: none;" id="google_play">
			   			<span class="h5" style="font-family: 'Chango', cursive;">CONGRATULATION!</span><br>

			   			<div class="text-center p-3 " >
			    		
			    			<center>
			    			<a href="https://play.app.goo.gl/?link=https://play.google.com/store/apps/details?id=com.bb3technologies.posa">
			    				<img src="images/play-store.png"  class="btn-block" style="width: 80%">
			    			</a>
			    			</center>
			    			
			    		</div>
			   		</div>
    				
    			</div>
    		</div>    		
    	</div>
    </div>

<script type="text/javascript">
		function sf_make_refer(dform,btn) {
		code = '<?php echo $code; ?>';
		btn.innerHTML = "LOADING...";
		data = 'make_refer=1&phone='+dform.phone.value +'&code='+code;
	       
	        var execute = new  $.ajax({
	                url: 'share.php',                  
	                type: 'POST',
	                data: data,
	                error: function (xhr, ajaxOptions, thrownError) {
	                    btn.innerHTML ="PROCEED";
	                	return false;     
	                },
	                success: function(result){
		 	                   $('#register_num').hide();
		 	                   $('#google_play').show();
	                	return false;   
	                }
	        });

			return false; 
	}
			

</script>


</body>
</html>