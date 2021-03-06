// remap jQuery to $
(function($){})(window.jQuery);


/* trigger when page is ready */
$(document).ready(function (){

    $("#validateMe").validate({
        errorClass: "invalid"
    });
    $(".stripeMe tr").mouseover(function(){$(this).addClass("over");}).mouseout(function(){$(this).removeClass("over");});
    $(".stripeMe tr:even").addClass("alt");
    $("ul.sf-menu").supersubs({ 
            minWidth:    12,   // minimum width of sub-menus in em units 
            maxWidth:    27,   // maximum width of sub-menus in em units 
            extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                               // due to slight rounding differences and font-family 
        }).superfish();

    $("div.info, div.error, div.form_info, div.flashinfo").click(function () {
      $(this).hide("slow");
      });
    
    $('.delete, .flag').click(function(){ // to confirm deleting users
        var answer = confirm('Are you sure?');
        return answer; // answer is a boolean
    });
    $('#footer').append('<p>Voetbalpool software is belangeloos gemaakt door <a href="https://twitter.com/#!/johnschop">John Schop</a>, &copy;2011. Liefhebbers kunnen <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YTT9NSRN2LB54">doneren</a>.</p>'); 
});


/* optional triggers

$(window).load(function() {
    
});

$(window).resize(function() {
    
});

*/
              
