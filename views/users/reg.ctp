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
													      'notEmpty' => __('This field cannot be left blank',true),
													      'alphanumeric' => __('Only alphabets and numbers allowed', true),
													      'betweenRus' => __('Username must be between 4 and 10 chars', true),
													      'checkUnique' => __('This username has already been taken...',true)
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
								<?php echo $form->input('username', array( 'div'=>array("id"=>"usernameWrap"),'error'=>false) );?>
								 								
								<div id="checkName" style="display:none;">
								  <?php echo $html->image("icons/ajax-loader1.gif");?><?php __('Checking availability...');?>
								</div>
								
							</div>
							
							<div class="formWrapTip">
								<div class="formTip" id="nameFormTip">
									<?php //echo $html->image("icons/check_mark_green.png",array("style"=>"display:none;"));?>
									
									<?php  if( isset($this->validationErrors['User']['username'] ) ): ?>								
									  <?php echo $form->error('username', $errors['username'] );?>									
									<?php else: ?>								
									  <span><?php __('Only letters and numbers, 16 char max.');?></span>								  
									<?php endif ?>									
								</div>
							</div>
					</div>
	
					<div class="inputFormWrap">
							<div class="formWrapLabel">
								<?php echo $form->label(__('Password',true));?>
							</div>
							<div class="formWrapIn">
								<?php echo $form->input('password1' , array('type' => 'password','div'=>array("id"=>"passWrap"),'error'=>false) );?>
							</div>
							<div class="formWrapTip">							
								<div class="formTip" id="passFormTip">
									<?php  if( isset($this->validationErrors['User']['password1'] ) ): ?>								
									  <?php echo $form->error('password1', $errors['password1'] );?>									
									<?php else: ?>								
									  <span><?php __('6 characters or more');?></span>								  
									<?php endif ?>																	
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
							<div class="formWrapTip">
								<div class="formTip">
									<?php  if( isset($this->validationErrors['User']['password2'] ) ): ?>								
									  <?php echo $form->error('password2', $errors['password2'] );?>													  
									<?php endif ?>											
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
							<div class="formWrapTip">
								<div class="formTip">
									<?php  if( isset($this->validationErrors['User']['email'] ) ): ?>					
									  <?php echo $form->error('email', $errors['email'] );?>													  
									<?php endif ?>	
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

