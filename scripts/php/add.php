<?php
//session_start();

require_once "../../includes/connect.php";
require_once "scripts.php";

if(!isset($_POST['title'])){
     header("Location: ../../views/add.php");
     exit();
}
$title = $_POST['title'];
$content = $_POST['content'];
$isOK = true;
if(!is_string($title)){
     $isOK = false;
     $_SESSION['e_title'] = "tytuł musi być ciągiem znaków";
}

if(!is_string($content)){
     $isOK = false;
     $_SESSION['e_content'] = "zawartość musi być ciągiem znaków";
}

if(strlen($title) > 80){
     $isOK = false;
     $_SESSION['e_title'] = "tytuł nie może mieć więcej niż 80 znaków";
}

if(strlen($content) > 80){
     $isOK = false;
     $_SESSION['e_content'] = "zawartość nie może mieć więcej niż 180 znaków";
}

$title = htmlentities($title, ENT_HTML5, "UTF-8");
$content = htmlentities($content, ENT_HTML5, "UTF-8");

try{
     $null = NULL;
     $date = date("Y-m-d");
     $zero = 0;
     $id = $_SESSION['user']->id;
     
     //--------------------------------------------------------------------//


     global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
     $db = new PDO($db_dsn, $db_user, $db_pass);


     $sql = "INSERT INTO thinks VALUES (:id, :title, :content, :whoposted, :whenposted, :likes)";
     $prepared = $db->prepare($sql);
     $prepared->bindParam(':id', $null); //id
     $prepared->bindParam(':title', $title); //title
     $prepared->bindParam(':content', $content); //content
     $prepared->bindParam(':whoposted', $id ); //whoposted
     $prepared->bindParam(':whenposted', $date); //whenposted
     $prepared->bindParam(':likes', $zero); //Likes
     $prepared->execute();
     header("Location: ../../views/thankyou.php");

}catch(PDOException $e){
     echo $e;
}