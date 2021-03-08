<?php
session_start();
require_once "view.php";
require_once "../../includes/connect.php";
$login = $_POST['login'];
$pass = $_POST['pass'];

$user = login($login, $pass);
if($user == "error" || "Nieprawidłowy login lub hasło"){
    $_SESSION['err'] = $user;
    header("Location: ../../views/homepages/unloged.php");
}else{
    try{
        $db = new PDO($db_dsn, $db_user, $db_pass);
        $Select = "SELECT * FROM users WHERE user = ?";
        $prepared = $db->prepare($Select);
        $prepared->bindParam(1, $_POST['login'], PDO::PARAM_STR);
        $prepared->execute();
        $result = $prepared->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = new User($result['email'], $result['id'], $result['age'], $result['name'], $result['surname'], $result['status']);
        header("Location: ../../views/homepages/loged.php");
        exit();
    }catch(PDOException $e){
        echo "Błąd krytyczny serwera";
    }
}

