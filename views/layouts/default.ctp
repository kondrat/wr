<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('Wr.go:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php

	
		echo $html->meta('icon');
		echo $html->css(array('wr','wr-u','screen'));

		//echo $html->css('print');
		echo '<!--[if IE]>';
		echo $html->css('ie');
		echo $html->css('wr-ie');
		echo '<![endif]-->';
		$userReg = ($this->Session->read('Auth.User.id'))? 1:0;
		echo $html->scriptBlock(
												'var path = "'.Configure::read('path').'";'."\n".'var userReg = '.$userReg.';' 
													);
		echo $html->script(array(	
															'dev/vars',
															'jquery/jquery-1.4.2.min',
															//'jquery/jquery.form',
															//'jquery/jquery-ui-1.8.custom.min',
															'jquery/jquery.ui.core.min',
															'jquery/jquery.ui.widget.min',
															//'jquery/jquery.ui.tabs.min',
															//'jquery/jquery.ui.mouse.min.js',
															//'jquery/jquery.ui.draggable.min',
															'dev/jquery.coloranim',
															'dev/func',
															'dev/common1',
															//'dev/common2',
															//'dev/common3',
															'dev/reg',
															'localization/messages_ru'
															));

		echo $scripts_for_layout;
	?>

</head>
<body>
	<div class="pageheader">

			<div class="container">
				<div class="span-24">
						<div class="span-12 prepend-1">
							<div style="float:left;margin:5px 0 5px 1em;">
								<?php echo $html->link($html->image(
																										'pic/wr-logo-24-dev.png'
																										), array('controller'=>'items','action'=>'index'),array('escape'=>false) );?> 
							</div>
						</div>
						<div class="span-5" style="position:relative;" >
							
									<div class="signUpNow">
										<?php if(!$this->Session->read('Auth.User.id')|| $this->Session->read('Auth.User.group_id') == 2 ): ?>
											<?php echo $html->link(__('SignUp now',true), array('controller'=>'users','action'=>'reg') );?>
										<?php endif ?>
									</div>
									<div class="signUpNow">
										<?php if(!$this->Session->read('Auth.User.id')|| $this->Session->read('Auth.User.group_id') == 2 ): ?>
											<?php echo $html->link(__('LogIn now',true), array('controller'=>'users','action'=>'login') );?>
										<?php else: ?>
											<?php echo $html->link(__('LogOut now',true), array('controller'=>'users','action'=>'logout') );?>
										<?php endif ?>
									</div>	

							
						</div>
					</div>


	
		</div>					
			
	</div>


		
	<div class="container showgrid.">    
			  <div class="fl" style="">
				  <?php echo $session->flash();?>
			  </div>
		
		    <div class="span-23 prepend-1 last contentWrapper" style="">
		    			<?php echo $this->element('noscript/noscript');?>	        
							<?php echo $content_for_layout; ?>		        
		    </div>
	
	</div>
	<div class="pagefooter" style="">
			<div class="container">
				<div class="span-24">
					
			    <div class="span-22 prepend-1">
			    	<div class="footerNote">
		      	 <?php echo $html->link('www.workroll.ru',array('controller'=>'items','action'=>'index'));?> &copy;<?php echo date('Y');?>
		      	</div>
		   		</div>
		   		
			  </div>
			</div>
	</div>
			
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
