<div class="span-18" style="margin: 1em 0 .8em 0;">
  	<div  class="span-5 append-1" style="margin:.6em 0 0.2em 0;">
				<span id="allPrj" style="">
					<?php echo $html->link( __('All',true), array('controller'=>'items','action'=>'todo'),array('id'=>'allItems') );?>
				</span>&nbsp;
				<span id="curPrj" class="actPrj" style="">
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
				
				<?php echo $html->link('<span>'.__('projects',true).'</span><span class="upDownArr"></span>',array('#'),array('id'=>'newProject','escape'=>false));?>
	  		<?php echo $this->element('pageHead/projectEditor/project_editor');?> 		   	
   	</div>
   	<?php echo $this->element('pageHead/threeWaysMenu/three_ways_menu');?>


</div>
<div class="span-18" style="margin-bottom:1em;">
  		<?php echo $html->link(__('New',true).'<span class="upDownArr">'.__('task',true).'</span>', array('#'), array('onclick'=>'return false','class'=>'newItem','id'=>'newItem','title'=>'for tipsy','escape'=>false) );?> 
</div>


<?php echo $this->element('pageHead/itemEditor/item_editor');?>
