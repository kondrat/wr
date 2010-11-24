jQuery(document).ready(function(){

			var $com1_contentWrapper = $(".contentWrapper");
			var $com1_alertMessage = $('#flashMessage');
			var $com1_itpItemPages = $("#itp-itemPages");
			var $com1_item = $("#item");
			//var $com1_statusItem = $("#status");
			var $com1_targetDay = $("#targetDay");
			var $com1_targetMonth = $("#targetMonth");
			var $com1_targetYear = $("#targetYear");
			var $com1_hourHour = $("#hourHour");
			var $com1_minuteMin = $("#minuteMin");
			var $com1_newItemForm = $("#newItemForm");
			var $com1_newItem = $("#newItem");
			var $com1_saveItemMain = $("#saveItemMain");
			var $com1_quickLogin = $("#quickLogin");
			var $com1_datePicker = $("#datepicker");
			var $com1_dataPickerTip = '';
			var $com1_itemTypeControl = $("#itemTypeControl");
			var $com1_itemTypeList = $("#itemTypeList");
			var $com1_itT = '';
			var $com1_itS = '';
			var $com1_itTLenght = 0;
			var $com1_itSLenght = 0;
			
			//tags 
			
			//tags in editor
			var $com1_iteTagIcon = $("#ite-tagIcon");
			var $com1_iteTagsAddedTmpl = $("#ite-tagsAddedTmpl");
			var $com1_iteTagsAdded = $("#ite-tagsAdded");
			var $curItemTagList = '';
			//May be page item?
			var $com1_iteItemViewTmpl = $("#ite-itemViewTmpl");
			
			//tags in tagCloud
			var $com1_tgcTagCloudWrp = $("#tgc-tagCloudWrp");
			var $com1_tgcTagCloudClose = $("#tgc-tagCloudClose");
			var $com1_tgcTagsInput = $("#tgc-tagsInput");
			var $com1_tgcTags = $("#tgc-tags");
			var $com1_tgcTagsCloudAddTmpl = $("#tgc-tagsCloudAddTmpl");
			var $com1_tgcTagsAdd = $("#tgc-tagsAdd");


		if( typeof(targetDay) !== "undefined") $com1_dataPickerTip = targetDay;
		
		//getting item Task from view file.
		if( typeof(itT) !== "undefined"){
			$com1_itT = itT;
			$com1_itTLenght = itT.length;
		}
		//getting item Status from view file.
		if( typeof(itS) !== "undefined"){
			$com1_itS = itS;
			$com1_itSLenght = itS.length;
		}
		
		//flash alert message 	  

		if($com1_alertMessage.length) {
				var alerttimer = window.setTimeout(function () {
					$com1_alertMessage.trigger('click');
				}, 4500);
				$com1_alertMessage.animate({height: [$com1_alertMessage.css("line-height") || '52', 'swing']}, 400).click(function () {
					window.clearTimeout(alerttimer);
					$com1_alertMessage.animate({height: '0'}, 400);
					$com1_alertMessage.css({'border':'none'});
				});
		}

		//New item controll

		var $com1_newItemClick = function(e){
			var thisClBut = $(this);
			if(e) e.stopPropagation();
			if(e) e.preventDefault();		
  		if( $com1_newItemForm.is(":hidden") ) {
  			$com1_newItemForm.show();
  			$com1_item.focus();
  			$com1_newItem.addClass("newItemActive");
  		} else {
  			$com1_newItemForm.hide();
  			$com1_newItem.removeClass("newItemActive");
  		}
  		//console.log(e.target);
		};


  	$com1_newItem.click($com1_newItemClick);
		//$com1_newItemForm.bind( "clickoutside", $com1_newItemClick);
  	
  	$(".ui-state-default").hover(function(){
  		$(this).addClass("ui-state-hover");
  	},function(){
  		$(this).removeClass("ui-state-hover");
  	});
		/*
		//click outside canceled
		var nItFormClOutSide = function(event){	
		
			target = $(event.target);			
			var idTarg = target.attr('id');			
			var qlog = $com1_quickLogin;

			if ( qlog[0] !== undefined && $.contains(qlog[0], event.target) ) {	
				return;
			}
			
			if (  $.contains( $("#ui-datepicker-div")[0], event.target) ) {	
				return;
			}
			
			
			//exclude some id
			var arr = [ "overlay","headWrap" ]; 
			if( $.inArray( idTarg, arr) === -1   ) {
				$(this).hide();
			}			
		};
		
		$com1_newItemForm.bind( "clickoutside", nItFormClOutSide );
		*/
			
		
			$com1_datePicker.datepicker({ 
					
					dateFormat: 'dd.mm.yy',

					buttonImage: "../img/icons/cal.png",
					showOn: 'both', 
					buttonImageOnly: true,

					autoSize: true,
					showAnim: "",
					showButtonPanel: true
					
			});
	



    //item Ajax save;

    
    $com1_saveItemMain.click(function(){
			var dateFromInput = $com1_datePicker.val();
			try{
				var parsedDate = $.datepicker.parseDate('dd.mm.yy', dateFromInput );
				//return true;
			}
			catch(e){
				parsedDate = null;
			}
			
			if(parsedDate) {
   			var tosend = new Date(parsedDate);
   			var epoch =  parseInt(tosend.getTime()/1000);
   		} else {
   			var epoch = '';
   			dateFromInput = 'No target';
   		}
   		//alert(tosend.getTime()+' '+(tosend.getMonth()+1)+' '+tosend.getFullYear()+' ');
   		
   		
			var itemVal = $com1_item.val();
			var itemTask = $com1_itemTypeControl.find("span:first").data("type");

			var itemTags = new Array();

			$com1_iteTagsAdded.children().each(function(){
				var thisTag = $(this);
				itemTags.push(thisTag.text()); 
			});

	    var itemObj = {
	    								"data[item]": itemVal,
	    								"data[prj]" : pObj.prjId,
	    								"data[target]" : epoch,
	    								"data[task]": itemTask,
	    								"data[tags]": itemTags

	    								//"data[hour]" : $com1_hourHour.val(),
	    								//"data[min]" : $com1_minuteMin.val()
	    							};
    				
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: itemObj,
        success: function(data) {
        	
					userReg = 1;
					
					var itemTaskT = 'todo';
					var itemTaskCl = 'itemType itT0';
					var itemId = 0;

					
        	if ( data.stat === 1 ) {        		

						if( $com1_itT !== '') {
							$.each($com1_itT, function(i,v){
								if( v.n == data.task ) { 

									itemTaskT = v.t;
									itemTaskCl = 'itemType itT'+v.n;
									itemId = data.id;

									return;
								}
							});	
						} else {
							itemTaskCl = $com1_itemTypeControl.children("span:first").attr("class");
							itemTaskT = $com1_itemTypeControl.children("span:first").text();						
						}	

						
						$com1_itpItemPages.prepend(						
						  '<div id="item_'+itemId+'" class="item itS0 span-17">'+						  	
						    '<div class="itemHeadLine">'+						    
						    	'<div class="targetItem">'+dateFromInput+'</div>'+							   
						    	'<div class="textItem">'+						    	
						    		'<span class="itemType '+itemTaskCl+'">'+itemTaskT+'</span>'+										
							    	'<span class="itemCrated">Just now</span>'+
							    		'<span class="itemHead">'+
								    	itemVal+					    	
								    	'</span>'+  							    	
						    	'</div>'+					 				    
						    	'<div class="statusItem">[opend]</div>'+					    
						    '</div>'+
						  '</div>'
						  												
						);
						$com1_datePicker.val('No target');
						$com1_item.val('').focus();
          	//flash_message('saved','flok');
          	
          } else {
          	flash_message('not saved','fler');
          }
          
          
        },
        error: function(){
            alert('Problem with the server. Try again later.');
        }
      });
    }); 
 



	//more controls
	$com1_saveItemMain.next().click(function(){
		$com1_item.val('');
		$com1_datePicker.val($com1_dataPickerTip);
		$com1_newItemForm.hide();
	});
	$("#timeToggle").click(function(){
		$(this).next().toggle();		
	}); 


	
