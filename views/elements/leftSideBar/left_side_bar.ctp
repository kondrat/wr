<div class="span-4" style="min-height:500px;">
	<?php if ( isset($curTheme) && $curTheme != array() ): ?>			
			<div class="leftSideTheme" style=""><?php echo $curTheme['0']['Theme']['theme'];?></div>
			<ul class="newCards">
				<?php foreach( $curTheme['0']['Card'] as $lastCard):?>
					<?php echo '<li>'.$lastCard['word'].'</li>';?>
				<?php endforeach ?>						
			</ul>
	<?php else: ?>
			<div class="leftSideTheme" style=""></div>
			<ul class="newCards"></ul>	
	<?php endif ?>	
	
</div>