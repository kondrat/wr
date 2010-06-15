jQuery(document).ready( function(){
	
	var reg = {
		username: $("#UserUsername"),
		email: $("#UserEmail"),
		token: $("input[id^='Token']"),
		validEmail: ''
	}




	//getting new captcha
		$('.capReset span, #capImg').click( function() {
				var Stamp = new Date();
				$('#capImg').attr( {src: path+"/users/kcaptcha/"+Stamp.getTime() } );
			}
		)

//add if $this->data isset or not		
	//$("#UserRegForm input").val('');
	
	$("#UserRegForm input").blur(function(){
		if( $(this).val().length === 0 ) {
			$(this).parents(".inputFormWrap").find(".formWrapTip div").hide();
		}
	});		
	$("#UserRegForm input").focus(function(){	
		if( $(this).val().length === 0 ) {
			$(this).parents(".inputFormWrap").find(".formWrapTip div").hide();
			$(this).parents(".inputFormWrap").find(".formWrapTip div:first").show();
		}	
	});
	

	
	var inpStrTimer;
	reg.username.keyup( function(e) {
		
		//alert(e.which);
		/*
	  var chr = (String.fromCharCode(e.which));
	  rexp = /([^a-zA-Z0-9])/; 
	  if( rexp.test(chr) && e.which !== 8 ) {
	    return false;
	  } 
	  */
		
		var InputStr = $(this).val();
		
		$("#rName div").hide();	
		$("#rNameCheck").show();
				
		window.clearInterval(inpStrTimer);
		inpStrTimer = window.setInterval( function() {
			
				if( InputStr.length > 0 ){
					$.ajax({
									type: "POST",
									url: path+"/users/userNameCheck/",
									data: {"data[User][username]": InputStr, "data[_Token][key]": reg.token.val() },
									dataType: "json",
									
									success: function (data) {
										  if (data.stat == 1) {
										  	
										  	$('#rName div').hide();
										  	$("#rNameOk").show();
										  } else {
										  	$('#rName div').hide();
										  	$("#rNameError").show();
												$.each(rErr.username , function(key,value){
													if( key === data.error ) {
														$("#rNameError").text(value);
													}
												});
										  	
										  }
									},
									error: function(response, status) {
			              alert('An unexpected error has occurred! ');
			              //$('.tempTest').html('Problem with the server. Try again later.');
		              }

									
					});
					
				} else {
					$("#rNameCheck").hide();
					$("#rNameTip").show();
				}
					
				window.clearInterval(inpStrTimer);
			}, 1000
		);
		


	});





	$('#UserPassword1').passStrengthCheck(
																					"#rPass1Check",															        		
																        	{
															        			username: function(){return $("#UserUsername").val();},
															        			minlength: 4,
															        			maxlength: 16
															       			}																				
																				).passIdentCheck(1);






	$('#UserPassword2').passIdentCheck(2);





	reg.email.blur( function() {
		
			var InputStr = $(this).val();
		
			//var emailRegEx = /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/i;
			var emailRegEx =/.+@.+\..+/; 
			
			if( InputStr === '' ) {
				$("#rEmail div").hide();

			} else if( !InputStr.match(emailRegEx) ) {				
				$("#rEmail div").hide();				
				$("#rEmailError").show().text(rErr.email.email);
			} else {
				 if( InputStr !== reg.validEmail ){
					$.ajax({
									type: "POST",
									url: path+"/users/userNameCheck/",
									data: {"data[User][email]": InputStr, "data[_Token][key]": reg.token.val() },
									dataType: "json",									
									success: function (data) {
										  if (data.stat == 1) {
										  	// Success!
										  	reg.validEmail = InputStr;
										  	$('#rEmail div').hide();
										  	$("#rEmailOk").show();
										  } else {
										  	$('#rEmail div').hide();
										  	$("#rEmailError").show();
												$.each(rErr.email , function(key,value){
													if( key === data.error ) {
														$("#rEmailError").text(value);
													}
												});
										  	
										  }
									},
									error: function(response, status) {
			              alert('An unexpected error has occurred! ');
			              //$('.tempTest').html('Problem with the server. Try again later.');
		              }

									
					});	
				}			
			}
		}
	);




	

			$("form").submit(function() {
				/*
				$('#captchaWrap .error-message').remove();
				$('#captchaWrap').removeClass("error");
				$('#captchaWrap input').removeClass('form-error');
				*/
			  if ($("#UserCaptcha").val() == 0) {
			  	
						
						//$('#captchaWrap').addClass("error");
						//$('#captchaWrap input').addClass('form-error');
					
					return false;
			  } else {
					//alert($("#UserUsername").val());
			 		return true;
			 	}
			});

//???????????????????
		$("img").error(function(){
		  $(this).hide();
		});


	

									
});
