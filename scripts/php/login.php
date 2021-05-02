<?php
//session_start();
require_once "scripts.php";
require_once "../../includes/connect.php";
$login = $_POST['login'];
$pass = $_POST['pass'];

$user = login($login, $pass);
if(!$user){
    header("Location: ../../views/zaloguj-sie");
}else{
    $_SESSION['user'] = new User($user['email'], $user['id'], $user['age'], $user['name'], $user['surname'], $user['status']);
    header("Location: ../../views/strona-glowna");
}

