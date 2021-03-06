/**
 * @name        hero.js
 * @requires    jQuery, jQuery.easing, Bootstrap
 * @description Handles homepage functions
 * @version     1.0
 */


/**
 * Hero cloud carousel shows 3 options on page
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

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    //
    // CHOOSE FILES (STEP ONE)
    //

    // reset progress bar here to
    // avoid unnecessary CSS visuals
    $("#upl-modal1").on("show.bs.modal", function () {
        $progressBar.css({width: "0%"})
    });

    $("#upl-modal1-browse").click(function () {
        var $fileInput = $("<input>", {type: "file", /*multiple: "multiple",*/ accept: ".pdf"});
        $fileInput.click();

        $fileInput.change(function () {

            var validationComplete = true;

            files = this.files;

            for (var i = 0; i < files.length; i++) {

                if (files[i].type != "application/pdf" || files[i].size > 25000000) {
                    validationComplete = false;
                    break;
                }
            }

            if (validationComplete) {
                $("#upl-modal1").modal("hide");
                $("#upl-modal2").modal("show");
            }
            else {
                alert("Your file doesn't match type PDF or exceeds 25 MB. Please select another file and try again.");
            }
        });
    });


    //
    // EMAIL VALIDATION (STEP TWO)
    //

    var $emailInput = $("#upl-modal2-input");
    var $emailInputParent = $emailInput.parent().addClass("hint").attr("data-hint", "Invalid email address");

    $("#upl-modal2").on("shown.bs.modal", function () {
        $emailInput.select();
    });

    $("#upl-modal2-next").click(function (e) {

        if (!validateEmail($emailInput.val())) {
            $emailInput.select();
            $emailInputParent.addClass("hint--visible");

            $emailInput.one("input", function () {
                $emailInputParent.removeClass("hint--visible");
            });

            e.stopPropagation();
        }
    });

    // allow enter key on email input
    $emailInput.keydown(function (e) {
        if (e.keyCode == 13) {
            $("#upl-modal2-next").click();
        }
    });

    //
    // SPECIAL INSTRUCTIONS VALIDATION (STEP THREE)
    //
    var $messageInput = $("#upl-modal3-input");
    var $messageInputParent = $messageInput.parent().addClass("hint").attr("data-hint", "Special instructions required");

    $("#upl-modal3").on("shown.bs.modal", function () {
        $messageInput.select();
    });

    $("#upl-modal3-next").click(function (e) {
        if ($.trim($messageInput.val()) == "") {

            $messageInputParent.addClass("hint--visible");

            $messageInput.one("input", function () {
                $messageInputParent.removeClass("hint--visible").select();
            });

            e.stopPropagation();
        }
    });

    //
    // FILE UPLOAD (STEP FOUR)
    //

    var $progressBar = $("#upl-modal4-progress-bar");
    var $progressStatus = $("#upl-modal4-title");

    $("#upl-modal4").on("shown.bs.modal", function () {

        if (files) {

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
                url: "api/upload.php",
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

                if (!json.error) {

                    setTimeout(function () {
                        $progressStatus.fadeHTML("Success!");
                    }, 200);
                }
                else {
                    $progressStatus.fadeHTML(json.error);
                }

                files = null;
            }).fail(function (e) {
                $progressStatus.fadeHTML("Error uploading :(");
            }).always(function () {
                $progressBar.removeClass("is-visible");
            });
        }
        else {

        }
    });

    //
    // HELP section for modal overlays
    //
    $(".modal-header-hint").each(function () {
        var $this = $(this);

        $this.click(function () {
            // generate overlay
            var $modalContent = $("<div>", {class: "modal-content modal-content--help"});
            var $modalHeader = $("<div>", {class: "modal-header"});
            var $modalHeaderClose = $('<button>', {type: "button", class: "close", html: "&times"});

            $modalHeader.append($modalHeaderClose).append('<h4 class="modal-title">Help</h4>');

            $modalHeaderClose.click(function () {
                $modalContent.remove();
                $(window).off("resize.uplhelp");
            });

            var $modalBody = $("<div>", {
                class: "modal-body",
                html: '<div class="row"><div class="col-xs-12">' + $this.attr("data-help") + '</div></div>'
            });

            var $modalFooter = $("<div>", {
                class: "modal-footer xs",
                html: '<div class="col-xs-6 text-left"><a href="mailto:support@magnificent.com">Email Support</a></div>'
                + '<div class="col-xs-6 text-right"><a href="contact.php" target="_blank">Contact Support</a></div>'
            });

            // build
            $modalContent.append($modalHeader).append($modalBody).append($modalFooter);

            $this.parents(".modal-dialog").append($modalContent);

            $(window).on("resize.uplhelp", function () {
                $modalBody.css({height: $this.parent().parent().children('.modal-body')[0].offsetHeight + "px"})
            }).trigger("resize.uplhelp");
        });
    });

}());