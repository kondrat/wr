	<div class="textUploadBlock">
		<div class="span-14" style="margin:1em 0 0;">	
			<div class="span-8" style="font-style:italic;margin-top:1em;font-weight:bold;;">
				<?php __('Copy and paste text you are working on');?>
			</div>
		</div>	
		
	
		<div class="span-14">
			<?php echo $form->textarea('text',array('class'=>'textUpload'));?>
		</div>
		<div class="span-14 textUploadControl">
			<?php echo $form->button(__('Upload text',true),array('id'=>'uplaodText') );?>
			<div class="enlarge" style="float:right;font-size:8pt;">
				<?php echo $html->image('icons/down_arrow.png');?>&nbsp;<span style="vertical-align:top;"><?php __('enlarge');?></span>
			</div>
			
			<div class="decrease hide" style="float:right;font-size:8pt;margin-right:1em;">
				<?php echo $html->image('icons/up_arrow.png');?>&nbsp;<span style="vertical-align:top;"><?php __('decrease');?></span>
			</div>		
		</div>
	
	
		<div class="span-6 fileTextUploadMenu last" style="font-size:larger;font-style:italic;margin:1em 0;font-weight:bold;">
			<div style="font-size:smaller;margin-top:4px;"><?php __('or');?></div>
			<div style="border-bottom:1px dashed;"><?php __('upload text file');?></div>
			<div class="upDownSmallArrow"></div>		
		</div>
		
		<div class="span-14 fileTextUploadWrapper hide" style="margin-bottom:1em;padding:0.6em;border:1px dashed;">
			<div style="margin-bottom:.5em;">
				<?php echo $form->input('file',array('type'=>'file','class'=>'fileTextUpload','div'=>false,'label'=>false));?>
				<span style="color:gray;margin-left:1em;"><?php __(' only extantions: (*.txt, *.rtf, *.doc)');?></span>
			</div>
			<div>
				<?php echo $form->button(__('Upload file',true));?>
			</div>
		</div>		
	</div>