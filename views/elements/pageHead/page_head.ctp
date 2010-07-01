<div class="span-18">
  	<div  class="span-4 append-1" style="margin:.6em 0 0.2em 0;">
  		<?php echo $html->link(__('New',true).'<span class="upDownArr">'.__('task',true).'</span>', array('#'), array('onclick'=>'return false','class'=>'newItem','id'=>'newItem','escape'=>false) );?>
    	
    	<div class="newProject">
    		<?php //echo $html->link( __('New project',true),array('#') );?>
    		<div id="projectEditor" class="hide">
    			<?php echo $form->input('newPr',array('label'=>false));?>
    			<?php echo $form->button('save',array('id'=>'newPrSave'));?>
    			<?php echo $form->button('cancel',array('id'=>'newPrCancel'));?>
    			
    		</div>
    			
    	</div>
   	</div>
   	<?php echo $this->element('pageHead/threeWaysMenu/three_ways_menu');?>

		<div class="span-5 last" style="text-align:right;">
   		<?php __('today');?>:&nbsp;<?php echo Date('d-m-Y');?>&nbsp;|&nbsp;<?php __('Week');?>:&nbsp;<?php echo Date('W');?>
		</div>
</div>
<div class="span-18" style="margin-bottom:1em;">
	<span id="allPrj" style="">
		<?php echo $html->link( __('All',true), array('controller'=>'items','action'=>'todo'),array('id'=>'allItems') );?>
	</span>&nbsp;
	<span id="curPrj" style="">
		<?php if( isset($curPrj) ): ?>
			<?php echo $html->link($curPrj['Project']['name'],array('controller'=>'items','action'=>'todo','prj:'.$curPrj['Project']['id']),array('id'=>'prjItems'));?>
			
			<?php $curPrjObj = $js->object(
													array(													
															'prjName'=> $curPrj['Project']['name'],
															'prjId'=> $curPrj['Project']['id']																								
													)
										);														
			?>
			<?php echo $html->scriptBlock('var pObj = '.$curPrjObj.';',array('inline'=>false)); ?>			
			
			
		<?php else: ?>
			<?php echo $html->link(__('My project',true),array('controller'=>'items','action'=>'todo'),array('id'=>'prjItems'));?>
		<?php endif ?>
	</span>&nbsp;
	
	<?php echo $html->link(__('more',true),array('#'),array('id'=>'newProject'));?>
</div>


<?php echo $this->element('pageHead/itemEditor/item_editor');?>
