<div class="span-18">
  	<div  class="span-4 append-1" style="margin:.6em 0 0.2em 0;">
  		<?php echo $html->link(__('New',true).'<span class="upDownArr">'.__('task',true).'</span>', array('#'), array('onclick'=>'return false','class'=>'newItem','id'=>'newItem','escape'=>false) );?>
  		<?php echo $this->element('pageHead/projectEditor/project_editor');?>    	
   	</div>
   	<?php echo $this->element('pageHead/threeWaysMenu/three_ways_menu');?>


</div>
<div class="span-18" style="margin-bottom:1em;">
	<span id="allPrj" style="">
		<?php echo $html->link( __('All',true), array('controller'=>'items','action'=>'todo'),array('id'=>'allItems') );?>
	</span>&nbsp;
	<span id="curPrj" style="">
		<?php if( isset($curPrj) ): ?>
			<?php echo $html->link($curPrj[0]['Project']['name'],array('controller'=>'items','action'=>'todo','prj:'.$curPrj[0]['Project']['id']),array('id'=>'prjItems'));?>
			
			<?php $curPrjObj = $js->object(
													array(													
															'prjName'=> $curPrj[0]['Project']['name'],
															'prjId'=> $curPrj[0]['Project']['id']																								
													)
										);														
			?>
			<?php echo $html->scriptBlock('var pObj = '.$curPrjObj.';',array('inline'=>false)); ?>			
			
			
		<?php else: ?>
			<?php echo $html->link(__('My project',true),array('controller'=>'items','action'=>'todo'),array('id'=>'prjItems'));?>
		<?php endif ?>
	</span>&nbsp;
	
	<?php echo $html->link('<span class="upDownArr">'.__('projects',true).'</span>',array('#'),array('id'=>'newProject','escape'=>false));?>
</div>


<?php echo $this->element('pageHead/itemEditor/item_editor');?>
