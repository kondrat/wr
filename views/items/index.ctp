<div id="newItem" class="span-24">
  	<div class="span-4">
    	<div class="newItem">New<span>task</span></div>
   	</div>
		<div class="span-10">My project</div>
		<div class="span-10 last">
   		<?php __('today');?>:&nbsp;<?php echo Date('d-m-Y');?>&nbsp;|&nbsp;<?php __('Week');?>:&nbsp;<?php echo Date('W');?>
		</div>
</div>
<div class="newItemForm span-24 hide">
  <div id="newItemForm">
    <div style="border-bottom:1px solid #CCCCCC;margin-bottom:1em;padding:0.5em;">
      <?php echo $form->dateTime('target','DMY', 'none',null, array('empty' => false) );?>
      <?php echo $form->input( 'item',array('label'=>false, 'div'=>false) );?>
      <?php echo $form->input( 'task',array('label'=>false,'div'=>false,'options'=>array('task','idea','proposal') ) );?>
      <?php echo $form->input( 'status',array('label'=>false,'div'=>false,'options'=>array('opened','done','suspended','canceled') ) );?>
    </div>
    <div>
      <?php echo $form->button(__('save',true) ); ?>
      <?php echo $form->button(__('cancel',true) ); ?>
    </div>
  </div>
</div>
<div class="itemsWrapper span-24">
  <div class="item span-24">
    <div class="span-2"><div class="targetItem">12.10.2010</div></div>
    <div class="span-12"><div class="textItem">my first item</div></div>
    <div class="span-2"><div class="typeItem">task</div></div>
    <div class="span-2"><div class="statusItem">done</div></div>
  </div> 
</div>
 
