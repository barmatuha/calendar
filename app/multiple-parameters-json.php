<html>
<head>
    <title>Change list</title>
</head>
<body>
<br/>
<b>Events removed to date:</b>
<br/>
<?php
require_once 'DB.php';
// accept JSON parameter (and Un-quote string if needed)
$p = stripslashes($_REQUEST['p']);
// decode JSON object (it shouldn't be decoded as associative array)
$arr = json_decode($p);
// open loop through each array element
foreach ($arr as $p){
    // set id, row index and cell index
    $id = $p[0];
    $row = $p[1];
    $cell = $p[2];
    $class = $p[3];
    $text = substr($p[4], 0, -2);  // cut "/n/n" at the end
    $newDate = ($row-2)*7+$cell+4;
    $newYear = '2017';          //crutch, need to resend table ID, which contain data about year, month. Now work only for first month
    $newMonth = '6';
    echo $text . ' => ' . $newDate . '.' . $newYear . '</br>';
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "UPDATE `events` SET `date` = '" . $newYear . "-". $newMonth . "-" . $newDate . "' WHERE `name`='" . $text . "'";
    echo $sql . '<br>';
    $mysqli->query($sql);
}
?>
</body>
</html>