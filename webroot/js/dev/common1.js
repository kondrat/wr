jQuery(document).ready(function(){


			var $com1_alertMessage = $('#flashMessage');
			var $com1_itemPages = $("#itemPages");
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
			var $com1_iteTagsInput = $("#ite-tagsInput");
			var $com1_iteTagsCloud = $("#ite-tagsCloud");
			var $com1_iteTagIcon = $("#ite-tagIcon");
			var $com1_iteTagsToAddTmpl = $("#ite-tagsToAddTmpl");
			var $com1_iteTagsToAdd = $("#ite-tagsToAdd");


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
			var itemTags = $com1_iteTagsInput.val();
			
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

						
						$com1_itemPages.prepend(						
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
	  $(".item").live("mouseover mouseout", function(event){
				  if (event.type == 'mouseover') {
				    $(this).addClass("activeItem");
				  } else if (event.type == 'mouseout' ) {
				    $(this).removeClass("activeItem");
				  }	
		});


		
		$com1_itemPages.delegate(".itemHeadLine","click",function(){
			var thisIt = $(this);


			var thisPar = thisIt.parent();
			var thisItem = thisIt.next();
			
			
			if( thisItem.length >= 1 ) {
				
				if(thisItem.is(":hidden")) {
					$com1_itemPages.find("div.itemViewBlock").hide();
					$com1_itemPages.find("div.item").removeClass("itemToEdit");
					thisPar.addClass("itemToEdit");				
					thisItem.show();
				} else {				
					thisItem.hide();
					thisPar.removeClass("itemToEdit");
				}	
							
			}else{
				
				var origText = $.trim( thisIt.find("span.itemHead").text() );
				thisPar.data("origText",origText);
				//alert(origText);
				$com1_itemPages.find("div.itemViewBlock").hide();
				$com1_itemPages.find("div.item").removeClass("itemToEdit");
				thisPar.addClass("itemToEdit");
				thisIt.after(
			    '<div class="itemViewBlock hide">'+
			    	'<div class="itemDataBlock">'+
				    				    		
				    		'<ul class="itEdButtons ui-widget ui-helper-clearfix">'+
									'<li class="itemEdit ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-pencil"></span></li>'+
									'<li class="itemDel ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-trash"></span></li>'+
								'</ul>'+
				    	
				    	'<div class="itemEditText">'+
				    		'<span class="origText"></span>'+
				    	'</div>'+
			    	'</div>'+
			    	
						'<div class="itemEditBlock hide">'+
			    		'<ul class="itEdButtons ui-widget ui-helper-clearfix">'+
								'<li class="itemSubmit ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-check"></span></li>'+
								'<li class="itemCan ui-state-default ui-corner-all" style="cursor: pointer;"><span class="ui-icon ui-icon-cancel"></span></li>'+
							'</ul>'+			
							'<div style="padding:5px;margin-top:20px;"><textarea class="itemTextArea" name="data[itemText]" style="height: 10px;"></textarea><div>'+
							'<div>more</div>'+
						'</div>'+			    	
			    '</div>'	
			   ).next().show().find("span.origText").text(origText);		
			}
				

		});







		$com1_itemPages.delegate(".itemEdit","click",function(){

			var thisItEd = $(this);
		
			var thisPar = thisItEd.parents(".itemViewBlock");
			
			thisPar.find("div.itemDataBlock").hide().end().find("div.itemEditBlock").show();
			

			
			var origText = '';
			origText = thisPar.parent().data("origText");
			
			thisPar.find("textarea").val(origText).elastic();			
		});


		
		$com1_itemPages.delegate(".itemDel","click",function(){		
		
				var parId = $(this).parents(".item");
				
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


		$com1_itemPages.delegate(".itemSubmit","click",function(){
					
					var parIt = $(this).parents(".item");
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

		$com1_itemPages.delegate(".itemCan","click",function(){
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

	$com1_itemPages.delegate(".statusItem","mouseenter",function(){
		$(this).addClass("activeStatusItem");
	}); 

	$com1_itemPages.delegate(".statusItem","mouseleave",function(){
		$(this).removeClass("activeStatusItem");	
	});

	$com1_itemPages.delegate(".statusItem","click",function(event){
		//event.stopPropagation();

		var thisIt = $(this).parents(".item");
		//getting item id
		var itId = parseInt( thisIt.attr("id").replace("item_","") );
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

	$com1_itemPages.delegate(".itemType","click",function(event){

		var thisIt = $(this);
		var thisPar = thisIt.parents(".item");
		//getting item id
		var itId = parseInt( thisPar.attr("id").replace("item_","") );
		
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

	$com1_itemPages.delegate(".targetItem","click",function(event){

	  event.preventDefault();
		
		//$(".targetItem").datepicker('destroy');

		var thisIt = $(this);
		var thisPar = thisIt.parents(".item");
		var itId = parseInt( thisPar.attr("id").replace("item_","") );
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
	$com1_itemPages.delegate(".datefield","click",function(event){
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
		var thisTaskId = parseInt(thisP.attr("id").replace("itT_",""));		
		$com1_itemTypeControl.children("span:first").attr("class", thisClass).text(thisText).data("type",thisTaskId);
	});
 
	


	$com1_iteTagsInput.focus(function(){
		$com1_iteTagsCloud.toggle();
	});
	$com1_iteTagIcon.click(function(){
		$com1_iteTagsCloud.toggle();
	});	

	$(".ite-tagName").click(function(){
		var thisName = $(this).text();
		$com1_iteTagsToAddTmpl.tmpl( {"tag":thisName } ).appendTo($com1_iteTagsToAdd);
	});


	$com1_iteTagsCloud.tipsy({gravity: 'n',delayIn: 1000});
	$com1_iteTagIcon.find("img").tipsy({gravity: 's',delayIn: 1000,offset: 5});
	$com1_newItem.tipsy({gravity: 's',delayIn: 1000});
  
});
