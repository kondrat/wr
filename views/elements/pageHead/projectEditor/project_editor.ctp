<div class="prj-newProject">
    <div id="prj-projectEditor" class="hide"> 

        <ul id="prj-prjMainList">logo</ul>
        
        <?php echo $html->link('<span class="upDownArr">' . __('New', true) . '</span>', array('#'), array('id' => 'prj-prjNew', 'escape' => false, 'class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')); ?>
       
        <div id="prj-prjNewInput" class="hide">
            <?php echo $form->input('prj-newPr', array('label' => false, 'div' => false)); ?>
            <?php echo $form->button('save', array('id' => 'prj-newPrSave', 'class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')); ?>
            <?php echo $form->button('cancel', array('id' => 'newPrCancel', 'class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')); ?> 
        </div>

    </div>   
</div>


<?php $userPrjObj = $js->object($userPrj);?>
<?php echo $html->scriptBlock('jQuery(document).ready(function(){$("#prj-projectEditor").data("uPrObj",' . $userPrjObj . ');});', array('inline' => false)); ?>

<script id="prj-prjTmpl" type="text/x-jquery-tmpl">

    
        
        <li class="prj-prjList">

            <a id="prj_${Project.id}" href="#" onclick="return false" data-prjid="${Project.id}">${Project.name}</a>
            <ul class="prj-prjControl ui-widget ui-helper-clearfix">
                <li class="prj-prjEdit ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pencil"></span></li>
                <li class="prj-prjDel ui-state-default ui-corner-all"><span class="ui-icon ui-icon-trash"></span></li>
            </ul>

        </li>
        
 
        
</script>