/*
//z-index for ie7
$(function() {
	var zIndexNumber = 1000;
	$('div').each(function() {
		$(this).css('zIndex', zIndexNumber);
		zIndexNumber -= 10;
	});
});
*/
	

  
  //more decorations
	  $(".itp-item").live("mouseover mouseout", function(event){
				  if (event.type == 'mouseover') {
				    $(this).addClass("activeItem");
				  } else if (event.type == 'mouseout' ) {
				    $(this).removeClass("activeItem");
				  }	
		});


		
		$com1_itpItemPages.delegate(".itemHeadLine","click",function(){
			
			var thisIt = $(this);
			var thisPar = thisIt.parent();
			var thisItem = thisIt.next();
			
			
			if( thisItem.length >= 1 ) {
				
				if(thisItem.is(":hidden")) {
					$com1_itpItemPages.find("div.itemViewBlock").hide();
					$com1_itpItemPages.find("div.itp-item").removeClass("itemToEdit");
					thisPar.addClass("itemToEdit");				
					thisItem.show();
				} else {				
					thisItem.hide();
					thisPar.removeClass("itemToEdit");
				}	
							
			}else{
				
				var origText = $.trim( thisIt.find("span.itemHead").text() );
				thisPar.data("origText",origText);
				
				var $origTags = thisIt.find(".itp-itemTag");
				
				var origTagsToIns = new Object();
				$origTags.each(function(i){
					var $thisI = $(this);
					var thisTagText = $thisI.text();
					var thisTaggedId = $thisI.data("itemtag");
					origTagsToIns[i] = {itemTag:thisTagText,itemId:thisTaggedId};
				});

				$com1_itpItemPages.find("div.itemViewBlock").hide();
				$com1_itpItemPages.find("div.itp-item").removeClass("itemToEdit");
				thisPar.addClass("itemToEdit");
				
				
				//inserting view blok with full text and tags and so on after item's header.			
				$com1_iteItemViewTmpl.tmpl({origText:origText,itemTags:origTagsToIns}).insertAfter(thisIt);		
			}
				

		});







		$com1_itpItemPages.delegate(".itemEdit","click",function(){

			var thisItEd = $(this);
		
			var thisPar = thisItEd.parents(".itemViewBlock");
			
			thisPar.find("div.itemDataBlock").hide().end().find("div.itemEditBlock").show();
			

			
			var origText = '';
			origText = thisPar.parent().data("origText");
			
			thisPar.find("textarea").val(origText).elastic();			
		});


		
		$com1_itpItemPages.delegate(".itemDel","click",function(){		
		
				var parId = $(this).parents(".itp-item");
				
		    if (confirm('Are you sure to delete?')) {	
		 //to validate
		    	var itId = parId.attr("id").replace("item_", "");
		    	if( typeof(itId) !== "undefined" && itId !== "" ) {	    		
							$.ajax({
									dataType:"json",
									type: "POST",
									data: {"data[itId]":itId},
									success:function (data, textStatus) {
										if( data.stat === 1) {
											parId.children().css({"background-color":"lightPink"}).end().fadeOut(600 ,function(){
												$(this).remove();
											});					
										} else {
											flash_message("Couldn't be deleted", "fler" );
										}
									},
									url: path+"\/items\/delItem",
									error:function(){
										alert('Problem with the server. Try again later.');
									}
							});  						  		
		    	}
		    } 
			
		});


		$com1_itpItemPages.delegate(".itemSubmit","click",function(){
					
					var parIt = $(this).parents(".itp-item");
//to clear id.
		    	var itId =  parIt.attr("id").replace("item_", "");
		    	var itemVal = parIt.find(".itemTextArea").val();

		    	
		    	var itemObj = {
		    				"data[id]":itId,
	    					"data[item]": itemVal
	    				};
	    				
		    	if( typeof(itId) !== "undefined" && itId !== "" ) {	    		
							$.ajax({
									dataType:"json",
									type: "POST",
									data: itemObj,
									success:function (data, textStatus) {
										if( data.stat === 1) {
											
											//parIt.data("origText",data.word);
											parIt.data("origText",data.word).find("div.itemEditBlock").hide().prev().show().find("span.origText").text(data.word);
											parIt.find("span.itemHead").text(data.word);
											parIt.children(".itemViewBlock").animate(
												{"background-color": "lightgreen"},{duration: 1000}
											).animate(
												{"background-color": "#fffff0"},{duration: 1000}
											);
										} else {
											flash_message("Couldn't be edited", "fler" );
										}
									},
									url: path+"\/items\/saveItem",
									error:function(){
										alert('Problem with the server. Try again later.');
									}
							});
													  		
		    	}
		    	 
		});

		$com1_itpItemPages.delegate(".itemCan","click",function(){
			var parId = $(this).parents("div.itemEditBlock");
			parId.prev().show().end().hide();
		});




		
