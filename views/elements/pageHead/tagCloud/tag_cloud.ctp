<div id="tgc-tagCloudWrp" class="tgc-tagCloudWrp">
	<div id="tgc-tagCloudHeader" class="tgc-tagCloudHeader">
		<h3>tag cloud</h3>
		<div class="tgc-tagCloudClose">
			<b>x</b>
		</div>
	</div>
	<div class="tgc-tagCloud">
		<div class="tgc-tagCloudInner">
							<?php if( isset($tags) && $tags !== array() ): ?>
								<?php foreach($tags as $tag):?>
									<?php echo '<li class="ite-tag"><span class="ite-tagName">'.$tag["Tag"]["name"].'</span><span>('.$tag["Tag"]["occurrence"].');</span></li>';?>
								<?php endforeach ?>
							<?php endif ?>
		</div>
	</div>
</div>