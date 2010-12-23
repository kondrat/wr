<div class="span-18" style="margin: 0 0 .5em 0;">
    <div  class="span-5 append-1" style="margin:.6em 0 0.2em 0;">
        <span id="allPrj" style="">
            <?php echo $html->link(__('All', true), array('controller' => 'items', 'action' => 'todo'), array('id' => 'allItems')); ?>
        </span>&nbsp;
        <span id="curPrj" class="actPrj" style="">
            <?php if (isset($userPrj)): ?>
                <?php echo $html->link($userPrj[0]['Project']['name'], array('controller' => 'items', 'action' => 'todo', 'prj:' . $userPrj[0]['Project']['id']), array('id' => 'prj-prjItems')); ?>

                <?php
                $curPrjObj = $js->object(
                                array(
                                    'prjName' => $userPrj[0]['Project']['name'],
                                    'prjId' => $userPrj[0]['Project']['id']
                                )
                );
                ?>
                <?php echo $html->scriptBlock('var pObj = ' . $curPrjObj . ';', array('inline' => false)); ?>			


            <?php else: ?>
                <?php echo $html->link(__('My project', true), array('controller' => 'items', 'action' => 'todo'), array('id' => 'prj-prjItems')); ?>
            <?php endif ?>
        </span>&nbsp;

        <?php echo $html->link('<span>' . __('projects', true) . '</span><span class="upDownArr"></span>', array('#'), array('id' => 'prj-newProject', 'escape' => false)); ?>
        <?php echo $this->element('pageHead/projectEditor/project_editor'); ?> 		   	
    </div>
    <?php echo $this->element('pageHead/threeWaysMenu/three_ways_menu'); ?>


</div>
<div id="ite-newItemBtnWrp">
    <?php echo $html->link(__('New', true) . '<span class="upDownArr">' . __('task', true) . '</span>', array('#'), array('onclick' => 'return false', 'class' => 'ite-newItemBtn', 'id' => 'ite-newItemBtn', 'title' => 'for tipsy', 'escape' => false)); ?> 
</div>


<?php echo $this->element('pageHead/itemEditor/item_editor'); ?>
