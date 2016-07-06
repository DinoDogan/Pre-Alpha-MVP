/**
 * Header scroll stuff
 */
(function () {

    var $header = $("#header");
    var $home = $("#home");
    var $home_height = null;

    var $footerHome = $("#footer-home");
    var $footerHome_top = null;

    $(window).scroll(function () {
        var scrollTop = document.body.scrollTop;

        if (scrollTop > ($home_height + 250) && scrollTop < ($footerHome_top - 100)) {
            $header.addClass("header--blue");
        }
        else {
            $header.removeClass("header--blue");
        }
    });

    $(window).resize(function () {
        $home_height = $home.height();
        $footerHome_top = $footerHome.offset().top;
    });

    // on page load do this:
    $(window).trigger("resize").trigger("scroll");
}());

/**
 * Hero cloud carousel
 */

(function () {

    $(".cloud-carousel-inner").each(function () {

        var $this = $(this);

        var $carouselItemsParent = $this.children(".cloud-carousel-dest");
        var $carouselItems = $carouselItemsParent.children();

        var $carouselBtnsParent = $this.children(".cloud-carousel-btns");
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

            timeout = setTimeout(function () {
                var _position = currentPosition + 1;

                if (_position > positionMax)
                    _position = 0;

                goTo(_position);
            }, 3000);
        }

        $carouselItems.each(function (i) {
            var $newBtn = $("<span>");
            $carouselBtnsParent.append($newBtn);

            $newBtn.click(function () {
                clearTimeout(timeout);
                goTo(i);
            });
        });

        // update now that carousel btns are populated
        $carouselBtns = $carouselBtnsParent.children();

        // init
        goTo(0);

    });
}());

/**
 * Contact page
 */
(function () {
    var $contactForm = $("#contact-form");

    $contactForm.submit(function (e) {

        $.ajax({
            method: $contactForm.attr("data-method"),
            url: $contactForm.attr("data-action"),
            dataType: "JSON",
            data: $contactForm.serialize()
        }).done(function (json) {
            if (!json.error) {
                $contactForm.addClass("has-success");
            }
            else {
                alert(json.error);
            }
        }).error(function () {

        });

        e.preventDefault();
    });
}());