//top menu decoration and control
	$("#logInNow").hover(function(){
			$(this).addClass("logInHov");
		},
		function(){
			$(this).removeClass("logInHov");
		}
	).click(function(e){
		
				if(e) e.stopPropagation();
				if(e) e.preventDefault();		
			
		if ( $com1_quickLogin.is(":hidden") ) {
			$(this).addClass("logInAct");
				
			$("#overlay").show();
		} else {
			$("#overlay").hide();
			$(this).removeClass("logInAct");
		}
		//ie 7 bug fix;
		$com1_quickLogin.appendTo("body");
		
		$com1_quickLogin.toggle();
		$("#UserUsername").focus();
		
		return false;
	});
 	
 	$com1_quickLogin.bind('clickoutside', function(){
 		$("#logInNow").removeClass("logInAct");
 		$(this).hide();
 		$("#overlay").hide();
 		
 	});

	$com1_itpItemPages.delegate(".statusItem","mouseenter",function(){
		$(this).addClass("activeStatusItem");
	}); 

	$com1_itpItemPages.delegate(".statusItem","mouseleave",function(){
		$(this).removeClass("activeStatusItem");	
	});

	$com1_itpItemPages.delegate(".statusItem","click",function(event){
		//event.stopPropagation();

		var thisIt = $(this).parents(".itp-item");
		//getting item id
		var itId = thisIt.attr("id").replace("item_","");
		//finding statusItem class
		var statIt = thisIt.find(".statusItem");

		if( typeof(this.i) === "undefined" ){
			this.i = 0;
			statIt.data({'origClass':thisIt.attr("class"),'origText':statIt.text()});
		}		
		
		var statusIt = 0;		
		for ( var i=0; i <= $com1_itSLenght; i++ ) {
			var curClass = "itS"+$com1_itS[i].n;
			var newClass;
			if(thisIt.hasClass(curClass) ) {
				if( (1+i) < $com1_itSLenght ){
					statusIt = 1+i;					
				} else {
					statusIt = 0;
				}
				newClass = "itS"+$com1_itS[statusIt].n;
				thisIt.removeClass(curClass).addClass(newClass);
				statIt.text($com1_itS[statusIt].t);
				break;
			}	
				
		}
		
		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: {"data[status]":$com1_itS[statusIt].n,"data[id]":itId},
        success: function(data) {
					
        	if ( data.stat === 1 ) {        		

          	statIt.data({'origClass':thisIt.attr("class"),'origText':statIt.text()});
          } else {
          	flash_message('Status not saved','fler');
          	thisIt.attr("class",statIt.data('origClass'));
          	statIt.text(statIt.data('origText'));
          }
          
          
        },
        error: function(){
          	thisIt.attr("class",statIt.data('origClass'));
          	statIt.text(statIt.data('origText'));
            alert('Problem with the server. Try again later.');
        }
      });
			
		},1000);		
		
		return false;
		
	}); 
 
	//task of item change "crutilca"

	$com1_itpItemPages.delegate(".itemType","click",function(event){

		var thisIt = $(this);
		var thisPar = thisIt.parents(".itp-item");
		//getting item id
		var itId = thisPar.attr("id").replace("item_","");
		
		//creating this data with first click for blackup in case of falure.
		if( typeof(this.i) === "undefined" ){
			this.i = 0;
			thisIt.data({'origClass':thisIt.attr("class"),'origText':thisIt.text()});
		}

		
		var statusIt = 0;		
		for ( var i=0; i <= $com1_itTLenght; i++ ) {
			var curClass = "itT"+$com1_itT[i].n;
			var newClass;
			if(thisIt.hasClass(curClass) ) {
					//alert(curClass);
				if( (1+i) < $com1_itTLenght ){
					statusIt = 1+i;					
				} else {
					statusIt = 0;
				}
				newClass = "itT"+$com1_itT[statusIt].n;
				thisIt.removeClass(curClass).addClass(newClass).text($com1_itT[statusIt].t);
				break;
			}	
				
		}
	

		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: {"data[task]":$com1_itT[statusIt].n,"data[id]":itId},
        success: function(data) {
					
        	if ( data.stat === 1 ) {        		

          	thisIt.data({'origClass':thisIt.attr("class"),'origText':thisIt.text()});
          } else {
          	flash_message('Status not saved','fler');
          	thisIt.attr("class",thisIt.data('origClass')).text(thisIt.data('origText'));
          	
          }
          
          
        },
        error: function(){
        	thisIt.attr("class",thisIt.data('origClass')).text(thisIt.data('origText'));
          alert('Problem with the server. Try again later.');
        }
      });

		},1000);		

		return false;
		
	});  
