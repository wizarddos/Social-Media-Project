<?php
session_start();
require_once "view.php";
require_once "../../includes/connect.php";
$login = $_POST['login'];
$pass = $_POST['pass'];

$user = login($login, $pass);
if($user ==  "Nieprawidłowy login lub hasło"){
    $_SESSION['err'] = $user;
    header("Location: ../../views/homepages/unloged.php");
}else{
        $_SESSION['user'] = new User($user['email'], $user['id'], $user['age'], $user['name'], $user['surname'], $user['status']);
        header("Location: ../../views/homepages/loged.php");
}
