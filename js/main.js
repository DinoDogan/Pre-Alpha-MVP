/**
 * @name            main.js
 * @requires        jquery, jquery.easing, bootstrap
 * @version         1.0
 */

/**
 * Avoid `console` errors in browsers that lack a console.
 */
(function () {
    var method;
    var noop = function () {
    };
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

/**
 * jQuery Ajax shows Progress on upload
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
 * Create BS modal from JS
 */
function bootstrapModal(args) {

    args = args || {};

    var modal = $("<div>", {class: "modal fade", role: "dialog", "data-keyboard": false, "data-backdrop": "static"});
    var modalDialog = $("<div>", {class: "modal-dialog"});
    //
    var modalContent = $("<div>", {class: "modal-content"});
    var modalHeader = $("<div>", {class: "modal-header", html: args.header});
    var modalTitle = $("<div>", {class: "modal-title", html: args.title});
    var modalBody = $("<div>", {class: "modal-body", html: args.body});
    var modalFooter = $("<div>", {class: "modal-footer", html: args.footer});

    modalHeader.append(modalTitle);
    modalContent.append(modalHeader).append(modalBody).append(modalFooter);

    modal.append(modalDialog);
    modalDialog.append(modalContent);

    return modal;
}

/**
 * Nav bar turns white on mobile when open
 */
(function () {
    var $header = $("#header");

    $("#header-nav").on("show.bs.collapse", function () {
        $header.addClass("nav-open");
    }).on("hide.bs.collapse", function () {
        $header.removeClass("nav-open");
    });
}());