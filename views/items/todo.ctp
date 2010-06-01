<div id="newItem" class="span-24">
  	<div class="span-4">
    	<div class="newItem">New<span>task</span></div>
   	</div>
   	<?php echo $this->element('threeWaysMenu/three_ways_menu');?>

		<div class="span-10 last">
   		<?php __('today');?>:&nbsp;<?php echo Date('d-m-Y');?>&nbsp;|&nbsp;<?php __('Week');?>:&nbsp;<?php echo Date('W');?>
		</div>
</div>
<div class="span-23" style="margin-bottom:1em;">
	<span style="border-bottom:1px dashed;"><?php __('All');?></span>&nbsp;
	<span style="border-bottom:1px dashed;"><?php __('My project');?></span>
</div>
<?php echo $this->element('itemEditor/item_editor');?>


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
 
