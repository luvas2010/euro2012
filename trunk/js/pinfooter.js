(function($) {
// plugin definition
$.fn.pinFooter = function(options) {
// Get the height of the footer and window + window width
var wH = getWindowHeight();
var wW = getWindowWidth();
var fH = $(this).outerHeight(true);
var bH = $("body").outerHeight(true);
var mB = parseInt($("body").css("margin-bottom"));

// Pinned option
// Set CSS attributes for positioning footer
$(this).css("position","fixed");
$(this).css("width",wW + "px");
$(this).css("top",wH - fH + "px");
$("body").css("height",(bH + mB) + "px");
$('#wrapper').css('margin-bottom', fH + "px");
$('#wrapper').css('padding-bottom', fH + "px");
};

// private function for debugging
function debug($obj) {
if (window.console && window.console.log) {
window.console.log('Window Width: ' + $(window).width());
window.console.log('Window Height: ' + $(window).height());
}
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