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
		echo $html->css(array(
													'wr',
													'wr-u',
													'wr-ite',
													'wr-itp',
													'wr-tgc',
													'screen',
													'jqcss/css/smoothness/jquery-ui-1.8.2.custom',
													'tipsy/stylesheets/tipsy'
													)
										);

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
															'jquery/jquery-1.4.4.min',
															'tipsy/javascripts/jquery.tipsy',
															'dev/jquery.tmpl.min',
															//'jquery/jquery.form',
															//'jquery/jquery-ui-1.8.custom.min',
															'jquery/jquery.ui.core.min',
															'jquery/jquery.ui.widget.min',
															'jquery/jquery.ui.datepicker.min',
															//'jquery/jquery.ui.tabs.min',
															'jquery/jquery.ui.mouse.min.js',
															'jquery/jquery.ui.draggable.min',
															'dev/jquery.coloranim',
															'dev/jquery.ba-outside-events.min',
															'dev/jquery.elastic',
															'dev/func',
															'dev/common1',
															'dev/common2',
															//'dev/common3',
															
															));

		echo $scripts_for_layout;
	?>

</head>
<body>
	<div id="overlay" class="hide"></div>
	<div class="pageheader" style="position:relative;">

			<div class="container">
				
				<div id="headWrap" class="span-18">
						<div class="span-5 prepend-1">
							<div style="float:left;margin:5px 0 5px 1em;">
								<?php echo $html->link($html->image(
																										'pic/wr-logo-24-dev.png'
																										), array('controller'=>'items','action'=>'index'),array('escape'=>false) );?> 
							</div>
						</div>
						<div class="" style="position:relative; float:right;">						
							<?php 
								if( !isset($menuType) || !in_array($menuType, array('reg','login','index','todo'),true) ) {
									$menuType = 'default';
								}
								echo $this->element('pageHead/topMenu/top_menu',array( 'menuType'=> $menuType  ) );
							?>
							
							<div style="position: absolute;top:8px;right:300px;">
					   		<?php __('today');?>:&nbsp;<?php echo Date('d-m-Y');?>&nbsp;|&nbsp;<?php __('Week');?>:&nbsp;<?php echo Date('W');?>
							</div>							
							
							
						</div>
						
				</div>
	
			</div>					
			
	</div>


		
	<div class="container showgrid." style="position:relative;">    
			  <div class="span-19 fl" style="">
				  <?php echo $session->flash();?>
				  <?php echo $this->Session->flash('email'); ?>
			  </div>
		
		    <div class="span-18 prepend-1 last contentWrapper" style="">
		    			<?php echo $this->element('noscript/noscript', array('cache' => array('key' => 'first_use','time' => '+1 year') ) );?>	        
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
	<!-- Yandex.Metrika -->
	<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
	<div style="display:none;"><script type="text/javascript">
	try { var yaCounter1206877 = new Ya.Metrika(1206877); } catch(e){}
	</script></div>
	<noscript><div style="position:absolute"><img src="//mc.yandex.ru/watch/1206877" alt="" /></div></noscript>
	<!-- /Yandex.Metrika -->
</body>
</html>
