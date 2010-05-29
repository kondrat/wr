  	<?php 
  		$sideA = array(
  __('most popular',true) =>		array(
									"en" => __("English",true),
									"ru" => __("Russian",true),
									"fr" => __("French",true),
									"de" => __("German",true),
									"it" => __("Italian",true),
									"es" => __("Spanish",true),
									"uk" => __("Ukrainian",true)									
						),
	__('asia',true) => array(
									"ar" => __("Arabic",true),
									"zh-CN" => __("Chinese",true),
									"tl" => __("Filipino",true),								
									"iw" => __("Hebrew",true),
									"hi" => __("Hindi",true),
									"id" => __("Indonesian",true),
									"ja" => __("Japanese",true),
									"ko" => __("Korean",true),
									"ms" => __("Malay",true),	
									"fa" => __("Persian",true),
									"th" => __("Thai",true),								
									"tr" => __("Turkish",true),																	
									"vi" => __("Vietnamese",true),
									"yi" => __("Yiddish",true),	
						),
	__('europe',true) => array(									
									"sq" => __("Albanian",true),									
									"be" => __("Belarusian",true),
									"bg" => __("Bulgarian",true),
									"ca" => __("Catalan",true),								
									"hr" => __("Croatian",true),
									"cs" => __("Czech",true),
									"da" => __("Danish",true),
									"nl" => __("Dutch",true),
									"et" => __("Estonian",true),									
									"fi" => __("Finnish",true),
									"gl" => __("Galician",true),
									"el" => __("Greek",true),									
									"hu" => __("Hungarian",true),
									"is" => __("Icelandic",true),									
									"ga" => __("Irish",true),
									"lv" => __("Latvian",true),
									"lt" => __("Lithuanian",true),
									"mk" => __("Macedonian",true),									
									"mt" => __("Maltese",true),
									"no" => __("Norwegian",true),									
									"pl" => __("Polish",true),
									"pt" => __("Portuguese",true),
									"ro" => __("Romanian",true),
									"sr" => __("Serbian",true),
									"sk" => __("Slovak",true),
									"sl" => __("Slovenian",true),									
									"sv" => __("Swedish",true),																	
									"cy" => __("Welsh",true)
									 
									),
	__('africa and more',true) => array(
									"af" => __("Afrikaans",true),
									"ht" => __("Haitian Creole ALPHA",true),
									"sw" => __("Swahili",true)										
									)				
  		);
  	?>  

<div id="langPad" class="span-10 popUpPad hide" style="">
  <div class="span-10" style="border-bottom:1px solid gray;margin-bottom:0.5em;padding-bottom:0.5em;position:relative;">
  	   	 	
    <div class="span-5" style="">
    	<div class="langPadLabel"><?php __('Side A');?></div>
    	<?php echo $form->input('sideA', array('selected'=>'en','label'=>false,'options' => $sideA)); ?>
    </div>   
    <div class="span-5 last" style="">
    	<div class="langPadLabel"><?php __('Side B');?></div>
    	<?php echo $form->input('sideB', array('selected'=>'ru','label'=>false,'options' => $sideA)); ?>
    </div>
    <div id="closeLangPad"></div>
    		    	  
  </div>
  
  <div class="span-10" style=""><?php echo $form->button(__("Submit",true),array('id'=>'langPadSubmit') );?></div>
  
</div>			    	  	