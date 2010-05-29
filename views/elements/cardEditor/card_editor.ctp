<?php 
	$classHide = null;
	if( isset($visible) && $visible == false ) {
		$classHide = 'hide';
	} 
?>

<?php $userActionTipsObj = $js->object(
													array(
														
															'pmW'=> array( 'tip' => __('Enter word or short phrase',true) ),
															'pmT'=> array( 'tip' => __('Enter test phrase',true) ),																																																				
															'pmTr'=> array( 'tip' => __('Enter translation of word',true) ), 																									
															'pmEx'=> array( 'tip' => __('Enter an example usage  of word',true) ), 																									
															'pmD'=> array( 'tip' => __('Enter definition of word',true) ),																									
															'pmS'=> array( 'tip' =>__('Enter an synonims of word',true) ),
															
															'rem'=> array( 'str' =>__('Your text will be here...',true) )																										
													)
										);														
?>
<?php echo $html->scriptBlock('var cObj = '.$userActionTipsObj.';',array('inline'=>false)); ?>


<div class="span-16 cardEditor <?php echo $classHide;?>" style="-moz-border-radius:15px;-moz-box-shadow:0 0 7px gray;">
	
			<?php echo $this->element("cardEditor/langSwitcher/lang_switcher");?>
			<?php echo $this->element("cardEditor/insertAlert/insert_alert");?>
	<div class="span-16">
			<div id="plusMenuWrapper" class="span-16">							
						<div id="plusMenuFront" class="hide">
								<div id="plusMenuWord">+ <?php __('word');?></div>							
								<div id="plusMenuTest">+ <?php __('more');?></div>		
						</div>
						<div id="plusMenuBack" class="hide">
								<div id="plusMenuTransl">+ <?php __('transl');?></div>
								<div id="plusMenuExample">+ <?php __('example');?></div>
								<div id="plusMenuDefin">+ <?php __('definition');?></div>
								<div id="plusMenuSynonim">+ <?php __('synonim');?></div>
						</div>							
			</div>
			
			<div class="span-16 panelTopWrapper" style="">
			    <div class="panelTop" style="">
				    
					    <?php echo $form->create('Card');?>
						    <div class="userActionWrapper" style="float:left;">
						    	<span id="sideToEdit">
							    	<a href="#" class="sideToEdit hide" style="" onclick="return false"><?php __('Side A');?>:</a>
							    	<a href="#" class="sideToEdit hide" style="" onclick="return false"><?php __('Side B');?>:</a>
							    </span>
							    <span class="userActions userAction" style=""></span>
						    </div>
						    <div style="float:right;" class="quickMode">
						      <?php __('Quick mode');?>
						      <?php echo $form->checkbox('Quick',array('checked'=>true) );?>
						    </div>
						
						    <?php echo $form->input('ext',array('label'=>false , "tabindex"=>"1") );?>
			

						    <div style="float:right;margin-right: 1em;">
							    <?php echo $form->button(__('Translate',true),array('id'=>'submitTranslId','style'=>'margin-right:3px;',"tabindex"=>"2","onclick"=>"return false;") );?>
							    <?php echo $html->link(__('Clean up',true),array() );?>
						    </div>
					    <?php echo $form->end();?>
					    
					    <div class="langToFromWrapper" style="">			    			    		
					    			<div id="langSwitch" class="langSwitch"></div>
						        <div id="langSideA">en</div>
						      	<div id="langSideB">ru</div>					      		
					      		<div id="changeLangPair" style=""><?php __('change lang Pair');?></div>			      							      				      			      	  			    	  
					    </div>
	
				    
				  </div>
			</div>
	
	
	
			<div class="span-16">
				
				<div id="tableFront" class="span-8" style="position:relative;">
						<table class="tableCard" style="">
							<tbody>
								<tr>
									<td class="td activeTside">
										<div class="cardInputs">
											<div class="mainWord hide"><span id="mainWord"></span></div>
											<div class="wordMore hide"><span class="perfix">[more]:&nbsp;</span><span id="mainMore"></span></div>
										</div>
										<div class="tableTheme">
											<span class="themePrefixCard"><?php __('Theme');?>: </span>
											<span class="themeNameCard">Theme 1</span>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="frontButton" class="frontBack"><?php echo $html->link(__('Side A',true),array('#'),array('onclick'=>'return false' ) );?></div>
				</div>
				
				<div id="tableBack" class="span-8 last" style="position:relative;">				
						<table class="tableCard" style="">
							<tbody>
								<tr>
									<td class="td">
										<div class="cardInputs">
											
												<div class="wordTran hide"><span id="wordTran"></span></div>
												<div class="wordMore hide"><span class="perfix">[ex]:&nbsp;</span><span id="exTran"></span></div>
												<div class="wordMore hide"><span class="perfix">[def]:&nbsp;</span><span id="defTran"></span></div>
												<div class="wordMore hide"><span class="perfix">[syn]:&nbsp;</span><span id="synTran"></span></div>
												
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="backButton" class="frontBack"><?php echo $html->link(__('Side B',true),array('#'),array('onclick'=>'return false' ) );?></div>
				</div>
				
			</div>

			<div class="span-16 panelBottomWrapper" style="">
			    <div class="panelBottom" style="">
			      <div id="playSound" class="sound"></div>
			      <div class="wordToSound"><?php __('No sound');?></div>
				    <?php echo $form->button(__('Save Card',true),array('id'=>'saveCardMain', 'disabled' => 'disabled') );?>
				    <div id='branding' style="position:absolute;top:13px; right:0;margin-right:1em;"> </div>
				  </div>
			</div>
	</div>
		<?php echo $this->element('cardEditor/rightSug/right_sug');?>
		<!--
		<div class="test">
			<div class="fancy_bg fancy_bg_n"></div>
			<div class="fancy_bg fancy_bg_ne"></div>
			<div class="fancy_bg fancy_bg_e"></div>
			<div class="fancy_bg fancy_bg_se"></div>
			<div class="fancy_bg fancy_bg_s"></div>
			<div class="fancy_bg fancy_bg_sw"></div>
			<div class="fancy_bg fancy_bg_w"></div>
			<div class="fancy_bg fancy_bg_nw"></div>
		</div>
		-->		
		<div class="closeCardTable" style=""></div>
		<div class="hideArrow hide" style=""></div>
		<div class="moveCardTable" style=""></div>
		
</div>									
