(function($) {
	// plugin definition
	$.fn.pinFooter = function(options) {		
   if( $(window).height() > $('body').height() )    
      {$(this).css("position","fixed");
       $(this).css("bottom","0");
       $(this).css("width","100%");}
    else
      {$(this).css("position","relative")}
   	                                   };
             })(jQuery);

