jQuery(document).ready(function(){
		var com1 = {
			item: $("#item"),
			statusItem: $("#status"),
			targetDay: $("#targetDay"),
			targetMonth: $("#targetMonth"),
			targetYear: $("#targetYear"),
			hourHour: $("#hourHour"),
			minuteMin: $("#minuteMin")
		};

		  
  $("#newItem div div:first").click(function(){
    if ( $("#newItemForm").is(":visible") ) {
    	$("#newItemForm").fadeOut();
    }else{
    	$("#newItemForm").show();
    }
  });
 
    //card Ajax save;

    
    
    $("#saveItemMain").click(function(){
			
   	
	    var itemObj = {
	    								"data[Item][item]": com1.item.val(),
	    								"data[Item][status]" : com1.statusItem.val(),
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
  
});
