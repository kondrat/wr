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
			quickLogin: $("#quickLogin"),
			datePicker: $("#datepicker"),
			dataPickerTip: '',
			itemTypeControl: $("#itemTypeControl"),
			itemTypeList: $("#itemTypeList"),
			itT: '',
			itS: '',
			itSLenght: 0
			
		};

		if( typeof(targetDay) !== "undefined") com1.dataPickerTip = targetDay;
		
		//getting item Task from view file.
		if( typeof(itT) !== "undefined"){
			com1.itT = itT;
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

    
    $("#saveItemMain").click(function(){
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
	    								"data[Item][item]": itemVal,
	    								"data[Item][project_id]" : pObj.prjId,
	    								"data[Item][epoch]" : epoch,
	    								"data[Item][type]": itemTask

	    								//"data[Item][hour]" : com1.hourHour.val(),
	    								//"data[Item][min]" : com1.minuteMin.val()
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
								if( v.n == data.type ) { 
									itemTaskT = v.t;
									itemTaskCl = 'itemType itT'+data.type;
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
							    	'<span class="itemCrated"> | 1 second ago</span>'+
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
	$("#saveItemMain").next().click(function(){
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

	com1.itemPages.delegate(".statusItem","click",function(){
		
		var thisIt = $(this).parents(".item");
		//getting item id
		var itId = parseInt( thisIt.attr("id").replace("item_","") );
		
		
		var statusIt = 0;		
		for ( var i=0; i <= com1.itSLenght; i++ ) {
			var curClass = "itS"+i;
			var newClass;
			if(thisIt.hasClass(curClass) ) {
				if( (1+i) < com1.itSLenght ){
					statusIt = 1+i;					
				} else {
					statusIt = 0;
				}
				newClass = "itS"+statusIt;
				thisIt.removeClass(curClass).addClass(newClass).find(".statusItem").text(com1.itS[statusIt].t);
				break;
			}		
		}
		
		
		
		/*
		if ( thisIt.hasClass("itS0") ) {
			thisIt.removeClass("itS0").addClass("itS1").find(".statusItem").text("closed");
			statusIt = 1;
		} else if (thisIt.hasClass("itS1")) {
			thisIt.removeClass("itS1").addClass("itS2").find(".statusItem").text("hold");
			statusIt = 2;
		} else if(thisIt.hasClass("itS2")) {
			thisIt.removeClass("itS2").addClass("itS0").find(".statusItem").text("opend");
			statusIt = 0;
		}
		*/
		
		
		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/status",
        dataType: "json",
        data: {"data[itSt]":statusIt,"data[itId]":itId},
        success: function(data) {
					
        	if ( data.stat === 1 ) {        		

          	
          } else {
          	flash_message('Status not saved','fler');
          }
          
          
        },
        error: function(){
            alert('Problem with the server. Try again later.');
        }
      });
			
		},1000);		
		
		
		
	}); 
 
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
