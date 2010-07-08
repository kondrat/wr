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
			curPrj: $("#curPrj"),
			newItemForm: $("#newItemForm"),
			newItem: $("#newItem"),
			quickLogin: $("#quickLogin"),
			datePicker: $("#datepicker"),
			dataPickerTip: ''
			
		};
		//alert(com1.dataPickerTip);
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
					showAnim: ""
					
			});




    //card Ajax save;

    
    $("#saveItemMain").click(function(){
    	
			//alert(com1.datePicker.val());
   		var parsedDate = $.datepicker.parseDate('dd.mm.yy', com1.datePicker.val() );
			
			
   		var tosend = new Date(parsedDate);
   		alert(tosend.getTime()+' '+(tosend.getMonth()+1)+' '+tosend.getFullYear()+' ');
			
	    var itemObj = {
	    								//"data[Item][item]": com1.item.val(),
	    								//"data[Item][project_id]" : com1.curPrjId,
	    								"data[Item][epoch]" : parseInt(tosend.getTime()/1000)
	    								/*
	    								"data[Item][day]" : tosend.getDate(),
	    								"data[Item][month]" : tosend.getMonth()+1,
	    								"data[Item][year]" : tosend.getFullYear()
											*/
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

          	flash_message('saved','flok');
          	
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

	$("#newProject").click(function(){
		if( $("#projectEditor").is(":hidden") ){
			$("#projectEditor").show();
			$(this).addClass("newProjectActive");
		} else {
			$("#projectEditor").hide();
			$(this).removeClass("newProjectActive");
		}
		//$("#overlay").show();
		return false;
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
	
	$("#projectEditor").bind("clickoutside",function(){
		$(this).hide();
		$("#newProject").removeClass("newProjectActive");
		//return false;
	});

	$("#projectEditor li").hover(function(){
		$(this).addClass("activePrj");
	},function(){
		$(this).removeClass("activePrj");
	}
	);
	$(".prjDel").click(function(){
		confirm('Are you sure?');
	});

	$("#prjNew").click(function(){
		if( $("#prjNewInput").is(":hidden") ) {
			$("#prjNewInput").show();
			$(this).addClass("prjNewActive");
			$("#newPr").focus();
		}else{
			$("#prjNewInput").hide();
			$(this).removeClass("prjNewActive");
		}
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
		$("#projectEditor").hide();
	});



	$("#allPrj").bind("click", function (event) {
		
		$("#curPrj").removeClass("actPrj");
		$(this).addClass("actPrj");
		
		$.ajax({
			dataType:"html",
			success:function (data, textStatus) {
			
				$("#itemPages").html(data);
				},
				 url: path+"\/items\/todo\/prj:all\/page:1"
		});
		return false;
	});



	
	$("#curPrj").bind("click", function (event) {
				$("#allPrj").removeClass("actPrj");
				$(this).addClass("actPrj");
		$.ajax({
				dataType:"html",
				success:function (data, textStatus) {

				$("#itemPages").html(data);
				},
				url: path+"\/items\/todo\/prj:"+pObj.prjId+"\/page:1"
		});
		return false;
	});



	$(".prjList a").bind("click", function(){
		
		pObj.prjId = parseInt( $(this).attr("id").replace("prj_", "") );
		var prjCur = $(this);
		var prjName = $(this).text();
		$.ajax({
				dataType:"html",
				//type: "POST",
				data: {"cur":"1"},
				success:function (data, textStatus) {
					$("#prjItems").text(prjName);
					$("#itemPages").html(data);
					$("#newProject").trigger("click");
					prjCur.parent().prependTo("#prjMainList");
					$("#allPrj").removeClass("actPrj");
					$("#curPrj").addClass("actPrj");
				},
				url: path+"\/items\/todo\/prj:"+pObj.prjId+"\/page:1",
				error:function(){
					alert('er');
				}
		});
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
	 
 
  
});
