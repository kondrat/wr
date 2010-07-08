
	

<div class="newProject">
	<div id="projectEditor" class="hide"> 
		<ul id="prjMainList">
			<?php if( isset($curPrj) && $curPrj != array() ): ?>
				<?php foreach($curPrj as $k => $v):?>
					<?php $active = ($k == 0)?"activePrj":null;?>
					<li class="prjList <?php echo $active;?>">
						<?php echo $html->link($v['Project']['name'], array('#'),array('id'=>'prj_'.$v['Project']['id'],'onclick'=>'return false') );?>
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
		<?php echo $html->link('<span class="upDownArr">'.__('New',true).'</span>',array('#'),array('id'=>'prjNew','escape'=>false,'class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'));?>
  
		<div id="prjNewInput" class="hide">
			<?php echo $form->input('newPr',array('label'=>false,'div'=>false));?>
			<?php echo $form->button('save',array('id'=>'newPrSave','class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'));?>
			<?php echo $form->button('cancel',array('id'=>'newPrCancel','class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'));?> 
		</div>
		   			
	</div>    			
</div>