//---------------------------------------------------------------------------------------- 

	$com1_itpItemPages.delegate(".targetItem","click",function(event){

	  event.preventDefault();
		
		//$(".targetItem").datepicker('destroy');

		var thisIt = $(this);
		var thisPar = thisIt.parents(".itp-item");
		//to clean up data id
		var itId = thisPar.attr("id").replace("item_","");
		var prevVal = thisIt.text();
		thisIt.prepend('<input type="text" value="Target day"  name="data[datepicker]" class="datefield" size="10">').children().val(prevVal); 

		thisIt.children().css({"color":"red"}).datepicker(
			{ 
					dateFormat: 'dd.mm.yy',
					autoSize: true,
					showAnim: "",
					showButtonPanel: true	,
					
					onSelect: function(dateText, inst) { 									
										},
					onClose: function(dateText, inst) {
											
											try{
												var parsedDate = $.datepicker.parseDate('dd.mm.yy', dateText );
											}
											catch(e){
												parsedDate = null;
											}
											
											if(parsedDate) {
								   			var tosend = new Date(parsedDate);
								   			var epoch =  parseInt(tosend.getTime()/1000);
								   		} else {
								   			var epoch = '';
								   			dateText = 'No target';
								   		}											
											thisIt.text(dateText);
											$(this).hide();											


										    var itemObj = {
										    								"data[id]": itId,
										    								"data[target]" : epoch
									
										    							};
    				
									      $.ajax({
									        type: "POST",
									        url: path+"/items/saveItem",
									        dataType: "json",
									        data: itemObj,
									        success: function(data) {
							
									        	if ( data.stat === 1 ) {        		
															          	
									          } else {
									          	flash_message('not saved','fler');
									          }
									          
									          
									        },
									        error: function(){
									            alert('Problem with the server. Try again later.');
									        }
      									});




																		
										}
 
			}			
		
		
		).focus();

    return false;
		
	});
	$com1_itpItemPages.delegate(".datefield","click",function(event){
		return false;
	});

	


