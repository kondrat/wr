
		//flash message

		function flash_message(message, classs ) {
		
				$('div.fl').empty();
				$('div.fl').append('<div id="flashMessage" class="'+classs+'">'+message+'</div>');
						var $alert = $('#flashMessage');
						var alerttimer = window.setTimeout(function () {
							$alert.trigger('click');
						}, 4500);
						$alert.animate(
							{
								height: $alert.css('line-height') || '52px'
							}, 
							800
						).click(function () {
									window.clearTimeout(alerttimer);
									$alert.animate({height: '0'}, 400);
									$alert.css({'border':'none'});							
						});
		}


		
		

   //adding cursor pointer to all clicables elements;   
    (function($){
      $.event.special.click = {
        setup: function() {       	
        	if( !$(this).hasClass("cardEditor") ) {
          	$(this).css('cursor','pointer');
          }
          return false;
        },
        teardown: function() {
          $(this).css('cursor','');
          return false;
        }
      }
    })(jQuery);    			
		

