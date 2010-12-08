jQuery(document).ready(function(){

    var $com1_contentWrapper = $(".contentWrapper");
    var $com1_alertMessage = $('#flashMessage');
    var $com1_itpItemPages = $("#itp-itemPages");
//  just to check this var
    var $com1_item = $("#item");
    var $com1_itpItemTmpl = $("#itp-itemTmpl");

			
  //item editor
    var $com1_iteItemEditorWrp = $("#ite-itemEditorWrp");
//  var $com1_iteNewItemBtnWrp = $("#ite-newItemBtnWrp");
    var $com1_iteNewItemBtn = $("#ite-newItemBtn");
    var $com1_iteItemEditorTmpl = $("#ite-itemEditorTmpl");

    var $com1_quickLogin = $("#quickLogin");
			
    var $com1_dataPickerTip = '';
//    defaults for all datapicers
    $.datepicker.setDefaults(
        {					
            dateFormat: 'dd.mm.yy',
            buttonImage: "../img/icons/cal_deb887.png",
            showOn: 'both',
            buttonImageOnly: true,
            autoSize: true,
            showAnim: "",
            showButtonPanel: true					
        }
    );
 
			
  //tags
			
  //tags in editor

  var $com1_iteTagsAddedTmpl = $("#ite-tagsAddedTmpl");
			
  //tags in tagCloud
  var $com1_tgcTagCloudWrp = $("#tgc-tagCloudWrp");
  $com1_tgcTagCloudWrp.data("curEditTagLis",'');
  var $com1_tgcTagCloudClose = $("#tgc-tagCloudClose");
  var $com1_tgcTagsInput = $("#tgc-tagsInput");
  var $com1_tgcTags = $("#tgc-tags");
  var $com1_tgcTagsCloudAddTmpl = $("#tgc-tagsCloudAddTmpl");
  var $com1_tgcTagsAdd = $("#tgc-tagsAdd");
		
//  getting item Types from view file.
    var $com1_itT = '';
    var $com1_itTLenght = 0;
    if( typeof(itT) !== "undefined" && itT != null){
        $com1_itT = itT;
        $com1_itTLenght = itT.length;
    }
//  getting item Status from view file.
    var $com1_itS = '';
    var $com1_itSLenght = 0;
    if( typeof(itS) !== "undefined" && itS != null){
        $com1_itS = itS;
        $com1_itSLenght = itS.length;
    }
	


    //   new item editor initial randering
    var f_com1_itemEditor = function(){
        var itemObj = {
            test:"test",
            Item:{
                    id:"000",
                    typeClass:"itT0",
                    typeText:"ToDo"
                },
            Tag:[]
        };
        var $freshEditor = $com1_iteItemEditorTmpl.tmpl(itemObj).appendTo($com1_iteItemEditorWrp);
//    	appling ui datepicker to the new generated editor		
        $freshEditor.find("#dp-000").datepicker();
    };
    if($com1_iteItemEditorWrp.length > 0){
        f_com1_itemEditor();
    }

    var f_com1_itemEditorHide = function(){
        $com1_iteItemEditorWrp.hide();
        $com1_iteNewItemBtn.removeClass("ite-newItemBtnActive");      
    }

// New item controll
    var f_com1_iteNewItemBtnClick = function(e){
    
        var thisClBut = $(this);
			
//        if(e) e.stopPropagation();
//        if(e) e.preventDefault();
   		
        
        $com1_itpItemPages.find(".itp-itemHead").show().removeClass("itp-itemHeadActive").next().remove();
    
				
        if( $com1_iteItemEditorWrp.is(":hidden") ) {
            $com1_iteItemEditorWrp.show();
            //      @todo to change
            $com1_item.focus();
            $com1_iteNewItemBtn.addClass("ite-newItemBtnActive");
      
        } else {
            f_com1_itemEditorHide();
        }
 
    };

//    new item editor visability control
    $com1_iteNewItemBtn.click(f_com1_iteNewItemBtnClick);


//    new item save   
    $com1_iteItemEditorWrp.delegate(".ite-saveItemMain","click",function(){
      
        var $thisEditorSave = $(this);
        var $thisEditorSaveParent = $thisEditorSave.parents(".ite-itemEditor");
        
        var dateFromInput = $thisEditorSaveParent.find(".datepicker").val();
        var $thisTagsAdded = $thisEditorSaveParent.find(".ite-tagsAdded");
    
        var epoch = '';
        try{
            var parsedDate = $.datepicker.parseDate('dd.mm.yy', dateFromInput );
        }
        catch(e){
            parsedDate = null;
        }
			
        if(parsedDate) {
            var tosend = new Date(parsedDate);
            epoch =  parseInt(tosend.getTime()/1000);
        } else {  			
            dateFromInput = '';
        }
    
   		
   		
        var itemVal = $thisEditorSaveParent.find(".ite-newItemText").val();
        
        var itemTask = $thisEditorSaveParent.find(".ite-itemTypeCtrl").find("span:first").data("type");

//        tags creation
        var itemTags = new Array();

        $thisTagsAdded.children().each(function(){
            var thisTag = $(this);
            itemTags.push(thisTag.text());
        });




        var itemObj = {
            "data[item]": itemVal,
            "data[prj]" : pObj.prjId,
            "data[target]" : epoch,
            "data[task]": itemTask,
            "data[tags]": itemTags
         
        };
//    	console.log(itemObj);			
        $.ajax({
            type: "POST",
            url: path+"/items/saveItem",
            dataType: "json",
            data: itemObj,
            success: function(data) {
					
//                var itemTaskT = 'todo';
//                var itemTaskCl = 'itemType itT0';
//                var itemId = 0;
//
//					
//                if ( data.stat === 1 ) {
//
//                    if( $com1_itT !== '') {
//                        $.each($com1_itT, function(i,v){
//                            if( v.n == data.task ) {
//
//                                itemTaskT = v.t;
//                                itemTaskCl = 'itemType itT'+v.n;
//                                itemId = data.id;
//
//                                return;
//                            }
//                        });
//                    } else {
//                        itemTaskCl = $com1_iteItemEditorWrp.find(".ite-itemTypeList").children("span:first").attr("class");
//                        itemTaskT = $com1_iteItemEditorWrp.find(".ite-itemTypeList").children("span:first").text();
//                    }

//                    var tagObj = new Object();
//                    $.each(itemTags,function(i,v){
//                        tagObj[i] = {
//                            'name':v,
//                            'Tagged':{
//                                'id':'0002'
//                            }
//                        };
//                    });

//                    var newItemObj =
//                    {
//                        'Item':{
//                            'id':itemId,
//                            'target':dateFromInput,
//                            'typeClass':itemTaskCl,
//                            'typeText':itemTaskT,
//                            'statusClass':'itS0',
//                            'statusText':'open',
//                            'item':itemVal,
//                            'created':data.jn
//                        },
//                        'Tag':tagObj
//                    };
                    console.log(data.res);
                    $com1_itpItemTmpl.tmpl(data.res).prependTo($com1_itpItemPages);

//                        @todo : treat the editor after successful save 
//                    $com1_datePicker.val('No target');
//                    $com1_item.val('').focus();
                
          	
                } else {
                    flash_message('not saved','fler');
                }
          
          
            },
            error: function(){
                alert('Problem with the server. Try again later.');
            }
        });
    }); 




// switching task type on new item editor. 1: open taskList
    var f_com1_itemTypeCtrl = function(){
         var $thisTypeCtrl = $(this);
        var $thisTypeList = $thisTypeCtrl.find(".ite-itemTypeList");
        if( $thisTypeList.is(":hidden") ) {
            $thisTypeList.show();           
        } else {
            $thisTypeList.hide();           
        }       
    };
    $com1_iteItemEditorWrp.delegate(".ite-itemTypeCtrl","click",f_com1_itemTypeCtrl);
    $com1_itpItemPages.delegate(".ite-itemTypeCtrl","click",f_com1_itemTypeCtrl);


//    2: close the list and take new task
    var f_com1_itemTypeChange = function(){
        var $thisType = $(this);
        var $thisTypeCtrl = $(this).parents(".ite-itemTypeCtrl");
        var thisTypeClass = $thisType.attr("class");
        var thisText = $thisType.text();
        var thisTaskId = $thisType.attr("id").replace("itT_","");
        $thisTypeCtrl.children("span").attr("class", thisTypeClass).text(thisText).data("type",thisTaskId);       
    };
    $com1_iteItemEditorWrp.delegate('.ite-itemTypeList span','click',f_com1_itemTypeChange);
    $com1_itpItemPages.delegate(".ite-itemTypeList span","click",f_com1_itemTypeChange);
	

 


    //more decorations
    $(".itp-item").live("mouseover mouseout", function(event){
        if (event.type == 'mouseover') {
            $(this).addClass("itp-activeItem");
        } else if (event.type == 'mouseout' ) {
            $(this).removeClass("itp-activeItem");
        }
    });


    var selectedItem = null;		
    $com1_itpItemPages.delegate(".itp-itemHead","click",function(){
			
//        var $thisItemHead = $(this);
//        var $thisParent = $thisItemHead.parent();
 
         // preparing the editor. cleaning up all prev and rendering new one

        //    hiding new item editor
        f_com1_itemEditorHide();
        
        if(selectedItem){
//            $(selectedItem.nodes).css( "backgroundColor", "" );
                selectedItem.tmpl = $("#itp-itemTmpl").template();
                selectedItem.update();
        }
        
        selectedItem = $.tmplItem(this);

        selectedItem.tmpl = $("#ite-itemEditorTmpl").template();//$com1_iteItemEditorTmpl;
        selectedItem.update();
        $(selectedItem.nodes).find("input[id^='dp-']").datepicker();    
 
    });

// cancel save item
    $com1_itpItemPages.delegate( ".ite-cancelSaveItem","click",function(){
        
        selectedItem.tmpl = $("#itp-itemTmpl").template();
        selectedItem.update();
        selectedItem = null;
        
//        $com1_item.val('');
//        $com1_datePicker.val($com1_dataPickerTip);
//        $com1_iteItemEditorWrp.hide();
    });
    

    $com1_iteItemEditorWrp.delegate( ".ite-cancelSaveItem","click",function(){
        var itemObj = $.tmplItem(this);
        itemObj.update();
        $(itemObj.nodes).find("input[id^='dp-']").datepicker();      
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

//@todo : to replace with pop-up
$com1_itpItemPages.delegate(".statusItem","click",function(event){
  //event.stopPropagation();

  var thisIt = $(this).parents(".itp-item");
  //getting item id
  var itId = thisIt.attr("id").replace("item_","");
  //finding statusItem class
  var statIt = thisIt.find(".statusItem");

  if( typeof(this.i) === "undefined" ){
    this.i = 0;
    statIt.data({
      'origClass':thisIt.attr("class"),
      'origText':statIt.text()
      });
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
      data: {
        "data[status]":$com1_itS[statusIt].n,
        "data[id]":itId
      },
      success: function(data) {
					
        if ( data.stat === 1 ) {

          statIt.data({
            'origClass':thisIt.attr("class"),
            'origText':statIt.text()
            });
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
 

// @todo to replace with pop-up
    $com1_itpItemPages.delegate(".itp-itemType","click",function(event){

        var thisIt = $(this);
        var thisPar = thisIt.parents(".itp-item");
        //getting item id
        var itId = thisPar.attr("id").replace("item_","");
		
        //creating this data with first click for blackup in case of falure.
        if( typeof(this.i) === "undefined" ){
            this.i = 0;
            thisIt.data({
                'origClass':thisIt.attr("class"),
                'origText':thisIt.text()
            });
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
      data: {
        "data[task]":$com1_itT[statusIt].n,
        "data[id]":itId
      },
      success: function(data) {
					
        if ( data.stat === 1 ) {

          thisIt.data({
            'origClass':thisIt.attr("class"),
            'origText':thisIt.text()
            });
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



//to del. we now have common editor
$com1_itpItemPages.delegate(".itp-targetItem","click",function(event){

  event.preventDefault();
		
  //$(".itp-targetItem").datepicker('destroy');

  var thisIt = $(this);
  var thisPar = thisIt.parents(".itp-item");
  //to clean up data id
  var itId = thisPar.attr("id").replace("item_","");
  var prevVal = thisIt.text();
  thisIt.prepend('<input type="text" value="Target day"  name="data[datepicker]" class="datefield" size="10">').children().val(prevVal);

  thisIt.children().css({
    "color":"red"
  }).datepicker(

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

 
//-----------------------------------------------------------------------------------------

	
//        control of the tags cloud: toggling and iterating throught the tags
    var f_com1_tagsCloudCtrl = function(){
        var $thisAddIcon = $(this);
		
        //memorizing the object of the current items tags so we could append more tags to it.
       
        var $thisCurEditTagList = $thisAddIcon.next();
        $com1_tgcTagCloudWrp.data("curEditTagLis",$thisCurEditTagList);
        
		
        //toggel tag cloud window
        $com1_tgcTagCloudWrp.toggle();
        //position tag cloud window by the tag cloud icon. (may be item itself)
        var tgcTagCloudIconPos = $thisAddIcon.offset();
        var contentWrapperPos = $com1_contentWrapper.offset();
        var setTop = tgcTagCloudIconPos.top - contentWrapperPos.top + 32;
        var setLeft = tgcTagCloudIconPos.left - contentWrapperPos.left - 150;
        $com1_tgcTagCloudWrp.css({
            "left":setLeft,
            "top":setTop
        });


        //getting tags from the dom if it's first time, or just toggling
        if(typeof($com1_tgcTags.data("tgcObj")) !== "undefined"){
            $com1_tgcTagsCloudAddTmpl.tmpl( $com1_tgcTags.data("tgcObj") ).appendTo($com1_tgcTags);
            $com1_tgcTags.removeData("tgcObj");
        }
		
		
        //currnt tags object for iteration
        var $tagsItem = $thisCurEditTagList.find(".ite-tagAdded");
        //iterating throught tags cloud and item tags to identify already choosen tags and add checked class to them.
        $tagsItem.tagCloudIteration($com1_tgcTags);  
    };
// iteration through each item's tag
    $.fn.tagCloudIteration = function( tagCloudObj ){
		 
        if(!tagCloudObj){
            return false;
        }
		
        var $tagsFromCloud = tagCloudObj.find(".tgc-tag").removeClass("tgc-tagChecked").addClass("tgc-tagNameCl");
//        @todo understend why output 2 times
	console.log(this.length);	
        return this.each(function(){
            var $tag = $(this);
            var thisTagName = $tag.text();
            $tagsFromCloud.each(function(){
                var $thisTagFromCloud = $(this);
                if($thisTagFromCloud.data("tagn") == thisTagName){
                    $thisTagFromCloud.removeClass("tgc-tagNameCl").addClass("tgc-tagChecked");
                }
            });
        });

    };

    $com1_iteItemEditorWrp.delegate( ".ite-tagIcon","click", f_com1_tagsCloudCtrl);	
    $com1_itpItemPages.delegate(".ite-tagIcon","click",f_com1_tagsCloudCtrl);


	
    //clicking on tag from cloud to append to tagEditor
    $com1_tgcTags.delegate(".tgc-tagNameCl","click",function(){
        var $thisTag = $(this);
        var thisName = $thisTag.data("tagn");
        $com1_iteTagsAddedTmpl.tmpl( {
            "name":thisName
        } ).appendTo($com1_tgcTagCloudWrp.data("curEditTagLis")).data({
            tagid: $thisTag.data("tagid")
        });
        $thisTag.removeClass("tgc-tagNameCl").addClass("tgc-tagChecked");
    });	
	
	
	
//    remove tag from item tag list
    var f_com1_tagToRemoveFromItem = function(){
 
        var $thisTag = $(this);
        var $thisTagParent = $thisTag.parent();
        var thisTagItemId = $thisTag.data("itemt");
    
        $thisTag.fadeOut(500, function(){
            $thisTag.remove();
    	
            $thisTagParent.find(".ite-tagAdded").tagCloudIteration($com1_tgcTags);
        });
	
        if(thisTagItemId){
         //@todo ajax tag deletion to define here;
        }       
    }
    
    $com1_itpItemPages.delegate(".ite-tagAdded","click", f_com1_tagToRemoveFromItem );
    $com1_iteItemEditorWrp.delegate(".ite-tagAdded","click", f_com1_tagToRemoveFromItem );
	



	
    $com1_tgcTagCloudClose.click(function(){
        $com1_tgcTagCloudWrp.hide();
    });

	
    //appendig to item tags list new tag
    $com1_tgcTagsAdd.click(function(){
        var newTag = $com1_tgcTagsInput.val();
        if(newTag.length > 0) {
            $com1_iteTagsAddedTmpl.tmpl( {
                "name":newTag
            } ).appendTo($com1_tgcTagCloudWrp.data("curEditTagLis"));
            $com1_tgcTagsInput.val('');
        }
    });
    





$com1_tgcTagCloudWrp.draggable( {
  handle:"#tgc-tagCloudHeader"
} );
$("#tgc-tagCloudHeader").mousedown(function(){
  $com1_tgcTagCloudWrp.addClass("testt");
});
$("#tgc-tagCloudHeader").mouseup(function(){
  $com1_tgcTagCloudWrp.removeClass("testt");
});


$com1_iteItemEditorWrp.find("#ite-tagIcon").find("img").tipsy({
  live: true,
  gravity: 's',
  delayIn: 1000,
  offset: 3
});
$com1_iteNewItemBtn.tipsy({
  gravity: 'e',
  delayIn: 1000
});
 
 


//new item paginator setting   
    $com1_itpItemPages.universalPaginate({
        itemTemplate: $com1_itpItemTmpl,
        nbItemsByPage: 12,
        nbItemsByPageOptions: [6, 12, 18, 24, 30, 60, 100],
        dataUrl: path+"\/items\/todo",
        controlsPosition:"bottom",
        universalPaginateClass: "itp-itemsPaginator",
        headerElement: $("#itp-paginatorWrp"),
        pageText:null,
        itemsByPageText:null
//        onDataUpdate: function(data) {}
    });

//   ui button hover decoration
    $(".ui-state-default").hover(function(){
        $(this).addClass("ui-state-hover");
    },function(){
        $(this).removeClass("ui-state-hover");
    });


//  flash alert message
  if($com1_alertMessage.length) {
    var alerttimer = window.setTimeout(function () {
      $com1_alertMessage.trigger('click');
    }, 4500);
    $com1_alertMessage.animate({
      height: [$com1_alertMessage.css("line-height") || '52', 'swing']
      }, 400).click(function () {
      window.clearTimeout(alerttimer);
      $com1_alertMessage.animate({
        height: '0'
      }, 400);
      $com1_alertMessage.css({
        'border':'none'
      });
    });
  }
  
 
});


//@todo : to del. we now have common editor		
//$com1_itpItemPages.delegate(".itemDel","click",function(){		
//		
//  var parId = $(this).parents(".itp-item");
//				
//  if (confirm('Are you sure to delete?')) {
//    //to validate
//    var itId = parId.attr("id").replace("item_", "");
//    if( typeof(itId) !== "undefined" && itId !== "" ) {
//      $.ajax({
//        dataType:"json",
//        type: "POST",
//        data: {
//          "data[itId]":itId
//        },
//        success:function (data, textStatus) {
//          if( data.stat === 1) {
//            parId.children().css({
//              "background-color":"lightPink"
//            }).end().fadeOut(600 ,function(){
//              $(this).remove();
//            });
//          } else {
//            flash_message("Couldn't be deleted", "fler" );
//          }
//        },
//        url: path+"\/items\/delItem",
//        error:function(){
//          alert('Problem with the server. Try again later.');
//        }
//      });
//    }
//  }
//			
//});
//@todo :to del. we now have common editor
//$com1_itpItemPages.delegate(".itemSubmit","click",function(){
//					
//  var parIt = $(this).parents(".itp-item");
//  //to clear id.
//  var itId =  parIt.attr("id").replace("item_", "");
//  var itemVal = parIt.find(".itemTextArea").val();
//
//		    	
//  var itemObj = {
//    "data[id]":itId,
//    "data[item]": itemVal
//  };
//	    				
//  if( typeof(itId) !== "undefined" && itId !== "" ) {
//    $.ajax({
//      dataType:"json",
//      type: "POST",
//      data: itemObj,
//      success:function (data, textStatus) {
//        if( data.stat === 1) {
//											
//          //parIt.data("origText",data.word);
//          parIt.data("origText",data.word).find("div.itemEditBlock").hide().prev().show().find("span.origText").text(data.word);
//          parIt.find("span.itemHead").text(data.word);
//          parIt.children(".itemViewBlock").animate(
//          {
//            "background-color": "lightgreen"
//          },{
//            duration: 1000
//          }
//          ).animate(
//          {
//            "background-color": "#fffff0"
//          },{
//            duration: 1000
//          }
//          );
//        } else {
//          flash_message("Couldn't be edited", "fler" );
//        }
//      },
//      url: path+"\/items\/saveItem",
//      error:function(){
//        alert('Problem with the server. Try again later.');
//      }
//    });
//													  		
//  }
//		    	 
//});

//  @todo tests to remove

//function moveToEnd(target) {
//  var rng, sel;
//  if ( document.createRange ) {
//    rng = document.createRange();
//    rng.selectNodeContents(target);
//    rng.collapse(false); // схлопываем в конечную точку
//    sel = window.getSelection();
//    sel.removeAllRanges();
//    sel.addRange( rng );
//  } else { // для IE нужно использовать TextRange
//    rng = document.body.createTextRange();
//    rng.moveToElementText( target );
//    rng.collapse(false);
//    rng.select();
//  }
//  target.focus();
//}
//
//
//function initPage() {
//  var elEd = document.getElementById('ll');
//  elEd.contentEditable=true;
//  elEd.focus();
//} 
//
////tests. Don't forget to del.
//var $ll = $("#ll");
//  $("#fucusEd").click(function(){		
//    moveToEnd($ll.get(0));
//  });
//  html for above
//<div class="span-24">
//  <h5 style="color:red;">to del: views/items/todo.ctp</h5>
//  <?php echo $this->Form->button('fucus', array('id' => 'fucusEd')); ?>
//  <div id="editable" class="span-4">
//    <span>You text here:</span>
//    <span id="ll" contenteditable="true">
//				test test
//				test
//    </span>
//  </div>
//</div>	

 
