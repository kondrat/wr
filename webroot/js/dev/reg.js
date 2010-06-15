jQuery(document).ready( function(){
	
	var reg = {
		username: $("#UserUsername")
	}

	
	//var passToCheck = null;
	var options = null;
	
		
	var settings = {
							required: "This field cannot be left blank",
							betweenRus: "Username must be between 4 and 10 characters long",
							passidentity: "Please verify your password again",
							email: "Your email address does not appear to be valid"
								
		 };
	
	//if we have localization file in heading
		if( jQuery().messages ) {
			var options = $().messages();
		}

		var local = $.extend(settings, options);



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
	$("#UserUsername").keyup( function(e) {
		
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
		
		//preparation
		/*		
		$('#usernameWrap .error-message').remove();
		$('#usernameWrap input').removeClass('form-error');				
		$('#response').remove();
		$('#usernameWrap').removeClass("error");
		*/
		
		
		window.clearInterval(inpStrTimer);
		inpStrTimer = window.setInterval( function() {
			
				if( InputStr.length > 0 ){
					$.ajax({
									type: "POST",
									url: path+"/users/userDataCheck/",
									data: {"data[User][username]": InputStr },
									dataType: "json",
									
									success: function (data) {
										  if (data.stat == 1) {
										  	// Success!
										  	$('#rName div').hide();
										  	$("#rNameOk").show();
										  } else {
										  	$('#rName div').hide();
										  	$("#rNameError").show();
												$.each(rErr.username , function(key,value){
													if( key === data.error.username ) {
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





	$('#UserEmail').blur( function() {
			$('#emailWrap .error-message').remove();
			$('#emailWrap').removeClass("error");
			$('#emailWrap input').removeClass('form-error');
			
			if( $('#UserEmail').val() == 0 ) {
					//$('#emailWrap').append('<div id="emailerror" class="error-message">'+local['required']+'</div>');
					//$('#emailWrap').addClass("error");
					//$('#emailWrap input').addClass('form-error');

			} else {
					if ( /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/i.test($('#UserEmail').val()) ) {
						$('#emailWrap .error-message').remove();
						$('#emailWrap').removeClass("error");
						$('#emailWrap input').removeClass('form-error');
					} else {
						//$('#emailWrap').append('<div id="emailerror" class="error-message">'+local['email']+'</div>');
						//$('#emailWrap').addClass("error");
						//$('#emailWrap input').addClass('form-error');
					}
			}
		}
	)




	

			$("form").submit(function() {
				/*
				$('#captchaWrap .error-message').remove();
				$('#captchaWrap').removeClass("error");
				$('#captchaWrap input').removeClass('form-error');
				*/
			  if ($("#UserCaptcha").val() == 0) {
			  	
						$('#captchaWrap').append('<div id="emailerror" class="error-message">'+local['required']+'</div>');
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
