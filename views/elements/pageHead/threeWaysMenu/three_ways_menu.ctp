<?php 
	$items = array(
	__('Diary',true) => array('controller'=>'items','action'=>'diary'),
	__('ToDo',true) => array('controller'=>'items','action'=>'todo'),
	__('Notes',true) => array('controller'=>'items','action'=>'note'),
	); 
	$here = Router::url(substr($this->here, strlen($this->webroot)-1)); 
?>                    

<div id="threeWays" class="span-7">
	<?php foreach ($items as $name => $link): ?>
		<div class="span-2">
			<?php if (Router::url($link) == $here): ?>
				<?php echo $html->link($name,$link,array('id'=>'threeWaysHere','onclick' => 'return false') );?>
			<?php else: ?>
				
				<?php echo $html->link($name,$link,array('class'=>'threeWaysOne') );?>
			<?php endif ?>
		</div>
	<?php endforeach ?>
</div>