
	

<div class="newProject">
	<div id="projectEditor" class="hide"> 
		<ul>
			<?php if( isset($curPrj) && $curPrj != array() ): ?>
				<?php foreach($curPrj as $v):?>
					<li class="prjList">
						<?php echo $html->link($v['Project']['name'], array('#'),array('onclick'=>'return false') );?>
						<ul class="prjControl ui-widget ui-helper-clearfix">
							<li class="prjEdit ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pencil"></span></li>
							<li class="prjDel ui-state-default ui-corner-all"><span class="ui-icon ui-icon-trash"></span></li>
						</ul>
					</li>
				<?php endforeach ?>
			<?php else: ?>
					<li><a href="#" onclick="return false"><?php __('My first project');?></a></li>	
					<li><a href="#" onclick="return false"><?php __('My second project');?></a></li>
					<li><a href="#" onclick="return false"><?php __('My third project');?></a></li>		
			<?php endif ?>
		</ul> 
		<span id="prjNew"><?php __('New');?></span>  
		<div id="prjNewInput" class="hide">
			<?php echo $form->input('newPr',array('label'=>false,'div'=>false));?>
			<?php echo $form->button('save',array('id'=>'newPrSave'));?>
			<?php echo $form->button('cancel',array('id'=>'newPrCancel'));?> 
		</div>
		   			
	</div>    			
</div>