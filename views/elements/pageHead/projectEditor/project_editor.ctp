
	

<div class="newProject">
	<div id="projectEditor" class="hide"> 
		<ul>
			<?php if( isset($curPrj) && $curPrj != array() ): ?>
				<?php foreach($curPrj as $v):?>
					<li><?php echo $html->link($v['Project']['name'], array('#'),array('onclick'=>'return false') );?></li>
				<?php endforeach ?>
			<?php else: ?>
					<li><a href="#" onclick="return false"><?php __('My first project');?></a></li>	
					<li><a href="#" onclick="return false"><?php __('My second project');?></a></li>
					<li><a href="#" onclick="return false"><?php __('My third project');?></a></li>		
			<?php endif ?>
		</ul>   

		<?php echo $form->input('newPr',array('label'=>false));?>
		<?php echo $form->button('save',array('id'=>'newPrSave'));?>
		<?php echo $form->button('cancel',array('id'=>'newPrCancel'));?> 
		   			
	</div>    			
</div>