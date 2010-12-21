<div id="tgc-tagCloudWrp" class="tgc-tagCloudWrp hide">
    <div id="tgc-tagCloudHeader" class="tgc-tagCloudHeader">
        <h3>tag cloud</h3>
        <div id="tgc-tagCloudClose">
            <b>x</b>
        </div>
    </div>
    <div class="tgc-tagCloud">
     
        <div class="tgc-tagCloudInner">
            <span style="color:gray;"><?php echo __('Tags for the project', true) . '&nbsp;<span class="tgc-prName">' . $curPrj[0]['Project']['name'].'</spna>'; ?></span>
            <ul id="tgc-tags" class="tgc-tags">
                <?php if (isset($tags) && $tags !== array()): ?>
                        
                    <?php $tagsObj = $js->object($tags); ?>														
                    <?php echo $html->scriptBlock('jQuery(document).ready(function(){ $("#tgc-tags").data("tgcObj",' . $tagsObj . '); });', array('inline' => false)); ?>								
                    <script id="tgc-tagsCloudAddTmpl" type="text/x-jquery-tmpl"> 
                        <li class="tgc-tag tgc-tagNameCl" data-tagn="${Tag.name}" ><span class="tgc-tagName">${Tag.name}</span><span class="tgc-occur">(${Tag.occurrence})</span>;</li>
                    </script>										
                        
                <?php endif ?>
            </ul>
            <?php echo $this->Form->input('tags', array('id' => 'tgc-tagsInput', 'label' => false, 'div' => false)); ?>
            <?php echo $this->Form->button(__('new tag', true), array('div' => false, 'id' => 'tgc-tagsAdd', 'class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')); ?>
        </div>
            
    </div>
</div>

