/* Framework JS code for tree component */
(function ($) {

    "use strict";

    var toggle = function (ev) {
        $("> ul", this).toggle(); // TODO: use animation instead
        ev.stopPropagation(); // don't toggle parent
    };

    var tree = function (i, node) { // TODO: rename
        var root = $(this);
        // $("ul", root).hide(); // TODO: optional
        $("li", root).click(toggle);
    };

    $.fn.tree = function (options) {
        options = options || {}; // XXX: unused
        this.each(tree);
    };

}(jQuery));