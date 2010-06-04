<div class="span-17">
	<div class="formPage">
		<h3 style="color:#db605d;"><span style="color:gray;font-size:small;"><?php __('Sign in to');?></span> workroll.ru</h3>
		
		<?php echo $form->create('User', array(
																						'action' => 'login',        
																					 	'inputDefaults' => array(
            																												'label' => false,
            																												'div' => false
        																														)		
		) ); ?>
		
		<div class="inputFormWrap">
			<div class="formWrapLabel">
				<?php echo $form->label(__('Username',true));?>
			</div>
			<div class="formWrapIn">
				<?php echo $form->input('username', array() ); ?>	
			</div>
		</div>	
		
		<div class="inputFormWrap">
			<div class="formWrapLabel">
				<?php echo $form->label(__('Password',true));?>
			</div>
			<div class="formWrapIn">
				<?php echo $form->input('password' , array(	'type' => 'password',
																									
																								) 
															); ?>
			</div>
		</div>
		<div class="span-4">
			<?php echo $html->link(__('Forgot your password?',true), array('admin'=> false, 'action' => 'reset'), array('class' => '' ) ); ?>
		</div>
		<div class="autoLogin push-4 span-10">
			<?php echo $form->input('auto_login', array('type' => 'checkbox', 
																									'label' =>  __('Remember Me',true) ,
																									'div'=>false ) 
															); ?>
		</div>
		
	
		<div class="push-4 span-10">	
				<span><?php echo $form->button( __('Submit',true), array('type'=>'submit', 'id'=>'logSubmit') ); ?></span>
		</div>
				
		<?php echo $form->end(); ?>



		
		<div class="reg" style="position:absolute; left:400px;top:40px;">
			<?php echo $html->link(__('SignUp now',true), array('controller'=>'users','action'=>'reg') );?>
		</div>
		
	</div>
</div>



