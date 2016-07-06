/**
 * Header scroll stuff
 */
(function () {

    var $header = $("#header");
    var $home = $("#home");
    var $home_height = null;

    $(window).scroll(function () {
        var scrollTop = document.body.scrollTop;

        if (scrollTop > ($home_height - 200)) {
            $header.addClass("header--blue");
        }
        else {
            $header.removeClass("header--blue");
        }
    });

    $(window).resize(function () {
        $home_height = $home.height();
    });

    // on page load do this:
    $(window).trigger("resize");
}());

/**
 * Hero cloud carousel
 */
(function () {
    var $carouselItemsParent = $(".cloud-carousel-dest");
    var $carouselItems = $carouselItemsParent.children();

    var $carouselBtnsParent = $(".cloud-carousel-btns");
    var $carouselBtns = [];

    var currentPosition = 0;
    var positionMax = $carouselItems.length - 1;
    var timeout = "0";

    function goTo(newPosition) {

        // clear active state of old button (corresponding to carousel item)
        $carouselBtns.eq(currentPosition).removeClass("is-active");

        var $carouselItem = $carouselItems.eq(newPosition);

        // add active state to new button (corresponding to carousel item)
        $carouselBtns.eq(newPosition).addClass("is-active");

        $carouselItemsParent.animate({
            scrollLeft: $carouselItem.get(0).offsetLeft
        }, 1200, "easeInOutExpo");

        currentPosition = newPosition;

        timeout = setTimeout(function(){
            var _position = currentPosition++;

            if (_position > positionMax)
                _position = 0;

            goTo(_position);
        }, 3000);
    }

    $carouselItems.each(function(i){
        var $newBtn = $("<span>");
        $carouselBtnsParent.append($newBtn);

        $newBtn.click(function(){
            clearTimeout(timeout);
            goTo(i);
        });
    });

    // update now that carousel btns are populated
    $carouselBtns = $carouselBtnsParent.children();

    // init
    goTo(0);
}());