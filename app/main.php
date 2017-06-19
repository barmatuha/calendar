<?php
require_once 'DB.php';

// draws a calendar
function draw_calendar($month,$year){
    // draw table
    $calendar = '<link rel="stylesheet" type="text/css" href="app/style.css"/>    
    <table cellpadding="0" cellspacing="0" class="calendar" id="'. $month . '.' . $year . '">';
        $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');      //table headings
        $calendar.= '<tr class="calendar-row"><td class="calendar-day" style="background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999;">'.implode('</td><td class="calendar-day" style="background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999;">',$headings).'</td></tr>';
        $running_day = date('w',mktime(0,0,0,$month,1,$year));      //days and weeks vars
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 1;
        $dates_array = array();
        $calendar.= '<tr class="calendar-row">';        //row for week one
            for($x = 0; $x < $running_day; $x++):       //print "blank" days until the first of the current week
            $calendar.= '<td class="calendar-day"> </td>';
            $days_in_this_week++;
            endfor;
            for($list_day = 1; $list_day <= $days_in_month; $list_day++):       // keep going with days
            $calendar.= '<td class="calendar-day-np">';
                $calendar.= '<div class="day-number">'.$list_day.'</div>';      //add in the day number

                /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !! **/
                $eventData = getEvent($day_counter, $month, $year);  //get event data from DB
                $description = generateDescription($eventData);
                if ($eventData) {
                    $calendar .= '<div class="redips-drag" style="background-color: '. $eventData['color'] . '"><p>' . $eventData['name'] . '</p>';  //type event data
                    $calendar .= '<div class="descr"> ' . $description . ' </div></div>'; // info about event
                }
                /**  END OF EVENT PRINT OUT **/

                $calendar.= '</td>';
            if($running_day == 6):
            $calendar.= '</tr>';
        if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
            endfor;
            if($days_in_this_week < 8):     //finish the rest of the days in the week
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day"> </td>';
            endfor;
            endif;
            $calendar.= '</tr>';        //final row
        $calendar.= '</table>';         //end the table     
    return $calendar;
}

function getEvent($day, $month, $year){
    $eventDate = new DateTime();
    $eventDate->setDate($year, $month, $day);   // checking date for existing event
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM `events` WHERE `date`='" . $eventDate->format('Y-m-d') . "'";
    $rez = mysqli_fetch_array($mysqli->query($sql));
    return $rez;
}

function generateDescription($eventData){
    $eventForm = '';
    $eventForm .= '<p>Time: ' . $eventData['time'] . '</p>';
    $eventForm .= '<p>Description: ' . $eventData['description'] . '</p>';
    $eventForm .= '<p>Author: ' . $eventData['author'] . '</p>';
    $eventForm .= '<p>' . $eventData['status'] . '</p>';
    return $eventForm;
}

function generateBase(){
    echo '<div id="addEvent"></div>
      <div id="redips-drag">
      <h2>' . date("F") . ' ' . date("Y") . '</h2>'
        . draw_calendar(date("m"),date("Y")) . '<br>
      <h2>' . date("F", mktime(0, 0, 0, date("m")+1,   date("d"),   date("Y"))) . ' ' . date("Y") . '</h2>'
        . draw_calendar(date("m")+1,date("Y")) . '<br>
      <h2>' . date("F", mktime(0, 0, 0, date("m")+2,   date("d"),   date("Y"))) . ' ' . date("Y") . '</h2>'
        . draw_calendar(date("m")+2,date("Y")) . '<br>';
    echo '<input type="button" value="Save changes" class="button" onclick="save(\'json\')"';
}

function nextMonthButton($month, $year){
    $nextMonth = $month + 1;
    if ($nextMonth == 12){
        $nextMonth = 1;
        $year++;
    }
    $newContainerId = 'load_content_' . $nextMonth . '_' . $year . '';
    echo '<span id="' . $newContainerId . '"/>';  //container for new data
    echo '<input type="button" value="Next month" class="button" onclick="redips.load_table(this, ' . $newContainerId . ', ' . $nextMonth . ', ' . $year . ')" title="Load next month"/>';         //AJAX load new month
}