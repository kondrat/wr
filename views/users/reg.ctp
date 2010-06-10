<div class="span-17">
	<div class="formPage">

		<h3 style="color:#db605d;margin:0 0 1em 1em;"><span style="color:gray;font-size:small;"><?php __('Join');?></span> workroll.ru</h3>
		
		<?php 
		      echo $form->create('User', array(
																						'action' => 'reg',        
																					 	'inputDefaults' => array(
            																												'label' => false,
            																												'div' => false
        																														)																				
		
		                                      ) 
		                          ); 
		                          
		     	$errors = array(
		       	                'username' => array(
		       	                		'login' => __('Only latin letters and integers',true),
													      'notEmpty' => __('This field cannot be left blank',true),
													      'alphaNumeric' => __('Only alphabets and numbers allowed', true),
													      'betweenRus' => __('Username must be between 4 and 10 chars', true),
													      'checkUnique' => __('This username has already been taken',true)
													   ),
													   'password1' => array( 'betweenRus' => __('Password must be between 4 and 15 chars', true) ),
													   'password2' => array( 'passidentity' => __('Please verify your password',true) ),
													   'email' => array(
																 'email' => __('Should look like an email address', true),
																 'checkUnique' => __('This Email has already been taken',true),
									    			  ),
									    			  'captcha' => array(
																  'notEmpty' => __('This field cannot be left blank',true),
																	 'alphanumeric' => __('Only alphabets and numbers allowed', true),
																	 'equalCaptcha' => __('Please, correct the code.',true),
										  				)	
									    		);					


          $errorsObj = $js->object($errors);	
				  echo $html->scriptBlock('var rErr = '.$errorsObj.';',array('inline'=>false));			 
		 ?>

	
					<div class="inputFormWrap">
						
							<div class="formWrapLabel">
								<?php echo $form->label(__('Username',true));?>
							</div>
							<div class="formWrapIn">
								<?php echo $form->input('username', array( 'div'=>array("id"=>"usernameWrap"),'error'=> false, 'class'=> false ) );?>								
							</div>
							
							<div id="rName" class="formWrapTip">
									<?php  
										$errNameClass = 'hide';
										$okNameClass = 'hide';
										if( isset( $this->validationErrors['User']['username'] ) ) {
											$errNameClass = '';
										}else{										
											if( isset($this->data['User']['username']) ) {
												$okNameClass = '';
											}
										}
									?>
									
									<div id="rNameTip" class="rTip hide">																	
										  <?php __('Only letters and numbers, 16 char max.');?>							  																	
									</div>
									
									<div id="rNameCheck" class="rCheck hide">
									  	<?php echo $html->image("icons/ajax-loader1.gif");?><?php __('Checking availability...');?>
									</div>
									
									<div id="rNameError" class="rError <?php echo $errNameClass;?>">
										<?php echo $form->error('username',$errors['username'],array('wrap'=>null));?>
									</div>
	
									<div id="rNameOk" class="rOk <?php echo $okNameClass;?>">
											<?php echo $html->image("icons/check_mark_green.png",array());?>
											<?php __('Login is free');?>
									</div>
																	
							</div>
							
					</div>
	
					<div class="inputFormWrap">
						
							<div class="formWrapLabel">
								<?php echo $form->label(__('Password',true));?>
							</div>
							
							<div class="formWrapIn">
								<?php echo $form->input('password1', array('type' => 'password','div'=>array("id"=>"passWrap"),'error'=>false) );?>
							</div>
							
							<div id="rPass1" class="formWrapTip">	
								
									<?php  
										$errPass1Class = 'hide';
										if( isset($this->validationErrors['User']['password1'] ) ) {
											$errPass1Class = '';
										} 
									?>
									
									<div id="rPass1Tip" class="rTip hide">																	
										  <?php __('6 characters or more');?>								  																	
									</div>
									
									<div id="rPass1Check" class="rCheck hide">
									  	<?php __('Checking password');?>
									</div>
									
									<div id="rPass1Error" class="rError <?php echo $errPass1Class;?>">
										<?php echo $form->error('password1', $errors['password1'],array('wrap'=>null));?>
									</div>
	
									<div id="rPass1Ok" class="rOk hide">
											<?php echo $html->image("icons/check_mark_green.png",array());?>
											<?php __('Password OK');?>
									</div>								
								
							</div>
					</div>	
					
					<div class="inputFormWrap">	
							<div class="formWrapLabel">
								<?php echo $form->label(__('Confirm Password',true));?>
							</div>
							<div class="formWrapIn">
								<?php echo $form->input('password2' , array('type' => 'password','div'=>array("id"=>"pass2Wrap"),'error'=>false) );?>
							</div>
							
							<div id="rPass2" class="formWrapTip">
								
									<?php  
										$errPass2Class = 'hide';
										if( isset($this->validationErrors['User']['password2'] ) ) {
											$errPass2Class = '';
										} 
									?>	
																							
									<div id="rPass2Tip" class="rTip hide">																	
										<?php __('Passwords must be equal');?>								  																	
									</div>							

									<div id="rPass2Check" class="rCheck hide">
									  	<?php __('Checking password');?>
									</div>
									
									<div id="rPass2Error" class="rError <?php echo $errPass2Class;?>">
										<?php echo $form->error('password2', $errors['password2'],array('wrap'=>null));?>
									</div>
	
									<div id="rPass2Ok" class="rOk hide">
											<?php echo $html->image("icons/check_mark_green.png",array());?>
											<?php __('OK');?>
									</div>								
								
							</div>
					</div>	
					
					<div class="inputFormWrap">	
							<div class="formWrapLabel">
								<?php echo $form->label(__('Email',true));?>
							</div>
							<div class="formWrapIn">
								<?php echo $form->input('email' , array('div'=>array("id"=>"emailWrap"),"class"=>"email required",'error'=>false) );?>	
							</div>
							<div id="rEmailTip" class="formWrapTip">
								
									<?php  
										$errEmailClass = 'hide';
										if( isset($this->validationErrors['User']['email'] ) ) {
											$errEmailClass = '';
										} 
									?>	
																							
									<div id="rEmailTip" class="rTip hide">																	
										<?php __('Enter valid Email');?>								  																	
									</div>							

									<div id="rEmailCheck" class="rCheck hide">
									  	<?php __('Checking Email');?>
									</div>
									
									<div id="rEmailError" class="rError <?php echo $errEmailClass;?>">
										<?php echo $form->error('email', $errors['email'],array('wrap'=>null));?>
									</div>
	
									<div id="rEmailOk" class="rOk hide">
											<?php echo $html->image("icons/check_mark_green.png",array());?>
											<?php __('OK');?>
									</div>	
								
							</div>					
					</div>		

					<div class="inputFormWrap">
													
							<div class="span-4" style="padding-left: 175px;">	
									<div class="capPlace"><?php echo $html->image( array('controller'=>'users','action'=>'kcaptcha',time() ),array('id'=>'capImg') );?></div>				
									<div class="span-4 capReset">
										<?php echo $html->image("icons/ajax-loader1-stat.png");?>
										<span><?php __('Couldn\'t see');?></span>
									</div>								
							</div>					
							<div class="span-6">	
								<div><?php __('Please type in the code');?></div>				
								<?php echo $form->input('captcha', array(	'div'=> array("id"=>"captchaWrap"),'error' =>false ) );	
								?>	
								
							</div>
							<div class="span-6">
							  <?php echo $form->error('captcha', $errors['captcha'] );?>
							</div>
					</div>
					
					<div class="span-12" style="margin:0 -100px 1.5em 175px;">			
								<span><?php echo $form->button( __('Submit',true), array('type'=>'submit', 'id'=>'regSubmit') ); ?></span>
					</div>
		
	<?php echo $form->end(); ?>
	</div>
</div>

