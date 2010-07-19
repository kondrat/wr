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
			
				<?php
						 switch($todo['Item']['status']) {
								case 0: 
									$statusClass = "opIt";
									$statusText = "opend";
									break;
								case 1:
									$statusClass = "clIt";
									$statusText = "closed";
									break;							
								case 2:
									$statusClass = "hlIt";
									$statusText = "hold";
									break;
								default: 
									$statusClass = "opIt";
									$statusText = "opend";
									break;
								}
					?>	
					<?php									
						 switch($todo['Item']['task']) {
								case 0: 
									$taskClass = "itTypeTodo";
									$taskText = "todo";
									break;
								case 1:
									$taskClass = "itTypeTick";
									$taskText = "ticket";
									break;							
								case 2:
									$taskClass = "itTypeImpr";
									$taskText = "impr";
									break;
								default: 
									$taskClass = "itTypeIdea";
									$taskText = "idea";
									break;
								}
					?>			
		  <div id="item_<?php echo $todo["Item"]["id"];?>" class="item span-17 <?php echo $statusClass;?>">
		  	<?php 
		  		if(!empty($todo["Item"]["target"])){
		  			$date = new DateTime($todo["Item"]["target"]);
		  			$formatedDate = $date->format('d.m.Y');
		  		} else {
		  			$formatedDate = __('No target',true);
		  		}		  	
		  	?>

			  <div class="span-2 last"><div class="targetItem"><?php echo $formatedDate;?></div></div>
			  
		    
		    <div class="span-14">
		    	
		    	<div class="textItem">
		    		<span class="itemType <?php echo $taskClass;?>"><?php echo $taskText;?></span>
			    	<?php if( $todo["Item"]["item"] ):?>
			    		<?php 
			    			echo $text->truncate($todo["Item"]["item"],
			    					65,
								    array(
								        'ending' => '...',
								        'exact' => false	    		
					    			)
			    			);
			    		?>
			    	<?php else: ?>
			    		<?php __('Empty task');?>
			    	<?php endif ?>
			    	<span class="itemCrated"><?php echo ' | '.$time->timeAgoInWords($todo["Item"]["created"], array('format' => 'd-m-Y','end' => "+1 day") );?></span>
		    	</div>
		    </div>
		    
		    <div class="span-1 last"><div class="statusItem"><?php echo $statusText;?></div></div>
		  </div> 
		  <?php endforeach ?>
		<?php else: ?>
			<div style="text-align:center;"><?php __('No items in the list yet.');?></div>
		<?php endif ?>
  
	</div>

	<?php echo $this->Js->writeBuffer(); ?>
