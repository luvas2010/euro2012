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

    $("div.info, div.error, p.error, div.form_info, div.flashinfo").click(function () {
      $(this).hide("slow");
      });
    
    $('.delete, .flag, .user_delete').click(function(){ // to confirm deleting users
        var answer = confirm('Are you sure?');
        return answer; // answer is a boolean
    });
    
   $('#footer').pinFooter();
 //$('#navigation').pinHeader(); //geeft ruimte onder footer daarom uit en deze relative functions
   
   $('.warnings h5').click(function() {
    $('.warning').slideToggle("slow");
     });
    
   $(function() {
      var p = $(".warnings h5");
      for(var i=0; i<4; i++) {
        p.animate({opacity: 0.0}, 500, 'linear')
         .animate({opacity: 1}, 800, 'linear');
      }
    });
    $("select, input:radio, input:file").uniform();
});


$(window).load(function() {

});

$(window).resize(function() {
   $('#footer').pinFooter(); 
//   $('#navigation').pinHeader();
});




              
