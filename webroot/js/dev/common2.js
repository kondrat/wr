jQuery(document).ready(function(){
	

			var $com2_newPrj = $("#newPr");
			var $com2_curPrj = $("#curPrj");
			var $com2_allPrj = $("#allPrj");
			var $com2_projectEditor = $("#projectEditor");
			var $com2_prjCancel = $(".prjCancel");
			var $com2_prjEdit = $(".prjEdit");
			var $com2_prjDel = $(".prjDel");
			var $com2_prjSave = $(".prjSave");;





	//switching projects all - current

	$com2_allPrj.bind("click", function (event) {
		
		$com2_curPrj.removeClass("actPrj");
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

	
	$com2_curPrj.bind("click", function (event) {
				$com2_allPrj.removeClass("actPrj");
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



	//selecting new current prj from the list and setting it current.

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
					$com2_allPrj.removeClass("actPrj");
					$com2_curPrj.addClass("actPrj");
				},
				url: path+"\/items\/todo\/prj:"+pObj.prjId+"\/page:1",
				error:function(){
					alert('er');
				}
		});
	});




	//creating new Prj
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
    								"data[Prj][name]": $com2_newPrj.val()
    							};
  							
    $.ajax({
      type: "POST",
      url: path+"/projects/savePrj",
      dataType: "json",
      data: prjObj,
      success: function(data) {
				
      	if ( data.stat === 1 ) {        		
					pObj.prjId = data.prj.id;
					$com2_curPrj.text(data.prj.name);
        	flash_message('saved','flok');
        	
        } else {
        	flash_message('not saved','fler');
        }
        
        
      },
      error: function(){
          //$('.tempTest').html('Problem with the server. Try again later.');
          alert('Problem with the server. Try again later.');
      }
    });
  }); 


	$("#newPrCancel").click(function(){
		$com2_newPrj.val('');
		$com2_projectEditor.hide();
	});


	//opening projects pad	
	
	$("#newProject").click(function(){
		if( $com2_projectEditor.is(":hidden") ){
			$com2_projectEditor.show();
			$(this).addClass("newProjectActive");
		} else {
			$com2_projectEditor.hide();
			$(this).removeClass("newProjectActive");
		}
		//$("#overlay").show();
		return false;
	});	
	
	
	$com2_projectEditor.bind("clickoutside",function(){
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


	//control of prj in the pad: editing, removing, saving, canceling	
	
	$com2_prjDel.click(function(){
		
    var parentLi = $(this).parents(".prjList");
    parentLi.addClass("activePrjDel");
    		
    if (confirm('Are you sure to delete?')) {

    	var prjId = parseInt( parentLi.find("a").attr("id").replace("prj_", "") );
    	if( typeof(prjId) !== "undefined" && prjId !== "" ) {
    		
					$.ajax({
							dataType:"json",
							type: "POST",
							data: {"data[Prj][id]":prjId},
							success:function (data, textStatus) {
								if( data.stat === 1) {
									parentLi.fadeOut();							
								} else {
									flash_message("Couldn't be deleted", "fler" );
									parentLi.removeClass("activePrjDel");
								}
							},
							url: path+"\/projects\/delPrj",
							error:function(){
								alert('er');
							}
					});  
					  		
    	}
    } else {
    	parentLi.removeClass("activePrjDel");
    }
	});
	
	
	$com2_prjEdit.click(function(){
		
		$(".prjInlineEdit").remove();
		$(".prjList").css({"visibility":""});
		var curPrjName = $(this).parents(".prjList").find("a").text();
		$(this).parents(".prjList").css({"visibility":"hidden"}).append(
			"<div class='prjInlineEdit' style='position:absolute;top:2px;left:0;visibility:visible;'>"+
				"<input style='width:117px;margin:0;padding:0;' type='text' id='prjEditInput' name='data[editPrj]' />"+
			
				"<ul class='prjSaveControl ui-widget ui-helper-clearfix'>"+
							"<li class='prjSave ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li>"+
							"<li class='prjCancel ui-state-default ui-corner-all'><span class='ui-icon ui-icon-cancel'></span></li>"+
				"</ul>"+
			"</div>"
		);
		$(".prjInlineEdit input").focus().val(curPrjName);
		
		
		
		$(".prjInlineEdit").bind("clickoutside",function(event){

			if( $(event.target).parents(".prjControl").next().attr("class") !== "prjInlineEdit" ) {				
				$(".prjList").css({"visibility":""});
				$(this).hide();	
			}
			
		});


				
	});	
 
	$com2_prjCancel.live("click",function(){
		$(this).parents(".prjList").css({"visibility":""});
		$(".prjInlineEdit").remove();
		
		//$(this).parents(".prjList").find(
	});
 
	$com2_prjSave.live("click",function(){
		var thisClick = $(this);
		var thisParent = thisClick.parents(".prjList");
		var prjId = parseInt( thisParent.find("a").attr("id").replace("prj_", "") );
		
		var newName = $("#prjEditInput").val();
		
			
	    $.ajax({
	      type: "POST",
	      url: path+"/projects/savePrj",
	      dataType: "json",
	      data: {"data[Prj][name]":newName, "data[Prj][id]":prjId},
	      success: function(data) {
					
	      	if ( data.stat === 1 ) {
	      		thisParent.css({"visibility":""}).find("a").text(data.prj.name);
	      		thisParent.find(".prjInlineEdit").remove();    		
						
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
  
});
