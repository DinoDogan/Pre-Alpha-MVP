/**
 * jQuery Ajax w/ Progress
 */
$.customAjax = function (params) {

    var $ajax;
    var progressFuncs = [];
    var uploadProgressFuncs = [];

    params.xhr = function () {
        var xhr = $.ajaxSettings.xhr();

        xhr.addEventListener("progress", function (e) {
            for (var i in progressFuncs) {
                progressFuncs[i].apply($ajax, [e]);
            }
        });

        xhr.upload.addEventListener("progress", function (e) {
            for (var i in uploadProgressFuncs) {
                uploadProgressFuncs[i].apply($ajax, [e]);
            }
        });

        return xhr;
    };

    $ajax = $.ajax(params);

    // extend

    // std progress
    $ajax.progress = function (func) {
        progressFuncs.push(func);
        // allow chaining
        return $ajax;
    };

    // upload progress
    $ajax.uploadProgress = function (func) {
        uploadProgressFuncs.push(func);
        // allow chaining
        return $ajax;
    };

    return $ajax;
};


/**
 * Fade the HTML of an object.
 *
 * Storyboard:
 * - fade out element
 * - change html
 * - fade element in
 *
 * @param   {string}   html        HTML to transition to (can also be a DOM object)
 * @param   {number}   [speed]     Speed of animation
 * @param   {function} [complete]  Animation complete callback
 */
$.fn.fadeHTML = function (html, speed, complete) {
    $(this).fadeTo(speed, 0, function () {
        $(this).html("").append(html).fadeTo(speed, 1, complete);
    });
    return this;
};


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
 * Hero upload modal stuff
 */
(function () {

    var files;
    var $progressBar = $("#upl-modal4-progress-bar");
    var $emailInput = $("#upl-modal2-input");
    var $messageInput = $("#upl-modal3-input");

    var $chooseFilesBtn = $("#upl-modal1-browse");
    var $uplBtn = $("#upl-modal3-finish");

    var $progressStatus = $("#upl-modal4-title");

    $chooseFilesBtn.click(function () {
        var $fileInput = $("<input>", {type: "file", multiple: "multiple", accept: ".pdf"});
        $fileInput.click();

        $fileInput.change(function () {
            files = this.files;

            console.log(files);

            $("#upl-modal1").modal("hide");
            $("#upl-modal2").modal("show");
        });
    });

    $uplBtn.click(function () {

        var formData = new FormData();

        formData.append("email", $emailInput.val());
        formData.append("message", $messageInput.val());

        // clear inputs
        $emailInput.add($messageInput).val("");

        for (var i = 0; i < files.length; i++) {
            formData.append("files[]", files[i]);
        }

        $progressStatus.html("Uploading...");
        $progressBar.addClass("is-visible");

        $.customAjax({
            url: "/api/upload.php",
            type: "POST",
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            cache: false
        }).uploadProgress(function (e) {
            var currentProgress = e.loaded / e.total;
            $progressBar.css({width: Math.round(currentProgress * 100) + "%"});
        }).done(function (json) {
            setTimeout(function () {
                $progressStatus.fadeHTML("Success!");
            }, 200);
        }).error(function (e) {
            $progressStatus.fadeHTML("Error uploading :(");
        }).complete(function () {
            $progressBar.removeClass("is-visible");
        });
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