var $header = $("#header");
var $home = $("#home");

$(window).scroll(function(){
    var scrollTop = document.body.scrollTop;

    if (scrollTop > ($home.height() - 200)) {
        $header.addClass("header--blue");
    }
    else {
        $header.removeClass("header--blue");
    }
});