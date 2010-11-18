		<?php 
			$this->Paginator->options(array(
	    	'update' => '#itemPages'
			));			
		?>
		
		<script id="ite-itemViewTmpl" type="text/x-jquery-tmpl"> 
			    <div class="itemViewBlock">
			    	<div class="itemDataBlock">
			    		<div style="color: red; float: left; width: 100%;">
		
			    				{{each itemTags}}
				    				<span data-itemt="${itemId}" class="ite-tagToAdd">${itemTag}</span>	
				    			{{/each}}
		
				    	</div>	    		
				    		<ul class="itEdButtons ui-widget ui-helper-clearfix">
									<li class="itemEdit ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-pencil"></span></li>
									<li class="itemDel ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-trash"></span></li>
								</ul>
				    	
					    	<div class="itemEditText">
					    		<span class="origText">${origText}</span>
					    	</div>
				    	
			    	</div>
			    	
						<div class="itemEditBlock hide">
			    		<ul class="itEdButtons ui-widget ui-helper-clearfix">
								<li class="itemSubmit ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-check"></span></li>
								<li class="itemCan ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-cancel"></span></li>
							</ul>			
							<div style="padding:5px;margin-top:20px;"><textarea class="itemTextArea" name="data[itemText]" style="height: 10px;"></textarea><div>
							<div>more</div>
						</div>			    	
			    </div>	
		</script>		

	
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
		  			$formatedDate = __('No target',true);
		  		}		  	
		  	?>
		  	
		  						
		  <div id="item_<?php echo $todo["Item"]["id"];?>" class="item span-17 <?php echo $statusClass;?>">

				<div class="itemHeadLine">				
					  	<div class="targetItem"><?php echo $formatedDate;?></div>		    	
				    	<div class="textItem">			    		
								<span class="itemType <?php echo $taskClass;?>"><?php echo $taskText;?></span>
								<span class="itemCrated"><?php echo ' '.$timenomin->timeAgoInWords($todo["Item"]["created"], array('format' => 'd-m-Y','end' => "+1 day") );?></span>
								
								
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
				    	<div class="statusItem"><?php echo '['.$statusText.']';?></div>		    
		  	</div>
		  	

		    
		  </div> 
		  <?php endforeach ?>
		<?php else: ?>
			<div style="text-align:center;"><?php __('No items in the list yet.');?></div>
		<?php endif ?>
  
	</div>

	<?php echo $this->Js->writeBuffer(); ?>
	<div class="span-24">
		<?php echo $this->Form->button('fucus',array('id'=>'fucusEd'));?>
		<div id="editable" class="span-4">
			<span contenteditable="true">
				test test
				test
			</span>
		</div>
	</div>
