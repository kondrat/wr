<?php
    $itemTypes = Configure::read('itemTypes');       
    $itemStatuses = Configure::read('itemStatuses');
    $aObj = $js->object($itemTypes);
    $bObj = $js->object($itemStatuses);
//  @TODO  must be data instead of global var
    echo $html->scriptBlock('var itT = ' . $aObj . ';var itS = ' . $bObj . ';', array('inline' => false));
?>

<?php echo $this->element('pageHead/tagCloud/tag_cloud'); ?>

<?php echo $this->element('pageHead/page_head'); ?>

<script id="itp-itemTmpl" type="text/x-jquery-tmpl">

  <div id="${Item.id}" class="itp-item ${Item.statusClass} span-17">

    <div class="itp-itemHead">

      <div class="textItem">
        <span class="itp-itemType ${Item.typeClass}">${Item.typeText}</span>
        <span class="itemCrated">${Item.created}</span>
        <span id="dp-${Item.id}" class="itp-targetItem">${Item.target}</span>

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
    <div id="itp-itemPagesWait">I'm waiting...</div>
</div>
<div id="itp-paginatorWrp"></div>
