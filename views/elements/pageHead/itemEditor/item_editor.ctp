<div id="newItemForm" class="span-17 hide"> 
	<div class="newItemForm">	

      <div class="" style="float:left;">
      	<?php 
      		$targetDay = __('Target day',true);
      		echo $html->scriptBlock(
												'var targetDay = "'.$targetDay .'";' 
													);
				?>

      		<?php	echo $form->input('datepicker', array('label'=>false,'div'=>false, 'id'=>'datepicker','default'=> $targetDay ) );?>

					
      	<!--
      	<span id="timeToggle"><?php echo $html->image('icons/alert.png',array("style"=>"vertical-align:text-top"));?></span>
      	<span class="hide">
      		<?php echo $form->hour('hour');?>
      		<?php echo $form->minute('minute');?>
      	</span>
      	-->
      </div>
      <div style="float: left; margin-left: 5px; margin-top: 8px;">
      	+
      	<?php echo $html->link(__("time",true), array('#'),array('onclick'=>'return false') );?>
      </div>
      <div style="float: left; margin-left: 5px; margin-top: 8px;">
      	+
      	<?php echo $html->link(__("more",true), array('#'),array('onclick'=>'return false') );?>
      </div>

      <div class="" style="margin-top:4px;float:right;">
   			<ul id="icons" class="ui-widget ui-helper-clearfix">
   				<li id="saveItemMain" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></li>
   				<li  class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cancel"></span></li>
   			</ul>     
      </div>
      <?php echo $form->input( 'item',array('label'=>false, 'div'=>true) );?>
	</div>  
</div>