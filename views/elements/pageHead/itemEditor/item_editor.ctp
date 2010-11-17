<div id="newItemForm" class="span-17 hide"> 
	<div class="newItemForm">	
		<div id="newItemFormTop" style="float:left;width:100%;">
			<div id="itemTypeControl" style="float:left;margin:8px 10px 0 0;">
				<span class="itemType itT0"><?php echo $itemTasks[0]['t'];?></span><span class="upDownArr"></span>
			</div>
      <div class="" style="float:left;">
      	<?php 
      		$targetDay = __('Target day',true);
      		echo $html->scriptBlock('var targetDay = "'.$targetDay .'";' );
				?>

      		<?php	echo $this->Form->input('datepicker', array('label'=>false,'div'=>false, 'id'=>'datepicker','default'=> $targetDay ) );?>

					
      	<!--
      	<span id="timeToggle"><?php echo $html->image('icons/alert.png',array("style"=>"vertical-align:text-top"));?></span>
      	<span class="hide">
      		<?php echo $form->hour('hour');?>
      		<?php echo $form->minute('minute');?>
      	</span>
      	-->
      </div>
      <div style="float: left; margin-left: 5px; margin-top: 8px;">
      	+
      	<?php echo $html->link(__("time",true), array('#'),array('onclick'=>'return false') );?>
      </div>
      <div style="float: left; margin-left: 5px; margin-top: 8px;">
      	+
      	<?php echo $html->link(__("more",true), array('#'),array('onclick'=>'return false') );?>
      </div>
			
			<div id="ite-tagsInputWrp" class="ite-tagsInputWrp">
				<span id="ite-tagIcon"><?php echo $this->Html->image('icons/tag_deb887_16x16.png',array('title'=> __('Click to add tags to the new item',true) ) );?></span>
				
				<script id="ite-tagsToAddTmpl" type="text/x-jquery-tmpl"> 
    			<span class="ite-tagToAdd">${tag}</span>
				</script>
				
				<span id="ite-tagsToAdd"></span>
			</div>

      <div class="" style="margin-top:4px;float:right;">
   			<ul id="icons" class="ui-widget ui-helper-clearfix">
   				<li id="saveItemMain" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></li>
   				<li  class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cancel"></span></li>
   			</ul>     
      </div>
    </div>
    <div id="itemTypeList" class="hide" style="float:left;background-color:#ddd;padding:5px;">
    	<?php foreach($itemTasks as $v ):?>
	      <span id="itT_<?php echo $v['n'];?>" class="itemType itT<?php echo $v['n'];?>"><?php echo $v['t'];?></span>
	    <?php endforeach ?>      
    </div>
  
  
    <div class="ite-tagsCloudWrp">
			    <div id="ite-tagsCloud" class="ite-tagsCloud hide" title="<?php __('Click on the tag to attach to the item');?>">
			    		<span style="color:gray;"><?php echo __('Tags for the project',true).'&nbsp;'.$curPrj[0]['Project']['name'];?></span>
							<ul id="ite-tagCloudList" class="ite-tagCloudList">
								
							<?php if( isset($tags) && $tags !== array() ): ?>
								<?php foreach($tags as $tag):?>
									<?php echo '<li class="ite-tag"><span class="ite-tagName">'.$tag["Tag"]["name"].'</span><span>('.$tag["Tag"]["occurrence"].');</span></li>';?>
								<?php endforeach ?>
							<?php endif ?>
								
							<?php 
								/*
								echo $this->TagCloud->display($tags, array(
									'before' => '<li size="%size%" class="ite-tag">',
									'after' => '</li>'));
								*/
							?>
							</ul>
							
							<?php	echo $this->Form->input('tags',array('id'=>'ite-tagsInput','label'=>false,'div'=>false));?>
							<?php echo $this->Form->button(__('new tag',true), array('div'=>false,'id'=>'ite-tagsAdd','class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only') );?>
							
			    </div>
    </div>
    
    <div id="newItemFormBottom">
      <?php echo $this->Form->input( 'item',array('label'=>false, 'div'=>true) );?>
    </div>
	</div>  
</div>