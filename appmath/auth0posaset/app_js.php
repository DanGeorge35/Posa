<script type="text/javascript">
	function contact_us(sform) {
		$("#success").hide();
		$("#error").hide();
		$("#warning").hide();
		////start_load();
		capt =  "<?php  if(!empty($_SESSION["captcha_code"])){ echo $_SESSION["captcha_code"]; } ?>";
		capt = capt.toString();

		if( sform.captcha.value !== capt ){
			$("#error").html('Please enter the correct captcha code');
			$("#error").slideDown("fast");
			sform.captcha.focus();
			return false;
		}
 

		if(sform.name.value !=='' && sform.email.value !=='' && sform.phone.value !=='' && sform.subject.value !=='' && sform.message.value !=='' ){						
						 	type = 'user';
						 	status = 1;
							data = 'contact_us=1&name='+sform.name.value+'&email='+sform.email.value+'&phone='+sform.phone.value+'&subject='+ sform.subject.value+'&message='+sform.message.value; 

							var login = new  $.ajax({
							                            url:  'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	////stop_load(); 
							                            	$("#error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		$("#success").html(result.note);
							                            		$("#success").slideDown("fast");
							                            		$("#success").focus();
							                            		window.scrollTo(0,0);
							                            		setTimeout(function(){ location.href = result.redirect; }, 2000);  
							                            	}else if(result.res =='300'){
							                            		$("#warning").html(result.note);
							                            		$("#warning").slideDown("fast");						
							                            		$("#warning").focus();
							                            		window.scrollTo(0,0);

							                            	}else{
							                            		$("#error").html(result.note);
							                            		$("#error").slideDown("fast");
							                            		window.scrollTo(0,0);
							                            	}
														
														////stop_load();
							                            return false;

															
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}
			return false;
		}





function request_visitation(sform) {
		if(sform.date.value.trim() !=='' && sform.time.value.trim() !==''){					
						 	type = 'user';
						 	status = 1;
							data = 'request_visitation=1&date='+sform.date.value.trim()+'&time='+sform.time.value.trim();
							var investment_slot = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	//// stop_load(); 
							                            	// $("#error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	location.reload(true);
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}else{
							alert('fill all required data');
						}
			return false;
}


function undo_request(visit_id) {
		if(visit_id !==''){					
						 	type = 'user';
						 	status = 1;
							data = 'undo_request=1&visit_id='+visit_id;
							var investment_slot = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	//// stop_load(); 
							                            	// $("#error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	location.reload(true);
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
		}else{
			alert('fill all required data');
		}
			return false;
}



function del_vacancy(id) {
		
						 	type = 'user';
						 	status = 1;
							data = 'del_vacancy=1&id='+id;
							var investment_slot = new  $.ajax({
		                            url: 'app_api.php',
		                            type: 'POST',
		                            data: data,
		                            error: function (xhr, ajaxOptions, thrownError) {
		                            	//// stop_load(); 
		                            	// $("#error").html('Internet Error');
		                            },
		                            success: function(result){
		                            	location.href = "vacancy.php";
		                            }
		                           //timeout: 20000 // sets timeout to  seconds
		                    });
	

			return false;
}



function save_profile(sform) {

	if(sform.fname.value.trim() !=='' && sform.lname.value.trim() !=='' && sform.email.value !==''  && sform.address.value !==''  && sform.phone.value.trim() !==''  && sform.gender.value.trim() !=='' && sform.dob.value.trim() !==''){			

			data = 'save_profile=1&fname='+sform.fname.value.trim()+'&lname='+sform.lname.value.trim()+'&email='+sform.email.value+'&phone='+sform.phone.value.trim()+'&address='+sform.address.value+'&gender='+sform.gender.value.trim()+'&dob='+sform.dob.value.trim();

							var save_profile_form = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {

							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                                  	save_data_alert('Profile saved successfully');
							                            	
							                            	}
														
								                            return false;															
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}else{
							alert('fill all required data');
						}
			return false;
}



function save_nok(sform) {

	if(sform.nok_fname.value.trim() !=='' && sform.nok_lname.value.trim() !=='' && sform.nok_email.value !==''  && sform.nok_address.value !==''  && sform.nok_phone.value.trim() !==''  && sform.nok_relation.value.trim() !==''){			
 
    
			data = 'save_nok=1&nok_fname='+sform.nok_fname.value.trim()+'&nok_lname='+sform.nok_lname.value.trim()+'&nok_email='+sform.nok_email.value+'&nok_phone='+sform.nok_phone.value.trim()+'&nok_address='+sform.nok_address.value+'&nok_relation='+sform.nok_relation.value.trim();
			

							var save_nok_form = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {

							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                                  	save_data_alert('Profile saved successfully');
							                            	}
								                            return false;															
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;							 
						}else{
							alert('fill all required data');
						}
			return false;
}

 
function  confirm_rave_pay(transaction_id,user_id,ref_code,amount) {
	
			data = 'confirm_rave_pay=1&transaction_id='+transaction_id+'&user_id='+user_id+'&inv_code='+ref_code;+'&amount='+amount;
			var login = new  $.ajax({
		                            url:  'app_api.php',
		                            type: 'POST',
		                            data: data,
		                            error: function (xhr, ajaxOptions, thrownError) {
		                        			
		                            },
		                            success: function(result){
		                            	location.reload();                            	 			                            															
	                            	}
	                           //timeout: 20000 // sets timeout to  seconds
                    });
}



     function update_password(sform) {
     	$("#pass_error").html('');
            if(sform.old_pass.value !=='' && sform.new_pass.value !=='' && sform.c_pass.value !=='' ){

                if( sform.new_pass.value !== sform.c_pass.value){
                    $("#pass_error").html('Password not the same');
                    return false;
                }
                
                data = 'update_password=1&old_password='+sform.old_pass.value+'&new_passord='+sform.new_pass.value+'&confirm_password='+sform.c_pass.value;

                            var login = new  $.ajax({
                                                        url: 'app_api.php',
                                                        type: 'POST',
                                                        data: data,
                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                            $("#pass_error").html('Internet Error');
                                                        },
                                                        success: function(result){
                                                            if(result.res =='200'){
                                                                  save_data_alert('Password saved successfully');
                                                                  
                                                            }else{
                                                                    $("#pass_error").html(result.note);
                                                            }
                                                        
                                                        }
                                                       //timeout: 20000 // sets timeout to  seconds
                                                });
                               return false;
                             
                        }
            return false;
        }

        


function buy_investment_slot(sform) {
		if(sform.fname.value.trim() !=='' && sform.lname.value.trim() !=='' && sform.email.value !==''  && sform.address.value !==''  && sform.phone.value.trim() !==''  && sform.bank_name.value.trim() !=='' && sform.account_name.value.trim() !=='' && sform.account_number.value !=='' && sform.inv_amount.value !==''){					
						 	type = 'user';
						 	status = 1;
							data = 'buy_investment_slot=1&fname='+sform.fname.value.trim()+'&lname='+sform.lname.value.trim()+'&email='+sform.email.value+'&phone='+sform.phone.value.trim()+'&address='+sform.address.value+'&bank_name='+sform.bank_name.value.trim()+'&account_name='+sform.account_name.value.trim()+'&account_number='+sform.account_number.value.trim() +'&inv_amount='+sform.inv_amount.value.trim() ;
							var investment_slot = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	//// stop_load(); 
							                            	// $("#error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		// $("#success").html(result.note);
							                            		// $("#success").slideDown("fast");
							                            		 // $("#success").focus();
							                            		  start_creating_slot('start');

							                            	}else if(result.res =='300'){
							                            		// $("#warning").html(result.note);
							                            		// $("#warning").slideDown("fast");
							                            		 // $("#warning").focus();
							                            	}else{
							                            		// $("#error").html(result.note);
							                            		// $("#error").slideDown("fast");
							                            	}
														
															//// stop_load();
								                            return false;															
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}else{
							alert('fill all required data');
						}
			return false;
}

