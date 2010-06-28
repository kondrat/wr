<div id="newItemForm" class="dropdown-menu newItemForm span-17 hide"> 
	
    <div style="">
      <div class="span-8 append-6">
      	<?php echo $form->dateTime('target','DMY', 'none',null, array('empty' => false) );?>
      	<span id="timeToggle"><?php echo $html->image('icons/alert.png',array("style"=>"vertical-align:text-bottom"));?></span>
      	<span class="hide">
      		<?php echo $form->hour('hour');?>
      		<?php echo $form->minute('minute');?>
      	</span>
      </div>
      <div class="span-1 last">
      
      	<?php //echo $form->input( 'task',array('label'=>false,'div'=>false,'options'=>array(__('Diary',true),__('ToDo',true),__('Notes',true) ) ) );?>
      	<?php echo $form->input( 'status',array('label'=>false,'div'=>false,'options'=>array('opened','done','suspended','canceled') ) );?>
      
      </div>
      <?php echo $form->input( 'item',array('label'=>false, 'div'=>false) );?>

    </div>
    <div>
      <?php echo $form->button(__('save',true),array('id'=>'saveItemMain') ); ?>
      <?php echo $form->button(__('cancel',true) ); ?>
    </div>
  
</div>