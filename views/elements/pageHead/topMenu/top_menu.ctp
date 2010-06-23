<?php $here = Router::url(substr($this->here, strlen($this->webroot)-1)); ?>
<?php 
	echo $html->scriptStart(array('inline' => true));	
	echo $js->alert($here);	
	echo $html->scriptEnd();
	//echo 'hi';
?>

<?php if(!$this->Session->read('Auth.User.id')|| $this->Session->read('Auth.User.group_id') == 2 ): ?>
								
		<div class="signUpNow">										
			<?php echo $html->link('<span>'.__('LogIn now',true).'</span><span class="upDownSmallArrow"></span>', array('controller'=>'users','action'=>'login'),array('escape'=>false) );?>			
		</div>
		<div class="logInNow">										
			<?php echo $html->link(__('SignUp now',true), array('controller'=>'users','action'=>'reg') );?>
		</div>
		<?php echo $this->element('pageHead/quickLogin/quick_login');?>
<?php else: ?>	
	<div class="logOutNow">
			<?php echo $html->link(__('LogOut now',true), array('controller'=>'users','action'=>'logout') );?>
	</div>
<?php endif ?>