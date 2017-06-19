function addEvent(){  //request for showing "add new event" form
    $.ajax({
        type: "POST",
        url: "app/addEvent.php",
        data: {"function": "getForm"},
        success: function (result) {
            // load new table
            $("#addEvent").html(result);
        }
    });
}

function saveNewEvent() {   //sending data to save
    $( document ).ready(function() {
        $("#saveNewEventBtn").click(
            function(){
                sendAjaxForm('errorAddBlock', 'saveNewEventForm', 'app/addEvent.php');
                return false;
            }
        );
    });   
}

function sendAjaxForm(result_form, saveNewEventForm, url) {
    jQuery.ajax({
        url:     url,
        type:     "POST",
        dataType: "html",
        data: jQuery("#"+saveNewEventForm).serialize(),
        error: function(response) { //if error
            document.getElementById(result_form).innerHTML = "Error";
        }
    });
}

function logOut() {
    $.ajax({
        type: "POST",
        url: "app/auth.php",
        data: {"function": "logOut"},
    });
}

function logIn(){
    $.ajax({
        type: "POST",
        url: "app/auth.php",
        data: {"function": "logIn"},
    });
}
var redipsInit;


// redips initialization
redipsInit = function () {
    // reference to the REDIPS.drag library and message line
    var	rd = REDIPS.drag,
        msg = document.getElementById('message');
    // how to display disabled elements
    rd.style.borderDisabled = 'solid';	// border style for disabled element will not be changed (default is dotted)
    rd.style.opacityDisabled = 60;		// disabled elements will have opacity effect
    // initialization
    rd.init();
    // only "smile" can be placed to the marked cell
    rd.mark.exception.d8 = 'smile';
    // prepare handlers
    rd.event.clicked = function () {
        msg.innerHTML = 'Clicked';
    };
    rd.event.dblClicked = function () {
        msg.innerHTML = 'Dblclicked';
    };
    rd.event.moved  = function () {
        msg.innerHTML = 'Moved';
    };
    rd.event.notMoved = function () {
        msg.innerHTML = 'Not moved';
    };
    rd.event.dropped = function () {
        msg.innerHTML = 'Dropped';
    };
    rd.event.switched = function () {
        msg.innerHTML = 'Switched';
    };
    rd.event.clonedEnd1 = function () {
        msg.innerHTML = 'Cloned end1';
    };
    rd.event.clonedEnd2 = function () {
        msg.innerHTML = 'Cloned end2';
    };
    rd.event.notCloned = function () {
        msg.innerHTML = 'Not cloned';
    };
    rd.event.deleted = function (cloned) {
        // if cloned element is directly moved to the trash
        if (cloned) {
            // set id of original element (read from redips property)
            // var id_original = rd.obj.redips.id_original;
            msg.innerHTML = 'Deleted (c)';
        }
        else {
            msg.innerHTML = 'Deleted';
        }
    };
    rd.event.undeleted = function () {
        msg.innerHTML = 'Undeleted';
    };
    rd.event.cloned = function () {
        // display message
        msg.innerHTML = 'Cloned';
        // append 'd' to the element text (Clone -> Cloned)
        rd.obj.innerHTML += 'd';
    };
    rd.event.changed = function () {
        // get target and source position (method returns positions as array)
        var pos = rd.getPosition();
        // display current row and current cell
        msg.innerHTML = 'Changed: ' + pos[1] + ' ' + pos[2];
    };
};

// show prepared content for saving
function save(type) {
    // define table_content variable
    var table_content;
    // prepare table content of first table in JSON format or as plain query string (depends on value of "type" variable)
    table_content = REDIPS.drag.saveContent('06.2017', type);
    // display query string
    if (type === 'json') {
        //window.open('/my/multiple-parameters-json.php?p=' + table_content, 'Mypop', 'width=350,height=260,scrollbars=yes');
        window.open('app/multiple-parameters-json.php?p=' + table_content, 'Mypop', 'width=360,height=260,scrollbars=yes');
    }
}
