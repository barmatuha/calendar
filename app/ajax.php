<?php
require_once 'main.php';
$month = $_GET['id'];
$year = $_GET['year'];
switch ($month){
    case 1:
        $monthLetter = "January";
        break;
    case 2:
        $monthLetter = "February";
        break;
    case 3:
        $monthLetter = "March";
        break;
    case 4:
        $monthLetter = "April";
        break;
    case 5:
        $monthLetter = "May";
        break;
    case 6:
        $monthLetter = "June";
        break;
    case 7:
        $monthLetter = "July";
        break;
    case 8:
        $monthLetter = "August";
        break;
    case 9:
        $monthLetter = "September";
        break;
    case 10:
        $monthLetter = "October";
        break;
    case 11:
        $monthLetter = "November";
        break;
    case 12:
        $monthLetter = "December ";
        break;
}
echo '<h2>' . $monthLetter . ' ' . $year . '</h2>';
echo draw_calendar($month,$year);
echo nextMonthButton($month, $year);
echo '<input type="button" value="Save changes" onclick="saveChanges()">';