<div class="inner_page">
	
		<h3 style="color:#db605d;"><?php __('Sign in to englishCARDS.ru');?></h3>
		
		<?php echo $form->create('User', array('action' => 'login' ) ); ?>
		
		<div class="formWrap span-14">
			<?php echo $form->input('username', array('div'=>array("id"=>"usernameWrap"),
																								'label'=>__('Username',true)	) 
															); ?>	
		</div>	
		<div class="formWrap span-10">
			<?php echo $form->input('password' , array(	'type' => 'password',
																									'div'=>array("id"=>"passWrap"), 
																									'label'=>__('Password',true)	) 
															); ?>
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



