<?php
require_once 'DB.php';

function auth_draw(){
    $auth = '<form action="/" method="post">
        <div id="loginBox">
            <div class="menuCaption"></div>
            <input type="text" id="login" name="login" value=""><br>
            <input type="password" id="pvd" name="password" value=""><br>
            <input type="submit" class="button" value="Enter" name="log_in">
            <input type="button" class="button" onclick="logOut()" value="Logout"><br>                        
        </div>
    </form>
    <input type="button" class="button" onclick="addEvent()" value="Add new event">
    <div id="errorAddBlock"></div>';
    return($auth);
}

function enter (){
    $error = array(); //error array
    if ($_POST['login'] != "" && $_POST['password'] != ""){ //if fields are not empty
        $login = $_POST['login'];
        $password = $_POST['password'];
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $sql = "SELECT * FROM `users` WHERE `login`='$login'";
        $rez = $mysqli->query($sql);        //require DB line with entered login
        if (mysqli_num_rows($rez) == 1){ //if line found, user exist
            $row = mysqli_fetch_assoc($rez);
            if ((md5($password).$row['salt']) == md5($row['password'])){ //compare DB pass with entered pass
                //enter login and pass to cookie
                setcookie ("login", $row['login'], time() + 50000);
                setcookie ("password", md5($row['login'].$row['password']), time() + 50000);
                $_SESSION['id'] = $row['id'];	//write user id to session
                $id = $_SESSION['id'];
                lastAct($id);
                return $error;
            }
            else{ //if passwords are not match
                $error[] = "Incorrect pass";
                return $error;
            }
        }
        else{ //if no user in DB
            $error[] = "Incorrect pass and login";
            return $error;
        }
    }
    else {
        $error[] = "Fields can't be empty";
        return $error;
    }
}

function login () {
    ini_set ("session.use_trans_sid", true);
    session_start();
    if (isset($_SESSION['id'])){    //if session exist
        if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){ //if cookie exist, refresh them
            SetCookie("login", "", time() - 1, '/');
            SetCookie("password","", time() - 1, '/');
            setcookie ("login", $_COOKIE['login'], time() + 50000, '/');
            setcookie ("password", $_COOKIE['password'], time() + 50000, '/');
            $id = $_SESSION['id'];
            lastAct($id);
            return true;
        }
        else{ //else add cookie with nick and pass
            $db = Database::getInstance();
            $mysqli = $db->getConnection();
            $sql = "SELECT * FROM `users` WHERE `id`='{$_SESSION['id']}'";
            $rez = $mysqli->query($sql);    //require line with id
            if (mysqli_num_rows($rez) == 1){ //if have one line
                $row = mysqli_fetch_assoc($rez); //put it to array
                setcookie ("login", $row['login'], time()+50000, '/');
                setcookie ("password", md5($row['login'].$row['password']), time() + 50000, '/');
                $id = $_SESSION['id'];
                lastAct($id);
                return true;
            }
        else return false;
        }
    }
    else{ //if no session, check cookie. If exist -> check in DB
        if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){ //if cookie exist
            $db = Database::getInstance();
            $mysqli = $db->getConnection();
            $sql = "SELECT * FROM `users` WHERE `login`='{$_COOKIE['login']}'";
            $rez = $mysqli->query($sql);    //require line with login and pass
            @$row = mysqli_fetch_assoc($rez);
            if(@mysql_num_rows($rez) == 1 && md5($row['login'].$row['password']) == $_COOKIE['password']){ //if login and pass are in DB
                $_SESSION['id'] = $row['id']; //write id into session
                $id = $_SESSION['id'];
                lastAct($id);
                return true;
            }
            else{ //if cookies are not OK, delete them
                SetCookie("login", "", time() - 360000, '/');
                SetCookie("password", "", time() - 360000, '/');
                return false;
            }
        }
        else{ //if cookie doesn't exist
            return false;
        }
    }
}

function is_admin($id) {
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "SELECT `prava` FROM `users` WHERE `id`='$id'";
    $rez = $mysqli->query($sql);
    if (mysqli_num_rows($rez) == 1){
        $prava = mysqli_fetch_row($rez);
        if ($prava[0] == 1) return true;
        else return false;
    }
    else return false;
}

function out () {
    session_start();
    $id = $_SESSION['id'];
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "UPDATE `users` SET `online`='0' WHERE `id`='$id'"; //refresh field online, user left site
    $mysqli->query($sql);
    unset($_SESSION['id']); //delete session
    SetCookie("login", ""); //delete login cookie
    SetCookie("password", ""); //delete cookie pass
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/'); //redirect to main page
}

function lastAct($id){
    $tm = time();
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "UPDATE `users` SET `online`='$tm', `last_act`='$tm' WHERE `id`='$id'";
    $mysqli->query($sql);
}

if ($_POST['function'] == 'logOut'){
    out();
}