//-----------------------------------------------------------------------------------------
 
 	//switching task type on new item editor
	$com1_itemTypeControl.click(function(){
		var thisType = $(this);		
		if( $com1_itemTypeList.is(":hidden") ) {
			$com1_itemTypeList.show();
			thisType.addClass("newItemActive");
		} else {
			$com1_itemTypeList.hide();
			thisType.removeClass("newItemActive");
		}

	});

	$com1_itemTypeList.delegate('span','click',function() {
		var thisP = $(this);
		var thisClass = thisP.attr("class");
		var thisText = thisP.text();
		var thisTaskId = thisP.attr("id").replace("itT_","");		
		$com1_itemTypeControl.children("span:first").attr("class", thisClass).text(thisText).data("type",thisTaskId);
	});
 
//-----------------------------------------------------------------------------------------

	
	//editor only mode
	$com1_iteTagIcon.click(function(){
		$com1_tgcTagCloudWrp.toggle();
		var tgcTagCloudIconPos = $com1_iteTagIcon.offset();	
		var contentWrapperPos = $com1_contentWrapper.offset();
		var setTop = tgcTagCloudIconPos.top - contentWrapperPos.top + 32;		
		var setLeft = tgcTagCloudIconPos.left - contentWrapperPos.left - 150;									
		$com1_tgcTagCloudWrp.css({"left":setLeft,"top":setTop});	
		
		if(typeof($com1_tgcTags.data("tgcObj")) !== "undefined"){			
			$com1_tgcTagsCloudAddTmpl.tmpl( $com1_tgcTags.data("tgcObj") ).appendTo($com1_tgcTags);
			$com1_tgcTags.removeData("tgcObj");			
		}							
	});	



	//all items tag Icon mode
	$com1_itpItemPages.delegate(".itp-tagIcon","click",function(){
		
		var $thisAddIcon = $(this);
		
		//memorizing the object of the current items tags so we could append more tags to it.
		$curItemTagList = $thisAddIcon.next();
		
		//toggel tag cloud window
		$com1_tgcTagCloudWrp.toggle();
		//position tag cloud window by the tag cloud icon. (may be item itself)
		var tgcTagCloudIconPos = $thisAddIcon.offset();	
		var contentWrapperPos = $com1_contentWrapper.offset();
		var setTop = tgcTagCloudIconPos.top - contentWrapperPos.top + 32;		
		var setLeft = tgcTagCloudIconPos.left - contentWrapperPos.left - 150;									
		$com1_tgcTagCloudWrp.css({"left":setLeft,"top":setTop});


		//getting tags from the dom if it's first time, or just toggling
		if(typeof($com1_tgcTags.data("tgcObj")) !== "undefined"){			
			$com1_tgcTagsCloudAddTmpl.tmpl( $com1_tgcTags.data("tgcObj") ).appendTo($com1_tgcTags);
			$com1_tgcTags.removeData("tgcObj");			
		}			
		
		
		//currnt tags object for iteration
		var $tagsItem = $curItemTagList.find(".ite-tagAdded");
		//iterating throught tags cloud and item tags to identify already choosen tags and add checked class to them.
		$tagsItem.tagCloudIteration($com1_tgcTags);
		
	});


	//iteration through each item's tag
	$.fn.tagCloudIteration = function( tagCloudObj ){
		 
		if(!tagCloudObj){
			return;
		}
		
		var $tagsFromCloud = tagCloudObj.find(".tgc-tag").removeClass("tgc-tagChecked").addClass("tgc-tagNameCl");
		
		return this.each(function(){
			var tag = $(this);	
			var thisDataTagName = tag.text();		
			$tagsFromCloud.each(function(){
				var $thisTagFromCloud = $(this);				
				if($thisTagFromCloud.data("tagn") == thisDataTagName){
					$thisTagFromCloud.removeClass("tgc-tagNameCl").addClass("tgc-tagChecked");
					return;					
				}		
			});								
		});
				
	};








	
	//clicking on tag from cloud to append to tagEditor
	$com1_tgcTags.delegate(".tgc-tagNameCl","click",function(){
		var thisTag = $(this);
		var thisName = thisTag.data("tagn");
		$com1_iteTagsAddedTmpl.tmpl( {"tag":thisName } ).appendTo($curItemTagList).data({tagid: thisTag.data("tagid") });
		thisTag.removeClass("tgc-tagNameCl").addClass("tgc-tagChecked");
	});	
	
	
	
	//remove tag from item tag list
	$com1_itpItemPages.delegate(".ite-tagAdded","click",function(){
    var thisTag = $(this);
    var thisTagParent = thisTag.parent();
    var thisTagItemId = thisTag.data("itemt");
    
    thisTag.fadeOut(500, function(){
    	thisTag.remove();
    	
    	thisTagParent.find(".ite-tagAdded").tagCloudIteration($com1_tgcTags);	
    });
	
		if(thisTagItemId){
			//ajax tag deletion to define here;
		}
			
	});
	



	
	$com1_tgcTagCloudClose.click(function(){
		$com1_tgcTagCloudWrp.hide();
	});

	
	//appendig to item tags list new tag
	$com1_tgcTagsAdd.click(function(){
		var newTag = $com1_tgcTagsInput.val();
		if(newTag.length > 0) {
			$com1_iteTagsAddedTmpl.tmpl( {"tag":newTag } ).appendTo($curItemTagList);
			$com1_tgcTagsInput.val('');
		}
	});
	//remove tag from item tag list





	$com1_tgcTagCloudWrp.draggable( {
																		handle:"#tgc-tagCloudHeader"
																		} );
	$("#tgc-tagCloudHeader").mousedown(function(){
		$com1_tgcTagCloudWrp.addClass("testt");
	});
	$("#tgc-tagCloudHeader").mouseup(function(){
		$com1_tgcTagCloudWrp.removeClass("testt");
	});


	$com1_iteTagIcon.find("img").tipsy({gravity: 's',delayIn: 1000,offset: 5});
	$com1_newItem.tipsy({gravity: 's',delayIn: 1000});
 
 









	//tests. Don't forget to del.
 	$("#fucusEd").click(function(){

 		$("#editable").trigger("click").css({color:"red"});
	});

 	$("#editable").click(function(){
 		$(this).focus();
 	});
 
  
});
