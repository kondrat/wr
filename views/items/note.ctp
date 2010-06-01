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
	<?php __('All');?>
	<?php __('My project');?>
</div>
<?php echo $this->element('itemEditor/item_editor');?>

<div class="itemsWrapper span-17">
  <div class="item span-17">
    <div class="span-2"><div class="targetItem">12.10.2010</div></div>
    <div class="span-12"><div class="textItem">my first item</div></div>
    <div class="span-2"><div class="statusItem">done</div></div>
  </div> 
  <div class="item span-17">
    <div class="span-2"><div class="targetItem">12.10.2010</div></div>
    <div class="span-12"><div class="textItem">my second item</div></div>
    <div class="span-2"><div class="statusItem">done</div></div>
  </div> 
  <div class="item span-17">
    <div class="span-2"><div class="targetItem">12.10.2010</div></div>
    <div class="span-12"><div class="textItem">my third item</div></div>
    <div class="span-2"><div class="statusItem">done</div></div>
  </div> 
</div>
 
