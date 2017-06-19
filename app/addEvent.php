<?php
if (isset($_POST['function'])){
    echo '<form method="post" id="saveNewEventForm" action="" >                                                                 
              <div class="table">
                <div class="row">Input new event data</div>
                <div class="row">
                    <div class="cell">Name: </div>
                    <div class="cell">
                        <input type="text" name="newEventName" placeholder="event name">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">Date: </div>
                    <div class="cell">
                        <input type="date" name="newEventDate" value="<?php echo date(\'o-m-d\') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">Time: </div>
                    <div class="cell">
                        <input type="time" name="newEventTime" value="'. "<?php echo date('o-m-d') ?>" . '">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">Description: </div>
                    <div class="cell">
                        <input type="text" name="newEventDescription" placeholder="event description">
                    </div>
                </div>
                <div class="row">
                    <div class="cell">Choose color: </div>
                    <div class="cell">
                        <input type="color" name="newEventColor" style="width: 60px; height: 30px">                            
                    </div>
                </div>
              </div>
              <input type="button" id="saveNewEventBtn" class="button" value="Отправить" onclick="saveNewEvent()" />
          </form>';
}

if (isset($_POST["newEventName"]) && isset($_POST["newEventDate"]) && isset($_POST["newEventTime"]) && isset($_POST["newEventDescription"]) && isset($_POST["newEventColor"]) ) {
    $result = array(
        'newEventName' => $_POST["newEventName"],
        'newEventDate' => $_POST["newEventDate"],
        'newEventTime' => $_POST["newEventTime"],
        'newEventDescription' => $_POST["newEventDescription"],
        'newEventColor' => $_POST["newEventColor"],
    );
    $sql = "INSERT INTO `events` (`name`, `date`, `time`, `description`, `color`)";
    $sql = $sql . "VALUES ('" .
        $result['newEventName'] . "','" .
        $result['newEventDate'] . "','" .
        $result['newEventTime'] . "','" .
        $result['newEventDescription'] . "','" .
        $result['newEventColor'] . "')";
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM users WHERE login=$login";
    $rez = $mysqli->query($sql);
}


