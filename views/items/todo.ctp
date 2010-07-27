
	<?php      
			$aObj = $js->object($itemTasks);
      $bObj = $js->object($itemStatuses);
			echo $html->scriptBlock('var itT = '.$aObj.';var itS = '.$bObj.';',array('inline'=>false));	
	?>
		
	<?php echo $this->element('pageHead/page_head');?>
	
	<?php echo $this->element('item/item_page');?>
