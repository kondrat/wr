<div id="newItemForm" class="span-17 hide"> 
	<div class="newItemForm">	

      <div class="" style="float:left;">
      	<?php echo $form->input('datepicker', array('label'=>false,'div'=>false, 'id'=>'datepicker') );?>
      	<span id="timeToggle"><?php echo $html->image('icons/alert.png',array("style"=>"vertical-align:text-bottom"));?></span>
      	<span class="hide">
      		<?php echo $form->hour('hour');?>
      		<?php echo $form->minute('minute');?>
      	</span>
      </div>

      <div class="" style="float:right;">
      
      	<?php //echo $form->input( 'task',array('label'=>false,'div'=>false,'options'=>array(__('Diary',true),__('ToDo',true),__('Notes',true) ) ) );?>
      	<?php echo $form->input( 'status',array('label'=>false,'div'=>false,'options'=>array('opened','done','suspended','canceled') ) );?>
      
      </div>
      <?php echo $form->input( 'item',array('label'=>false, 'div'=>true) );?>


	    <div class="" style="margin-bottom:5px;">
	      <?php echo $form->button(__('save',true),array('id'=>'saveItemMain') ); ?>
	      <?php echo $form->button(__('cancel',true) ); ?>
	    </div>
	    

	</div>  
</div>