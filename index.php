<?php
require_once 'app/auth.php';

if (login()){ //request login function, which show, authorized user or not
    $UID = $_SESSION['id']; //if authorized $UID
    $admin = is_admin($UID); //check is admin
    if ($admin == true) {echo 'Welcome, admin!'; $isAdmin = true;}
    else echo 'Welcome, user!';
}
else{ //if user not authorized, check button enter pressed
    if(isset($_POST['log_in'])){
        $error = enter(); //enter site
        if (count($error) == 0){ //if no errors, authorize user
            $UID = $_SESSION['id'];
            $admin = is_admin($UID);
        }
    }
    echo 'Welcome, stranger!';
}

require_once 'app/head.php';
require_once 'app/main.php';

echo auth_draw();
generateBase();
nextMonthButton(date("m")+2, date("Y")+2);
