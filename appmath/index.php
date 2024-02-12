<!DOCTYPE html>
<html lang="en">
<head>
  <title>Matheo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>
  <script src="https://apis.google.com/js/api:client.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="">

<?php if($_GET['target'] == '1'){ ?>
	<div class="w3-display-containerp-3 " style="height: 100vh;background-color: #05143e"  onclick = "signup(this)" name="fb_button">
			<div class="w3-display-middle  text-center text-white font-weight-bold" style="width: 100%">
			<img src="images/facebook.png" style="height: 80px"><br><br>
			Click to authorize.
		</div>
	</div>
<?php } ?>
<?php if($_GET['target'] == '2'){ ?>
	<div class="w3-display-container p-3 " id="google_btn" style="height: 100vh;background-color: #05143e" >
		<div class="w3-display-middle text-center text-white font-weight-bold" style="width: 100%">
			<img src="images/google.png" style="height: 80px"><br><br>
			Click to authorize.
		</div>

	</div>
<?php } ?>
</div>

<script type="text/javascript">

	
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '754532705448909',
      xfbml      : true,
      version    : 'v6.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


function checkLoginState() {
      FB.getLoginStatus(function(response) {
        
                if (response.status === 'connected') {
                  // the user is logged in and has authenticated your [response.status === 'not_authorized']
                  // app, and response.authResponse supplies
                  // the user's ID, a valid access token, a signed
                  // request, and the time the access token
                  // and signed request each expire
                 
           
                   gather_data(response);
              

              } else {
                   console.log('User not login or is not authorize.');
              }
      });

}    


function signup(dbutton){
	start_load();
      dbutton.innerHTML='<i class="fa fa-facebook w3-large mr-2 " aria-hidden="true"></i> Connecting to Facebook...';
    FB.login(function(response) {
                    if (response.authResponse) {
                                gather_data(response,0,dbutton);
                    }else{
                         console.log('User cancelled login or did not fully authorize.');
                         dbutton.innerHTML='<i class="fa fa-facebook w3-large mr-2 " aria-hidden="true"></i> Login With Facebook';
                    }

    },{ 'scope':'public_profile,email'});
}



function fb_Log_out() {
   FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.logout(function(response) {
                    
                });
            }
        });
}

function gather_data(response,typ,dbutton){
     dbutton.innerHTML='<i class="fa fa-facebook w3-large mr-2 " aria-hidden="true"></i> Loading Your Account...';
 		    FB.api('/me', {fields: 'first_name,last_name,email,picture'},  function(response) {
		         first_name = response.first_name;
		         last_name = response.last_name;
		         email = response.email;
		         fb_id = response.id; 
		         img_url = "https://graph.facebook.com/"+fb_id+"/picture?type=large";  
		         
		        
		         	type = 'user';
		         	status = 1;
		         


		         $.post("inc/auth.php",{api_login:'facebook',type:type,first_name:first_name,last_name:last_name,email:email,fb_id:fb_id,img_url:img_url,status:status}, function(result,response){
		                  if(response){
		                  	stop_load();
              				localStorage.setItem('member_id', result.member_id);
		                    location.href = location.href = result.redirect;	                            
		                  }
		         });
        
		  });
}



</script>











<!--
	69078337611-af0ph7hu9gkpg8i4bppoalm0kciuqo81.apps.googleusercontent.com
	'
	qObGUPt8vWSvO-aQvOhTdaoA
-->
<script type="text/javascript">
		var googleUser = {};
		var startApp = function() {
			gapi.load('auth2', function(){
			  // Retrieve the singleton for the GoogleAuth library and set up the client.
				  auth2 = gapi.auth2.init({
				    client_id: '69078337611-af0ph7hu9gkpg8i4bppoalm0kciuqo81.apps.googleusercontent.com',
				    cookiepolicy: 'single_host_origin',
				    // Request scopes in addition to 'profile' and 'email'
				    //scope: 'additional_scope'
				  });
			 attachSignin(document.getElementById('google_btn'));
			});
		};
		

		  function attachSignin(element) {
		  		
			    auth2.attachClickHandler(element, {},
				function(googleUser) {
					start_load();
						/*
							console.log('ID: ' + profile.getId());
							console.log('Full Name: ' + profile.getName());
						*/
				         first_name = googleUser.getBasicProfile().getGivenName();
				         last_name = googleUser.getBasicProfile().getFamilyName();
				         email = googleUser.getBasicProfile().getEmail();
				         google_id = googleUser.getBasicProfile().getId();  
				         img_url = googleUser.getBasicProfile().getImageUrl(); 
				         	type = 'user';
				         	status = 1;
				         
						         
				                  
					        $.post("inc/auth.php",{api_login:'google',type:type,first_name:first_name,last_name:last_name,email:email,google_id:google_id,img_url:img_url,status:status}, function(result,response){
					                  if(response){
					                  		stop_load();
              								localStorage.setItem('member_id', result.member_id);
					                      	location.href = result.redirect;	
					                  }
					        });
				                
				
			    }, function(error) {
			     // alert(JSON.stringify(error, undefined, 2));
			    });
		  }


		  function google_Log_out() {
		    var auth2 = gapi.auth2.getAuthInstance();
		    auth2.signOut().then(function () {
		      console.log('User signed out.');
		    });
		  }

</script>


<script>startApp();</script>
</body>
</html>