<?php
session_start();
require_once "scripts.php";
require_once "../../includes/connect.php";
$register = register($_POST['login'], $_POST['pass'], $_POST['pass2'], $_POST['email'], $_POST['age'], $_POST['status'], $_POST['name'], $_POST['surname']);
if(!$register){
    header("Location: ../../views/register.php");
}else{
    $login = htmlentities($_POST['login'], ENT_HTML5, "UTF-8");
    $pass = htmlentities($_POST['pass'], ENT_HTML5, "UTF-8");
    $email =htmlentities($_POST['email'], ENT_HTML5, "UTF-8");
    $status =htmlentities($_POST['status'], ENT_HTML5, "UTF-8");
    $name = htmlentities($_POST['name'], ENT_HTML5, "UTF-8");
    $surname = htmlentities($_POST['surname'], ENT_HTML5, "UTF-8");
    
    try{
        global $db_dsn, $db_user, $db_pass;
        $db = new PDO($db_dsn, $db_user, $db_pass);
        $sql = "SELECT `id` FROM users WHERE user = ? ";
        $prepared = $db->prepare($sql);
        $prepared->bindParam(1, $login, PDO::PARAM_STR);
        $prepared->execute();
        $row = $prepared->fetch(PDO::FETCH_ASSOC);
        if($row['id'] == NULL){
            echo "brak id";
            exit();
        }
        
    }catch(PDOException $e){
        $_SESSION['e_serv'] = $e;
        header("Location: ../../views/zarejestruj-sie");
    }
    $id = $row['id'];
    $_SESSION['user'] = new User($email, $id, $_POST['age'], $name, $surname, $status);
    if(isset($_SESSION['user'])){
        header("Location: ../../views/strona-glowna");
    }else{
        $_SESSION['e_serv'] = "błąd serwera. Kod 1";
    }


}