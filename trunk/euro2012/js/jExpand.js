(function($){
    $.fn.jExpand = function(){
        var element = this;

        $(element).find("tbody tr:nth-child(4n+1)").addClass("odd");
        $(element).find("tbody tr:nth-child(4n+3)").addClass("even");
        $(element).find("tbody tr:odd").hide().addClass("details");

        $(element).find("tr.odd,tr.even").click(function() {
            $(this).next("tr").toggle();
            $(this).find(".arrow").toggleClass("up"); 
        });
    }    
})(jQuery); 