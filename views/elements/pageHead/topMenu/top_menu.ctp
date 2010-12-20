<?php 
	if(!isset($menuType) ){
		$menuType = null;
	} 
?>

<?php switch($menuType):
	 	case 'todo':?>
		<div class="topMenu">
				<?php echo $html->link(__('Profile',true), array('plugin' => 'users','controller'=>'users','action'=>'profile'),array('onclick'=>'return false') );?>
		</div>	 	
		<div class="topMenu">
				<?php echo $html->link(__('Settings',true), array('plugin' => 'users','controller'=>'users','action'=>'settings'),array('onclick'=>'return false') );?>
		</div>	 	
		<div class="topMenu">
				<?php echo $html->link(__('LogOut now',true), array('plugin' => 'users','controller'=>'users','action'=>'logout') );?>
		</div>
		<?php break; ?>
	<?php case 'reg':?>
		<div class="" style="float:left;margin-top:8px;"><?php __('Already on');?>&nbsp;workroll?</div>
		<div class="topMenu">													
			<?php echo $html->link('<span>'.__('LogIn now',true).'</span>', array('plugin' => 'users','controller'=>'users','action'=>'login'),array('escape'=>false) );?>			
		</div>		
		<?php break; ?>
	<?php case 'login':?>
		<div class="topMenu">										
			<?php echo $html->link('<span>'.__('LogIn now',true).'</span>', array('plugin' => 'users','controller'=>'users','action'=>'login'),array('escape'=>false) );?>			
		</div>
		<div class="topMenu">										
			<?php echo $html->link(__('SignUp now',true), array('plugin' => 'users','controller'=>'users','action'=>'reg') );?>
		</div>		
		<?php break; ?>
	<?php case 'index': ?>
												
					<div id="logInNow" class="topMenu">										
						<?php //echo $html->link('<span>'.__('LogIn now',true).'</span><span class="upDownSmallArrow"></span>', array('controller'=>'users','action'=>'login'),array('escape'=>false) );?>
						<?php echo $html->link('<span class="upDownArr">'.__('LogIn now',true).'</span>', array('plugin' => 'users','controller'=>'users','action'=>'login'),array('escape'=>false) );?>			
					</div>
					<div class="topMenu">										
						<?php echo $html->link(__('SignUp now',true), array('plugin' => 'users','controller'=>'users','action'=>'reg') );?>
					</div>			
					<?php echo $this->element('pageHead/quickLogin/quick_login',array('cache' => false) );?>

			
		<?php break; ?>
	<?php default: ?>
		<?php break; ?>

		
<?php endswitch ?>	



