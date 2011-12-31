// remap jQuery to $
(function($){})(window.jQuery);


/* trigger when page is ready */
$(document).ready(function (){

    $("#validateMe").validate({
        errorClass: "invalid"
    });
    $(".stripeMe tr").mouseover(function(){$(this).addClass("over");}).mouseout(function(){$(this).removeClass("over");});
    $(".stripeMe tr:even").addClass("alt");
    $("div.info, div.error, div.form_info, div.flashinfo").click(function () {
      $(this).hide("slow");
      });
    
});


/* optional triggers

$(window).load(function() {
    
});

$(window).resize(function() {
    
});

*/
              
