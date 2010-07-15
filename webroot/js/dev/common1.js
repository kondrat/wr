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
			dataPickerTip: ''
			
		};

		if( typeof(targetDay) !== "undefined") com1.dataPickerTip = targetDay;

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
			
	    var itemObj = {
	    								"data[Item][item]": itemVal,
	    								"data[Item][project_id]" : pObj.prjId,
	    								"data[Item][epoch]" : epoch

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
					
        	if ( data.stat === 1 ) {        		
						
						com1.itemPages.prepend(
						
						  '<div class="item span-17">'+						  	
						    '<div class="span-2"><div class="targetItem">'+dateFromInput+'</div></div>'+						    
						    '<div class="span-14">'+
						    	'<div class="textItem">'+
										itemVal+

							    	'<span class="itemCrated"> | 1 second ago</span>'+
						    	'</div>'+
						    '</div>'+					    
						    '<div class="span-1 last"><div class="statusItem opIt">opend</div></div>'+
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
				
		if ( thisIt.hasClass("opIt") ) {
			thisIt.removeClass("opIt").addClass("clIt").data({stat:1}).find(".statusItem").text("closed");
		} else if (thisIt.hasClass("clIt")) {
			thisIt.removeClass("clIt").addClass("hlIt").data({stat:2}).find(".statusItem").text("hold");
		} else if(thisIt.hasClass("hlIt")) {
			thisIt.removeClass("hlIt").addClass("opIt").data({stat:0}).find(".statusItem").text("opend");
		}
		
		clearTimeout(this.timeOut);
		this.timeOut = setTimeout(function(){
      $.ajax({
        type: "POST",
        url: path+"/items/status",
        dataType: "json",
        data: {"data[itSt]":thisIt.data("stat"),"data[itId]":itId},
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
			
		},3000);		
		
		
		
	}); 
  
});
