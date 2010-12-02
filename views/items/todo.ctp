<?php
    $aObj = $js->object($itemTypes);
    $bObj = $js->object($itemStatuses);
//  @TODO  must be data instead of global var
    echo $html->scriptBlock('var itT = ' . $aObj . ';var itS = ' . $bObj . ';', array('inline' => false));
?>

<?php echo $this->element('pageHead/tagCloud/tag_cloud'); ?>

<?php echo $this->element('pageHead/page_head'); ?>

<!-- must be deleted. we have common editor now-->
<script id="ite-itemViewTmpl" type="text/x-jquery-tmpl"> 
  <div class="itemViewBlock">
    <div class="itemDataBlock">
      <div class="itp-tagsAddedWrp">
        <span class="itp-tagIcon"><?php echo $this->Html->image('icons/tag_deb887_16x16.png', array('title' => __('Click to add tags to the new item', true))); ?></span>
        <span class="itp-tagsAdded">
				    				{{each itemTags}}
          <span data-itemt="${itemId}" class="ite-tagAdded">${itemTag}</span>
					    			{{/each}}
        </span>

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
      <div style="padding:5px;margin-top:20px;"><textarea class="itemTextArea" name="data[itemText]" style="height: 10px;"></textarea></div>
      <div>more</div>
    </div>
  </div>

</script>


<script id="itp-itemTmpl" type="text/x-jquery-tmpl">

  <div id="${Item.id}" class="itp-item ${Item.statusClass} span-17">

    <div class="itp-itemHead">

      <div class="textItem">
        <span class="itp-itemType ${Item.typeClass}">${Item.typeText}</span>
        <span class="itemCrated">${Item.created}</span>
        <span class="itp-targetItem">${Item.target}</span>

		{{each Tag}}
          <span data-itemtagid="${Tagged.id}" class="itp-itemTag">${name}</span>
		{{/each}}

        <span class="itemHead">${Item.item}</span>
      </div>
      <div class="statusItem">${Item.statusText}</div>
    </div>
  </div>

</script>	

<div id="itp-itemPages" class="itp-itemsWrp span-17">	
  <?php //echo $this->element('item/item_page'); ?>
</div>
   




<div class="span-24">
  <h5 style="color:red;">to del: views/items/todo.ctp</h5>
  <?php echo $this->Form->button('fucus', array('id' => 'fucusEd')); ?>
  <div id="editable" class="span-4">
    <span>You text here:</span>
    <span id="ll" contenteditable="true">
				test test
				test
    </span>
  </div>
</div>
