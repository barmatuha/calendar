/*jslint white: true, browser: true, undef: true, nomen: true, eqeqeq: true, plusplus: false, bitwise: true, regexp: true, strict: true, newcap: true, immed: true, maxerr: 14 */
/*global window: false, REDIPS: true, $: true */

/* enable strict mode */
"use strict";

// create redips container
var redips = {};


// REDIPS.drag initialization
redips.init = function () {
    REDIPS.drag.init();
};

// new table using AJAX/jQuery to the drag container
redips.load_table = function (button, newContainerId, nextMonth, year) {
    // parameter (example for ajax request)
    var id = nextMonth;
    // disable button (it can be clicked only once)
    button.style.backgroundColor = '#c0c0c0';
    button.disabled = true;
    // AJAX request
    $.ajax({
        type: 'GET',
        url: 'app/ajax.php',
        data: {"id": id, "year": year},
        cache: false,
        success: function (result) {
            // load new table
            $(newContainerId).html(result);
            // rescan tables
            REDIPS.drag.initTables();
        }
    });
};

// add onload event listener
if (window.addEventListener) {
    window.addEventListener('load', redips.init, false);
}
if (window.attachEvent) {
    window.attachEvent('onload', redips.init);
}