function start_creating_slot(text) {
    $('#create_slot').removeClass('w3-hide');

    setTimeout(function(){ 

      $('#create_slot_text').html(' Authenticating......');

          setTimeout(function(){ 
            $('#create_slot_text').html('Creating Slot.......');
              
                              generate_cert();
                     
 
          }, 3000);  


    }, 2000);  

}



function save_data_alert(text) {
    $('#save_content').removeClass('w3-hide');

    setTimeout(function(){ 
    	$('#spinner_status').html('<span class="fas fa-check"></span>');
    	$('#spinner_status').removeClass('text-info');
    	$('#spinner_status').removeClass('spinner-border ');
    	$('#spinner_status').addClass('text-success');
    	$('#spinner_status').addClass('w3-xlarge');
      	$('#save_content_text').html(text);

          setTimeout(function(){ 
            $('#save_content').addClass('w3-hide');
            location.reload();
          }, 1000);  

    }, 1000);  

}



function generate_cert() {
  setTimeout(function(){ 
        $('#create_slot').addClass('w3-hide');
         location.href = "manage_slot.php"  ;
  }, 3000); 
}

 




function register_form(sform) {
		$("#success").hide();
		$("#error").hide();
		$("#warning").hide();
		//start_load();
		if(sform.fname.value !=='' && sform.lname.value !=='' && sform.email.value !=='' && sform.password.value !==''){
					
						 	type = 'user';
						 	status = 1;
							data = 'sign_up=1&fname='+sform.fname.value+'&lname='+sform.lname.value+'&email='+sform.email.value+'&password='+sform.password.value;
							var login = new  $.ajax({
							                            url: 'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	//// stop_load(); 
							                            	$("#error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		$("#success").html(result.note);
							                            		$("#success").slideDown("fast");
							                            		 sform.fname.value  = '';
							                            		 sform.lname.value  = '';
							                            		 sform.email.value  = '';
							                            		 sform.password.value  = '';
							                            		 $("#success").focus();

							                            	}else if(result.res =='300'){
							                            		$("#warning").html(result.note);
							                            		$("#warning").slideDown("fast");
							                            		 sform.fname.value  = '';
							                            		 sform.lname.value  = '';
							                            		 sform.email.value  = '';
							                            		 sform.password.value  = '';
							                            		 $("#warning").focus();
							                            	}else{
							                            		$("#error").html(result.note);
							                            		$("#error").slideDown("fast");
							                            	}
														
														//// stop_load();
							                            return false;

															
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}
			return false;
		}



	function login_form(sform) {
		
					$("#login_success").hide();
					$("#login_error").hide();
					$("#login_warning").hide();
				if(sform.email.value !=='' && sform.password.value !==''){	
							data = 'login_form=1&email='+sform.email.value+'&password='+sform.password.value;
							var login = new  $.ajax({
							                            url:  'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	$("#login_error").html('Internet Error');
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		$("#login_success").html(result.note);
							                            		$("#login_success").slideDown("fast");
							                            		$("#login_success").focus();
							                            		localStorage.setItem('user_id', result.user_id);
					                      						setTimeout(function(){ location.href = result.redirect; }, 2000);  
							                            	}else{
							                            		$("#login_error").html(result.note);
							                            		$("#login_error").slideDown("fast");
							                            	}
							                              return false;
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;	 
				}

					return false;
		}


 
	function forget_pass(sform) {
		$("#forget_success").hide();
		$("#forget_error").hide();
		//// start_load();

		if(sform.email.value){
							data = 'forget_pass=1&email='+sform.email.value;
							var login = new  $.ajax({
							                           url:  'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	////stop_load(); 
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		$("#forget_success").html(result.note);
							                            		$("#forget_success").slideDown("fast");
							                            		$("#forget_success").focus();
							                            		setTimeout(function(){ location.href = result.redirect; }, 2000);  
							                            	}else{
							                            		$("#forget_error").html(result.note);
							                            		$("#forget_error").slideDown("fast");
							                            	}
							                              ////stop_load();
							                              return false;
							                            }
							                           //timeout: 20000 // sets timeout to  seconds
							                    });
							   return false;
							 
						}
			return false;
	}

 


 
	function reset_pass(sform) {
        $("#reset_success").hide();
		$("#reset_error").hide();
		 //// start_load();
		if(sform.password.value !=='' && sform.cpassword.value !==''){
						if(sform.password.value == sform.cpassword.value){
							data = 'reset_pass=1&password='+sform.password.value+'&dcode='+sform.dcode.value+'&cpassword='+sform.cpassword.value;
									var login = new  $.ajax({
							                            url:  'app_api.php',
							                            type: 'POST',
							                            data: data,
							                            error: function (xhr, ajaxOptions, thrownError) {
							                            	//stop_load(); 
							                            },
							                            success: function(result){
							                            	if(result.res =='200'){
							                            		$("#reset_success").html(result.note);
							                            		$("#reset_success").slideDown("fast");
							                            		$("#reset_success").focus();
					                      						setTimeout(function(){ location.href = result.redirect; }, 2000);  
							                            	}else{
							                            		$("#reset_error").html(result.note);
							                            		$("#reset_error").slideDown("fast");
							                            	}
							                            //stop_load();
							                            return false;
						                            }
							                           //timeout: 20000 // sets timeout to  seconds
							          });
							   return false;
						}else{						 	
						 	$("#reset_error").html("Password not the same");
						    $("#reset_error").slideDown("fast");
						    return false;
						}
				}
		return false;					 
	}

 





    function makesort(type) {
            $.ajax({
                  type: 'POST',
                  url:  'app_api.php',
                  data: "makesort=1&type=" + type,
                  success: function(result){
                        location.reload(true);
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Sever Access Connection Error"+ errorThrown); 
                  }
             });
    }


$("#txt-find").keydown(function(e){
    if (e.keyCode == 13 && !e.shiftKey)
    {
        e.preventDefault();
        $('#btn_find_query').click();
    }
});

    function find_query(url) {
    	find_value= document.getElementById('txt-find').value;
       location.href= url +find_value;
    }



</script>
<?php
?>