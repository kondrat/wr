<?php
    $targetDay = __('Target day', true);
    echo $html->scriptBlock('var targetDay = "' . $targetDay . '";');
?>

<script id="ite-itemEditorTmpl" type="text/x-jquery-tmpl">

    <div class="ite-itemEditor">

        <div class="ite-newItemFormTop">
            
            <div class="ite-itemTypeCtrl">
                <span class="ite-itemType itT<?php echo $itemTypes[0]['n'];?>"><?php echo $itemTypes[0]['t']; ?></span>
                
                <div  class="ite-itemTypeList hide">
                    <div class="ite-itemTypeListInner">
                        <?php foreach ($itemTypes as $v): ?>
                            <span id="itT_<?php echo $v['n']; ?>" class="ite-itemType itT<?php echo $v['n']; ?>"><?php echo $v['t']; ?></span>
                        <?php endforeach ?>   
                    </div>
                    <div class="ite-itemTypeListClose" style="cursor: pointer;">
			x
                    </div>
                </div>  
                
            </div>
            <div class="ite-datePickerWrp">
                <?php echo $this->Form->input('datepicker', array('label' => false, 'div' => false, 'class' => 'datepicker', 'id' => '${datepicker}', 'default' => $targetDay)); ?>
            </div>
            <div id="ite-tagsAddedWrp" class="ite-tagsAddedWrp">              
                <span class="ite-tagIcon"><?php echo $this->Html->image('icons/tag_deb887_16x16.png', array('title' => __('Click to add tags to the new item', true))); ?></span>
                <span class="ite-tagsAdded">
                    {{tmpl(Tag) "#ite-tagsAddedTmpl"}}
                </span>             
            </div>

            <div class="ite-itemSaveCtrl">
                <ul class="ite-icons ui-widget ui-helper-clearfix">
                    <li id="ite-saveItemMain" class="ite-saveItemMain ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></li>
                    <li id="ite-cancelSaveItem" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cancel"></span></li>
                </ul>     
            </div>
        </div>
 


        <div class="ite-newItemFormBtm">
            <?php echo $this->Form->input('item', array('label' => false,'class'=>'ite-newItemText', 'div' => true,'id'=>false)); ?>
        </div>

    </div>

</script>

<script id="ite-tagsAddedTmpl" type="text/x-jquery-tmpl">
    <span class="ite-tagAdded" data-itemtagid="${taggedid}">${name}</span>
</script>

<div id="ite-itemEditorWrp" class="hide"></div>