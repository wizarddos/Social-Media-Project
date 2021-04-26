<?php
require_once "scripts.php";
if (isset($_POST['pass'])) {
    if ($_SESSION['user']->editProfile($_POST['pass'], $_POST['pass2'], $_POST['email'], $_POST['age'], $_POST['status'], $_POST['name'], $_POST['surname'])) {
     $_SESSION['e_serv'] = "Udało się! wyloguj się aby zobaczyć zmiany";
     header("Location: ../../views/Profile.php");
    }else{
         header("Location: ../../views/Profile.php");
    }
}