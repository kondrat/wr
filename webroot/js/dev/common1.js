jQuery(document).ready(function(){
		var com1 = {
			alertMessage: $('#flashMessage'),
			itemPages: $("#itemPages"),
			item: $("#item"),
			//statusItem: $("#status"),
			targetDay: $("#targetDay"),
			targetMonth: $("#targetMonth"),
			targetYear: $("#targetYear"),
			hourHour: $("#hourHour"),
			minuteMin: $("#minuteMin"),
			newItemForm: $("#newItemForm"),
			newItem: $("#newItem"),
			saveItemMain: $("#saveItemMain"),
			quickLogin: $("#quickLogin"),
			datePicker: $("#datepicker"),
			dataPickerTip: '',
			itemTypeControl: $("#itemTypeControl"),
			itemTypeList: $("#itemTypeList"),
			itT: '',
			itS: '',
			itTLenght: 0,
			itSLenght: 0
			
			
		};


		if( typeof(targetDay) !== "undefined") com1.dataPickerTip = targetDay;
		
		//getting item Task from view file.
		if( typeof(itT) !== "undefined"){
			com1.itT = itT;
			com1.itTLenght = itT.length;
		}
		//getting item Status from view file.
		if( typeof(itS) !== "undefined"){
			com1.itS = itS;
			com1.itSLenght = itS.length;
		}
		
		//flash alert message 	  

		if(com1.alertMessage.length) {
				var alerttimer = window.setTimeout(function () {
					com1.alertMessage.trigger('click');
				}, 4500);
				com1.alertMessage.animate({height: [com1.alertMessage.css("line-height") || '52', 'swing']}, 400).click(function () {
					window.clearTimeout(alerttimer);
					com1.alertMessage.animate({height: '0'}, 400);
					com1.alertMessage.css({'border':'none'});
				});
		}

		//New item controll

  	com1.newItem.click(function(e){
			if(e) e.stopPropagation();
			if(e) e.preventDefault();		
  		if( com1.newItemForm.is(":hidden") ) {
  			com1.newItemForm.show();
  			com1.item.focus();
  			$(this).addClass("newItemActive");
  		} else {
  			com1.newItemForm.hide();
  			$(this).removeClass("newItemActive");
  		}
  	});

  	
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
			var qlog = com1.quickLogin;

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
		
		com1.newItemForm.bind( "clickoutside", nItFormClOutSide );
		*/
			com1.datePicker.datepicker({ 
					
					dateFormat: 'dd.mm.yy',

					buttonImage: "../img/icons/cal.png",
					showOn: 'both', 
					buttonImageOnly: true,

					autoSize: true,
					showAnim: "",
					showButtonPanel: true
					
			});




    //card Ajax save;

    
    com1.saveItemMain.click(function(){
			var dateFromInput = com1.datePicker.val();
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
   		
   		
			var itemVal = com1.item.val();
			var itemTask = com1.itemTypeControl.find("span:first").data("type");
			
	    var itemObj = {
	    								"data[item]": itemVal,
	    								"data[prj]" : pObj.prjId,
	    								"data[target]" : epoch,
	    								"data[task]": itemTask

	    								//"data[hour]" : com1.hourHour.val(),
	    								//"data[min]" : com1.minuteMin.val()
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

						if( com1.itT !== '') {
							$.each(com1.itT, function(i,v){
								if( v.n == data.task ) { 

									itemTaskT = v.t;
									itemTaskCl = 'itemType itT'+v.n;
									itemId = data.id;

									return;
								}
							});	
						} else {
							itemTaskCl = com1.itemTypeControl.children("span:first").attr("class");
							itemTaskT = com1.itemTypeControl.children("span:first").text();						
						}	

						
						com1.itemPages.prepend(						
						  '<div id="item_'+itemId+'" class="item itS0 span-17">'+						  	
						    '<div class="span-2 last"><div class="targetItem">'+dateFromInput+'</div></div>'+						    
						    '<div class="span-14">'+
						    	'<div class="textItem">'+
						    		'<span class="'+itemTaskCl+'">'+itemTaskT+'</span>'+
										itemVal+
							    	'<span class="itemCrated"> 1 second ago</span>'+
						    	'</div>'+
						    '</div>'+					    
						    '<div class="span-1 last"><div class="statusItem">opend</div></div>'+
						  '</div>'												
						);
						com1.datePicker.val('No target');
						com1.item.val('').focus();
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
	com1.saveItemMain.next().click(function(){
		com1.item.val('');
		com1.datePicker.val(com1.dataPickerTip);
		com1.newItemForm.hide();
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


		
		com1.itemPages.delegate(".itemHeadLine","click",function(){
			var thisIt = $(this);


			var thisPar = thisIt.parent();
			var thisItem = thisIt.next();
			
			
			if( thisItem.length >= 1 ) {
				
				if(thisItem.is(":hidden")) {
					com1.itemPages.find("div.itemViewBlock").hide();
					com1.itemPages.find("div.item").removeClass("itemToEdit");
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
				com1.itemPages.find("div.itemViewBlock").hide();
				com1.itemPages.find("div.item").removeClass("itemToEdit");
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







		com1.itemPages.delegate(".itemEdit","click",function(){

			var thisItEd = $(this);
		
			var thisPar = thisItEd.parents(".itemViewBlock");
			
			thisPar.find("div.itemDataBlock").hide().end().find("div.itemEditBlock").show();
			

			
			var origText = '';
			origText = thisPar.parent().data("origText");
			
			thisPar.find("textarea").val(origText).elastic();			
		});


		
		com1.itemPages.delegate(".itemDel","click",function(){		
		
				var parId = $(this).parents(".item");
				
		    if (confirm('Are you sure to delete?')) {	
		    	var itId = parseInt( parId.attr("id").replace("item_", "") );
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


		com1.itemPages.delegate(".itemSubmit","click",function(){
					
					var parIt = $(this).parents(".item");
		    	var itId = parseInt( parIt.attr("id").replace("item_", "") );
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

		com1.itemPages.delegate(".itemCan","click",function(){
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
			
		if ( com1.quickLogin.is(":hidden") ) {
			$(this).addClass("logInAct");
				
			$("#overlay").show();
		} else {
			$("#overlay").hide();
			$(this).removeClass("logInAct");
		}
		com1.quickLogin.toggle();
		$("#UserUsername").focus();
		
		return false;
	});
 	
 	com1.quickLogin.bind('clickoutside', function(){
 		$("#logInNow").removeClass("logInAct");
 		$(this).hide();
 		$("#overlay").hide();
 		
 	});

	com1.itemPages.delegate(".statusItem","mouseenter",function(){
		$(this).addClass("activeStatusItem");
	}); 

	com1.itemPages.delegate(".statusItem","mouseleave",function(){
		$(this).removeClass("activeStatusItem");	
	});

	com1.itemPages.delegate(".statusItem","click",function(event){
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
		for ( var i=0; i <= com1.itSLenght; i++ ) {
			var curClass = "itS"+com1.itS[i].n;
			var newClass;
			if(thisIt.hasClass(curClass) ) {
				if( (1+i) < com1.itSLenght ){
					statusIt = 1+i;					
				} else {
					statusIt = 0;
				}
				newClass = "itS"+com1.itS[statusIt].n;
				thisIt.removeClass(curClass).addClass(newClass);
				statIt.text(com1.itS[statusIt].t);
				break;
			}	
				
		}
		
		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: {"data[status]":com1.itS[statusIt].n,"data[id]":itId},
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

	com1.itemPages.delegate(".itemType","click",function(event){

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
		for ( var i=0; i <= com1.itTLenght; i++ ) {
			var curClass = "itT"+com1.itT[i].n;
			var newClass;
			if(thisIt.hasClass(curClass) ) {
					//alert(curClass);
				if( (1+i) < com1.itTLenght ){
					statusIt = 1+i;					
				} else {
					statusIt = 0;
				}
				newClass = "itT"+com1.itT[statusIt].n;
				thisIt.removeClass(curClass).addClass(newClass).text(com1.itT[statusIt].t);
				break;
			}	
				
		}
	

		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: {"data[task]":com1.itT[statusIt].n,"data[id]":itId},
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
 
 
 
 	//switching task type on new item editor
	com1.itemTypeControl.click(function(){
		var thisType = $(this);		
		if( com1.itemTypeList.is(":hidden") ) {
			com1.itemTypeList.show();
			thisType.addClass("newItemActive");
		} else {
			com1.itemTypeList.hide();
			thisType.removeClass("newItemActive");
		}

	});

	com1.itemTypeList.delegate('span','click',function() {
		var thisP = $(this);
		var thisClass = thisP.attr("class");
		var thisText = thisP.text();
		var thisTaskId = parseInt(thisP.attr("id").replace("itT_",""));		
		com1.itemTypeControl.children("span:first").attr("class", thisClass).text(thisText).data("type",thisTaskId);
	});
 
	

	

  
});
