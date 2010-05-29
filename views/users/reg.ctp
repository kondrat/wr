<div class="inner_page">

		<h3 style="color:#db605d;"><?php __('Join englishCARDS.ru');?></h3>
		
		<?php echo $form->create('User', array(
																						'action' => 'reg',        
																					 	'inputDefaults' => array(
            																												'label' => false,
            																												'div' => false
        																														)																				
		
		 ) ); ?>
	
					<div class="formWrap span-16">
						
							
							<?php echo $form->input('username', array('div'=>array("id"=>"usernameWrap"),
					
												'label'=>__('Username',true) ,
												/*									
												'error' => array(
																				'notEmpty' => __('This field cannot be left blank',true),
															    			'alphanumeric' => __('Only alphabets and numbers allowed', true),
															    			'betweenRus' => __('Username must be between 4 and 10 characters long', true),
															    			'checkUnique' => __('This username has already been taken',true),
								    										)	
								    		*/
								    					
							 			) ); 
							?>
							<div id="checkName" style="display:none;"><?php echo $html->image("icons/ajax-loader1.gif");?><?php __('Checking availability...');?></div>
							<div id="nameFormTip"><?php echo $html->image("icons/check_mark_green.png",array("style"=>"display:none;"));?><span><?php __('Only letters and numbers, 16 char max.');?></span></div>
					</div>
	
					<div class="formWrap span-16">	
							<?php echo $form->input('password1' , array('type' => 'password','div'=>array("id"=>"passWrap"),
												'label'=>__('Password',true),
												/*
												'error' => array(
															    			//'alphanumeric' => __('Only alphabets and numbers allowed', true),
															    			'betweenRus' => __('Password must be between 2 and 15 characters long', true),
								    										)	
								    		*/					
										 ) ); 
							?>
							<div id="passFormTip" style="padding:5px;float:left;padding:0px 0 0px 5px;width:255px;color:#ccc;"><?php __('Password must be between 2 and 15 characters long');?></div>
					</div>	
					
					<div class="formWrap span-16">	
							<?php echo $form->input('password2' , array('type' => 'password','div'=>array("id"=>"pass2Wrap"),
												'label'=>__('Confirm Password',true),
												/*
												'error' => array(
															    			'passidentity' => __('Please verify your password again', true),
								    										)	
								    		*/
								 ) ); 
							?>
					</div>	
					
					<div class="formWrap span-16">	
							<?php echo $form->input('email' , array('div'=>array("id"=>"emailWrap"),"class"=>"email required",
												'label'=>__('Email',true),
												'error' => array(
															    			'email' => __('Your email address does not appear to be valid', true),
															    			'checkUnique' => __('This Email has already been taken',true),
								    										)						
								 ) ); 
							?>						
					</div>		

					<div class="formWrap span-16">
													
							<div class="prepend-4 span-4">	
									<div class="capPlace"><?php echo $html->image( array('controller'=>'users','action'=>'kcaptcha',time() ),array('id'=>'capImg') );?></div>				
									<div class="span-4 capReset">
										<?php echo $html->image("icons/ajax-loader1-stat.png");?>
										<span><?php __('Couldn\'t see');?></span>
									</div>								
							</div>					
							<div class="span-6">	
								<div><?php __('Please type in the code');?></div>				
								<?php echo $form->input('captcha', array(	'div'=> array("id"=>"captchaWrap"),
																													'label' =>false,
													/*
													'error' => array(
																					'notEmpty' => __('This field cannot be left blank',true),
																	  			'alphanumeric' => __('Only alphabets and numbers allowed', true),
																	  			'equalCaptcha' => __('Please, correct the code',true),
										  										)
										  		*/						
									 ) );	
								?>	
							</div>
							
					</div>
					
					<div class="push-4 span-12">			
								<span><?php echo $form->button( __('Submit',true), array('type'=>'submit', 'id'=>'regSubmit') ); ?></span>
					</div>
		
	<?php echo $form->end(); ?>
</div>

