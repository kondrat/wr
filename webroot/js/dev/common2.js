jQuery(document).ready(function(){
	

    
    var $com2_curPrj = $("#curPrj");
    
    var $com2_prjPrjMainList = $("#prj-prjMainList");
    
    var $com2_projectEditor = $("#prj-projectEditor");
    var $com2_prjCancel = $(".prjCancel");
    var $com2_prjEdit = $(".prj-prjEdit");
    var $com2_prjDel = $(".prj-prjDel");
    var $com2_prjSave = $(".prjSave");
    var $com2_prjNewProject = $("#prj-newProject");
    var $com2_prjPrjTmpl = $("#prj-prjTmpl");
    var $com2_prjPrjItems = $("#prj-prjItems");
    var $com2_prjPrjNew = $("#prj-prjNew");
    var $com2_prjNewInput = $("#prj-prjNewInput");
    var $com2_prjNewPr = $("#prj-newPr");
    var $com2_prjNewPrSave = $("#prj-newPrSave");
    



    //selecting new current prj from the list and setting it current.
    $com2_projectEditor.delegate(".prj-prjList a", "click", function(){
		
        pObj.prjId = parseInt( $(this).attr("id").replace("prj_", "") );
        
        var prjCur = $(this);
        
        //$com2_prjPrjTmpl.tmpl(usrPrjData).prependTo($com2_prjPrjMainList);
        var prjCurData = prjCur.tmplItem().data;
       
        
        var prjName = $(this).text();
        var prjCurId = prjCur.data("prjid");

        $.ajax({
            dataType:"json",
            //type: "POST",
            url: path+"\/projects\/setPrj\/prj:"+prjCurId,
            
            success:function (data, textStatus) {
                if(data.stat == 1){
                    //changing the name of current project
                    $com2_prjPrjItems.text(prjName);
                    //closing project pad
                    $com2_prjNewProject.trigger("click");
                
                    
                    
//                    prjCur.parent().css({
//                        color:'red'
//                    }).prependTo("#prj-prjMainList");
                    prjCur.remove();
                    $com2_prjPrjTmpl.tmpl(prjCurData).prependTo($com2_prjPrjMainList);
                
                    
                    $com2_curPrj.addClass("actPrj");
                
                     
                    //@todo create common universalPginate after merging com1 and com2.
                    $("#itp-paginatorWrp").empty();
                    $("#itp-itemPages").universalPaginate({
                        itemTemplate: $("#itp-itemTmpl"),
                        nbItemsByPage: 12,
            
                        nbItemsByPageOptions: [6, 12, 18, 24, 30, 60, 100],
                        dataUrl: path+"\/items\/todo\/prj:"+prjCurId,
                        controlsPosition:"bottom",
                        universalPaginateClass: "itp-itemsPaginator",
                        headerElement: $("#itp-paginatorWrp"),
                        pageText:null,
                        itemsByPageText:null,
                        noDataText:"<div class='itp-noDataToDispl'>No data to display</div>"
                    //        onDataUpdate: function(data) {}
                    });
                    
                    if(data.tags){
                        //@todo replace $("#tgc-tags") with $com1_tgcTags after com1 com2 merging
                        $("#tgc-tags").data("tgcObj", data.tags);
                    }
                    
                } else {
                    alert('er');
                }

            },
            
            error:function(){
                alert('er');
            }
        });
    });




    //creating new Prj
    $com2_prjPrjNew.click(function(){
        if( $com2_prjNewInput.is(":hidden") ) {
            $com2_prjNewInput.show();
            $(this).addClass("prj-prjNewActive");
            $com2_prjNewPr.focus();
        }else{
            $com2_prjNewInput.hide();
            $(this).removeClass("prj-prjNewActive");
        }
        return false;
    });



    $com2_prjNewPrSave.click(function(){
		 	
        var prjObj = {
            "data[Prj][name]": $com2_prjNewPr.val()
        };
  							
        $.ajax({
            type: "POST",
            url: path+"/projects/savePrj",
            dataType: "json",
            data: prjObj,
            success: function(data) {
				
                if ( data.stat === 1 ) {        		

                    var justSavedPrjData = {"Project":data.prj};
                    $com2_prjPrjTmpl.tmpl(justSavedPrjData).prependTo($com2_prjPrjMainList);
                    
                    //@todo create common universalPginate after merging com1 and com2.
                    $("#itp-paginatorWrp").empty();
                    $("#itp-itemPages").universalPaginate({
                        itemTemplate: $("#itp-itemTmpl"),
                        nbItemsByPage: 12,

                        nbItemsByPageOptions: [6, 12, 18, 24, 30, 60, 100],
                        dataUrl: path+"\/items\/todo\/prj:"+data.prj.id,
                        controlsPosition:"bottom",
                        universalPaginateClass: "itp-itemsPaginator",
                        headerElement: $("#itp-paginatorWrp"),
                        pageText:null,
                        itemsByPageText:null,
                        noDataText:"<div class='itp-noDataToDispl'>No data to display</div>"
                    //  onDataUpdate: function(data) {}
                    });
                    
                    //@todo replace $("#tgc-tags") with $com1_tgcTags after com1 com2 merging
                    $("#tgc-tags").empty();
                    $("#tgc-tags").removeData("tgcObj");
                    
                    
                    prj-prjItems.text(data.prj.name);
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
        $com2_prjNewPr.val('');
        $com2_projectEditor.hide();
    });


    //opening projects pad	   
    
//    @todo : rework deleting of the initial prj list. when apply pagination or the prj
    $com2_prjNewProject.click(function(){
        
        var usrPrjData = $com2_projectEditor.data("uPrObj");
        
        if( typeof(usrPrjData) !== "undefined" ){
            $com2_projectEditor.find("#prj-prjMainList").empty();
            $com2_prjPrjTmpl.tmpl(usrPrjData).prependTo($com2_prjPrjMainList);
            $com2_projectEditor.removeData("uPrObj");
        }      
        
        
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
        $com2_prjNewProject.removeClass("newProjectActive");
    //return false;
    });


    $("#prj-projectEditor li").hover(function(){
        $(this).addClass("activePrj");
    },function(){
        $(this).removeClass("activePrj");
    }
    );


    //control of prj in the pad: editing, removing, saving, canceling	
	
    $com2_prjDel.click(function(){
		
        var parentLi = $(this).parents(".prj-prjList");
        parentLi.addClass("activePrjDel");
    		
        if (confirm('Are you sure to delete?')) {

            var prjId = parseInt( parentLi.find("a").attr("id").replace("prj_", "") );
            if( typeof(prjId) !== "undefined" && prjId !== "" ) {
    		
                $.ajax({
                    dataType:"json",
                    type: "POST",
                    data: {
                        "data[Prj][id]":prjId
                    },
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
        $(".prj-prjList").css({
            "visibility":""
        });
        var curPrjName = $(this).parents(".prj-prjList").find("a").text();
        $(this).parents(".prj-prjList").css({
            "visibility":"hidden"
        }).append(
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

            if( $(event.target).parents(".prj-prjControl").next().attr("class") !== "prjInlineEdit" ) {				
                $(".prj-prjList").css({
                    "visibility":""
                });
                $(this).hide();	
            }
			
        });


				
    });	
 
    $com2_prjCancel.live("click",function(){
        $(this).parents(".prj-prjList").css({
            "visibility":""
        });
        $(".prjInlineEdit").remove();
		
    //$(this).parents(".prj-prjList").find(
    });
 
    $com2_prjSave.live("click",function(){
        var thisClick = $(this);
        var thisParent = thisClick.parents(".prj-prjList");
        var prjId = parseInt( thisParent.find("a").attr("id").replace("prj_", "") );
		
        var newName = $("#prjEditInput").val();
		
			
        $.ajax({
            type: "POST",
            url: path+"/projects/savePrj",
            dataType: "json",
            data: {
                "data[Prj][name]":newName, 
                "data[Prj][id]":prjId
            },
            success: function(data) {
					
                if ( data.stat === 1 ) {
                    thisParent.css({
                        "visibility":""
                    }).find("a").text(data.prj.name);
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
