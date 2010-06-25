jQuery(document).ready(function(){
		var com1 = {
			alertMessage: $('#flashMessage'),
			item: $("#item"),
			statusItem: $("#status"),
			targetDay: $("#targetDay"),
			targetMonth: $("#targetMonth"),
			targetYear: $("#targetYear"),
			hourHour: $("#hourHour"),
			minuteMin: $("#minuteMin"),
			newPrj: $("#newPr"),
			curPrjId: 0,
			curPrj: $("#curPrj")
		};



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

/*		
		$("#newItemForm").bind( "clickoutside", function(event){
			
			if(!$(this).is(":hidden") ) {
				$(this).hide();
			}
		});
*/
	$("body").click(function(){
		$(".opendW").hide().removeClass(".opendW");		
	});
	var text = '';
		  
  $("#newItem div a:first").click(function(){
  	/*
    			$("#newItemForm").bind( "clickoutside", function(event){		
    				var clicked_elem = $(event.target);
    				
					    var elem = $(this);
					      target = $(event.target);
					      
					      // Update the text to reference the event.target element.
					      text = 'Clicked: ' + target[0].tagName.toLowerCase()
					        + ( target.attr('id') ? '#' + target.attr('id')
					          : target.attr('class') ? '.' + target.attr('class').replace( / /g, '.' )
					          : ' ' );
								//alert(text); 
								$("#newItemForm").hide();
						});
   						 	
  		*/
  	
  	var mm = $(this);
  	
    if ( $("#newItemForm").is(":visible") ) {
    	/*
    	$("#newItemForm").unbind( "clickoutside");
    	*/
    	$("#newItemForm").fadeOut( function(){});
    	
    	
    }else{
    	/*
    	$("#newItemForm").bind( "clickoutside", function(event){
					      target = $(event.target);
					      
					      // Update the text to reference the event.target element.
					     
					      text = 'Clicked: ' + target[0].tagName.toLowerCase()
					        + ( target.attr('id') ? '#' + target.attr('id')
					          : target.attr('class') ? '.' + target.attr('class').replace( / /g, '.' )
					          : ' ' );
					         
					      if ( target.attr('id') !== mm.attr('id') ) {
									//alert(target.attr('id'));
									$("#newItemForm").hide();
								} 

					
    	//$("#newItemForm").hide();
    	});
    	*/
    	$("#newItemForm").show().addClass("opendW");

    }
  });
 
    //card Ajax save;

    
    
    $("#saveItemMain").click(function(){
			
   	
	    var itemObj = {
	    								"data[Item][item]": com1.item.val(),
	    								"data[Item][status]" : com1.statusItem.val(),
	    								"data[Item][project_id]" : com1.curPrjId,
	    								"data[Item][day]" : com1.targetDay.val(),
	    								"data[Item][month]" : com1.targetMonth.val(),
	    								"data[Item][year]" : com1.targetYear.val(),
	    								"data[Item][hour]" : com1.hourHour.val(),
	    								"data[Item][min]" : com1.minuteMin.val()
	    							};
    							
      $.ajax({
        type: "POST",
        url: path+"/items/saveItem",
        dataType: "json",
        data: itemObj,
        success: function(data) {
        	
					userReg = 1;
					
        	if ( data.stat === 1 ) {        		

          	flash_message('saved','flok');
          	
          } else {
          	flash_message('not saved','fler');
          }
          
          
        },
        error: function(){
            $('.tempTest').html('Problem with the server. Try again later.');
            alert('Problem with the server. Try again later.');
        }
      });
    }); 
 



	//more controls
	$("#saveItemMain").next().click(function(){
		com1.item.val('');
		com1.statusItem.val(0)
		$("#newItemForm").fadeOut();
	});
	$("#timeToggle").click(function(){
		$(this).next().toggle();
		
	}); 

	$("#newProject").click(function(){
		$("#projectEditor").toggle('fast');
		return false;
	});


  $("#newPrSave").click(function(){
		
 	
    var prjObj = {
    								"data[Prj][name]": com1.newPrj.val()
    							};
  							
    $.ajax({
      type: "POST",
      url: path+"/projects/savePrj",
      dataType: "json",
      data: prjObj,
      success: function(data) {
				
      	if ( data.stat === 1 ) {        		
					com1.curPrjId = data.prj.id;
					com1.curPrj.text(data.prj.name);
        	flash_message('saved','flok');
        	
        } else {
        	flash_message('not saved','fler');
        }
        
        
      },
      error: function(){
          $('.tempTest').html('Problem with the server. Try again later.');
          alert('Problem with the server. Try again later.');
      }
    });
  }); 


	$("#newPrCancel").click(function(){
		com1.newPrj.val('');
		$("#projectEditor").toggle('fast');
	});



	$("#allItems").bind("click", function (event) {
		
		$("#curPrj").removeClass("activePrj");
		$("#allPrj").addClass("activePrj");
		
		$.ajax({
			dataType:"html",
			success:function (data, textStatus) {
			
				$("#itemPages").html(data);
				},
				 url: path+"\/items\/todo\/page:1"
		});
		return false;
	});
	
	$("#prjItems").bind("click", function (event) {
				$("#allPrj").removeClass("activePrj");
				$("#curPrj").addClass("activePrj");
		$.ajax({
			dataType:"html",
			success:function (data, textStatus) {

				$("#itemPages").html(data);
				},
				 url: path+"\/items\/todo\/prj:"+pObj.prjId+"\/page:1"
		});
		return false;
	});



  
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
	).click(function(){
		if ( $("#quickLogin").is(":hidden") ) {
			$(this).addClass("logInAct");
		} else {
			$(this).removeClass("logInAct");
		}
		$("#quickLogin").toggle();
		
		return false;
	});
 	
 
	 
 
  
});
