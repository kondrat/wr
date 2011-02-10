<div id="ite-newItemBtnWrp">
    <?php echo $html->link(__('New', true) . '<span class="upDownArr">' . __('task', true) . '</span>', array('#'), array('onclick' => 'return false', 'class' => 'ite-newItemBtn', 'id' => 'ite-newItemBtn', 'title' => 'for tipsy', 'escape' => false)); ?>
    <span style="display:block;float: left; margin: 5px 10px;">
        <?php __('Show'); ?>:&nbsp;

    </span>

    <span style="display:block;float: left;margin:5px 10px 5px 0;">

        <span id="curPrj" class="actPrj" style="">
            <?php if (isset($userPrj)): ?>
                <span id="prj-prjItems"><?php echo $userPrj[0]['Project']['name']; ?></span>
                <!-- @todo to remove this -->
                <?php
                $curPrjObj = $js->object(
                                array(
                                    'prjName' => $userPrj[0]['Project']['name'],
                                    'prjId' => $userPrj[0]['Project']['id']
                                )
                );
                ?>
                <?php echo $html->scriptBlock('var pObj = ' . $curPrjObj . ';', array('inline' => false)); ?>			

            <?php endif ?>
        </span>&nbsp;

        <?php echo $html->link('<span class="upDownArr"></span>', array('#'), array('id' => 'prj-newProject', 'escape' => false)); ?>
        <?php echo $this->element('pageHead/projectEditor/project_editor'); ?> 		   	
    </span>




    <span style="display:block;float: left;font-style: italic;margin: 5px 5px 5px 0;"><?php __('opend'); ?></span>
    <span style="display:block;float: left; margin: 5px 10px;">
        <?php __('tags'); ?>
    </span>
</div>




<?php echo $this->element('pageHead/itemEditor/item_editor'); ?>
