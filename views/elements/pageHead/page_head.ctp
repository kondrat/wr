<div id="newItem" class="span-24">
  	<div class="span-4">
    	<div class="newItem"><?php __('New');?><span><?php __('task');?></span></div>
    	<div class="newProject">
    		<?php echo $html->link( __('New project',true),array('#'),array('id'=>'newProject') );?>
    		<div id="projectEditor" class="hide">
    			<?php echo $form->input('newPr',array('label'=>false));?>
    			<?php echo $form->button('save',array('id'=>'newPrSave'));?>
    			<?php echo $form->button('cancel',array('id'=>'newPrCancel'));?>
    			
    		</div>
    			
    	</div>
   	</div>
   	<?php echo $this->element('pageHead/threeWaysMenu/three_ways_menu');?>

		<div class="span-10 last">
   		<?php __('today');?>:&nbsp;<?php echo Date('d-m-Y');?>&nbsp;|&nbsp;<?php __('Week');?>:&nbsp;<?php echo Date('W');?>
		</div>
</div>
<div class="span-23" style="margin-bottom:1em;">
	<span style="border-bottom:1px dashed;"><?php __('All');?></span>&nbsp;
	<span id="curPrj" style="border-bottom:1px dashed;"><?php __('My project');?></span>
</div>
<?php echo $this->element('pageHead/itemEditor/item_editor');?>