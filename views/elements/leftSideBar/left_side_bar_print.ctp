<div class="span-4" style="min-height:500px;">
	<div class="searchCard" style="">
		<div style="font-size:smaller;border-bottom:1px dashed;font-style:italic;color:gray;"><?php echo __('Find Card',true);?>:</div>
		<?php echo $form->input('Card',array('label'=>false,'div'=>false));?>
	</div>
	
	<div class="wordCard" >
		<div style="font-size:smaller;border-bottom:1px dashed;font-style:italic;color:gray;"><?php echo __('Date',true);?>:</div>
		<div><?php echo Date('d.m.Y');?> - <?php echo Date('d.m.Y');?></div>
	</div>

	<?php if ( isset($curTheme) && $curTheme != array() ): ?>			
			<div style="font-size:smaller;border-bottom:1px dashed;font-style:italic;color:gray;">Theme: </div>
			<div class="leftSideTheme" style=""><?php echo $curTheme['0']['Theme']['theme'];?></div>
			<ul class="newCards">
				<?php foreach( $curTheme['0']['Card'] as $lastCard):?>
					<?php echo '<li>'.$lastCard['word'].'</li>';?>
				<?php endforeach ?>						
			</ul>
	<?php else: ?>
			<div style="font-size:smaller;border-bottom:1px dashed;font-style:italic;color:gray;">Theme: </div>
			<div class="leftSideTheme" style="">Theme1</div>
			<ul class="newCards"></ul>	
	<?php endif ?>		
</div>
