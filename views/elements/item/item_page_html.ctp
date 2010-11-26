		<?php 
			$this->Paginator->options(array(
	    	'update' => '#itp-itemPages'
			));			
		?>
		


	

		
		<div class="itp-itemPagenator">
			<?php
				echo $paginator->prev('«Prev', null, null, array('class' => 'disabled.')).'&nbsp;';
				echo $paginator->numbers(array('separator'=>'&nbsp;','modulus'=> 8 )).'&nbsp;';
				echo $paginator->next('Next»', null, null, array('class' => 'disabled.'));
			?>  
		</div>	



		
		
		<?php if( $todos ): ?>
			<?php foreach( $todos as $todo ): ?>
			
				<?php				
						$statusClass = "itS0";
						$statusText = "opend";									
						if ( $itemStatuses ) {	
							foreach($itemStatuses as $v) {
								if( $todo['Item']['status'] == $v['n'] ) {
									$statusClass = "itS".$v['n'];
									$statusText = $v['t'];
								} 
							}
						}
						
						$taskClass = "itT0";
						$taskText = "todo";							
						if ( $itemTasks ) {	
							foreach($itemTasks as $v) {
								if( $todo['Item']['task'] == $v['n'] ) {
									$taskClass = "itT".$v['n'];
									$taskText = $v['t'];
								} 
							}
						}

		  		if(!empty($todo["Item"]["target"])){
		  			$date = new DateTime($todo["Item"]["target"]);
		  			$formatedDate = $date->format('d.m.Y');
		  		} else {
		  			$formatedDate = '';//__('No target',true);
		  		}		  	
		  	?>
		  	
		  						
		  <div id="item_<?php echo $todo["Item"]["id"];?>" class="itp-item span-17 <?php echo $statusClass;?>">

				<div class="itp-itemHeadLine">				
					  			    	
				    	<div class="textItem">			    		
								<span class="itemType <?php echo $taskClass;?>"><?php echo $taskText;?></span>
								<span class="itemCrated"><?php echo ' '.$timenomin->timeAgoInWords($todo["Item"]["created"], array('format' => 'd-m-Y','end' => "+1 day") );?></span>
								<span class="itp-targetItem"><?php echo $formatedDate;?></span>
								
								<?php if( isset($todo["Tag"]) && $todo["Tag"] !== array() ):?>
									<?php foreach( $todo["Tag"] as $todoTag ):?>
										<span data-itemtag="<?php echo $todoTag["Tagged"]["id"];?>" class="itp-itemTag"><?php echo $todoTag["name"];?></span>
									<?php endforeach ?>
								<?php endif ?>
								
				    		<span class="itemHead">
					    	<?php if( $todo["Item"]["item"] ){
					    					$itemItem = $todo["Item"]["item"];		    	
					    				}else{
					    					$itemItem = __('Empty task',true);
					    				}
					    				echo $itemItem;
					    	?>					    	
					    	</span>    		
				    	</div>			   			    
				    	<div class="statusItem"><?php echo $statusText;?></div>		    
		  	</div>
		  	

		    
		  </div> 
		  <?php endforeach ?>
		<?php else: ?>
			<div style="text-align:center;"><?php __('No items in the list yet.');?></div>
		<?php endif ?>
  


	<?php echo $this->Js->writeBuffer(); ?>

