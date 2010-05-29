<?php 
	$items = array(
	__('Type in word or phrase',true) => array('controller'=>'cards','action'=>'index'),
	__('Upload text and select',true) => array('controller'=>'texts','action'=>'add'),
	__('Print out your set',true) => array('controller'=>'cards','action'=>'printset'),
	); 
	$here = Router::url(substr($this->here, strlen($this->webroot)-1)); 
?>                    

<div class="prepend-4 span-20 last threeWays">
	<?php foreach ($items as $name => $link): ?>
		<div class="topT">
			<?php if (Router::url($link) == $here): ?>
				<?php echo $html->link($name,$link,array('class'=>'threeWaysHere','style'=>'color:red;cursor:text;','onclick' => 'return false') );?>
			<?php else: ?>
				<span style="font-style:italic;"><?php __('or');?></span>&nbsp;&nbsp;
				<?php echo $html->link($name,$link,array('class'=>'threeWaysOne') );?>
			<?php endif ?>
		</div>
	<?php endforeach ?>
</div>