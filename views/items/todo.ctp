<?php echo $this->element('pageHead/page_head');?>

<div class="itemsWrapper span-17">
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
 
