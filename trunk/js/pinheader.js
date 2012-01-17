(function($) {
// plugin definition
$.fn.pinHeader = function(options) {
// Get the height of the footer and window + window width
var wH = $(window).height();
var wW = getWindowWidth();
var bH = $("body").outerHeight(true);
var mT = parseInt($("body").css("margin-top"));
var hNav = $("#navigation").height() + 20;

 // Pinned option
// Set CSS attributes for positioning footer
$(this).css("position","fixed");
$(this).css("width",wW + "px");
$(this).css("top","0px");
$("body").css("height",(bH + mT) + "px");
$("#wrapper").css('margin-top',(hNav) + "px");
};

// Dependable function to get Window Height
function getWindowHeight() {
var windowHeight = 0;
if (typeof(window.innerHeight) == 'number') {
windowHeight = window.innerHeight;
}
else {
if (document.documentElement && document.documentElement.clientHeight) {
windowHeight = document.documentElement.clientHeight;
}
else {
if (document.body && document.body.clientHeight) {
windowHeight = document.body.clientHeight;
}
}
}
return windowHeight;
};

// Dependable function to get Window Width
function getWindowWidth() {
var windowWidth = 0;
if (typeof(window.innerWidth) == 'number') {
windowWidth = window.innerWidth;
}
else {
if (document.documentElement && document.documentElement.clientWidth) {
windowWidth = document.documentElement.clientWidth;
}
else {
if (document.body && document.body.clientWidth) {
windowWidth = document.body.clientWidth;
}
}
}
return windowWidth;
};
})(jQuery);