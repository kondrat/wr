		<?php 
			$this->Paginator->options(array(
	    	'update' => '#itemPages',
	    	//'evalScripts' => true
			));
		?>
	<div id="itemPages" class="itemsWrapper span-17">
		
		<div class="itemPagenator">
			<?php
				echo $paginator->prev('«Prev', null, null, array('class' => 'disabled.')).'&nbsp;';
				echo $paginator->numbers(array('separator'=>'&nbsp;','modulus'=> 8 )).'&nbsp;';
				echo $paginator->next('Next»', null, null, array('class' => 'disabled.'));
			?>  

		</div>	
		
		<?php if( $todos ): ?>
			<?php foreach( $todos as $todo ): ?>
		  <div class="item span-17">
		  	<?php $date = new DateTime($todo["Item"]["target"]);?>
		    <div class="span-2"><div class="targetItem"><?php echo $date->format('d-m-Y');?></div></div>
		    <div class="span-12"><div class="textItem">
		    	<?php if( $todo["Item"]["item"] ):?>
		    		<?php echo $todo["Item"]["item"];?>
		    	<?php else: ?>
		    		<?php __('Empty task');?>
		    	<?php endif ?>
		    </div></div>
		    <div class="span-2"><div class="statusItem">done</div></div>
		  </div> 
		  <?php endforeach ?>
		<?php else: ?>
			<div style="text-align:center;">No items in the list yet.</div>
		<?php endif ?>
  
	</div>

	<?php echo $this->Js->writeBuffer(); ?>