<?php $selectedTheme = null;?>

	<div class="prepend-4 span-16 append-4 last" style="-moz-border-radius:5px;background-color:SeaShell;margin-bottom: 1em;">
		<div style="position:relative;">
			<span class= "themePerfix" style="color:gray;font-size:8pt;"><?php __('theme');?>:</span> 
			<span class= "themeName" style="">
				<?php if(isset($curTheme) && $curTheme != array()):?>
					<?php $selectedTheme = ($curTheme['0']['Theme']['theme'])? $curTheme['0']['Theme']['id']:null;?>
	
					<?php $currentThemeObj = $js->object(
																		array(
																				'theme'=> $curTheme['0']['Theme']['theme'],
																				'id' =>  $curTheme['0']['Theme']['id']
																		)
															);														
					?>
					<?php echo $curTheme['0']['Theme']['theme'];?>
				<?php else: ?>
					<?php $currentThemeObj = $js->object(array());?>
					Theme 1
				<?php endif ?>
				<?php echo $html->scriptBlock('var currentTheme = '.$currentThemeObj.';',array('inline'=>false)); ?>
			</span>
			
			&nbsp;
			<span class="editCreateTheme" >
				<?php echo $html->link(__('Edit',true),array("#"),array('class'=>'editTheme','onclick'=>'return false') );?>&nbsp;
					<span>or</span>
					<?php echo $html->link(__('Select another',true),array("#"),array('class'=>'selectTheme','onclick'=>'return false'));?>
				<span>or</span>
				<?php echo $html->link(__('Create new',true),array("#"),array('class'=>'createNewTheme','onclick'=>'return false'));?>
			</span>
			
			<div class="saveTheme hide" style="">
				<?php echo $form->input("themeEdit",array('label'=> false,'div'=> false,'class'=>'') );?>
				<?php echo $form->button(__('Save',true),array('id'=>'saveThemeSave'));?>&nbsp;
				<?php echo $form->button(__('Cancel',true),array('id'=>'saveThemeCancel') );?>
			</div>
			<div class="selTheme hide" style="">
				<?php echo $form->input("themeSelect",array('options' => array(__('...(select theme)',true) => $allThemes) ,'selected' => $selectedTheme,'label'=> false,'div'=> false,'class'=>'') );?>
				
				<?php echo $form->button(__('Cancel',true),array('id'=>'selThemeCancel') );?>
			</div>
		</div>
	</div>
