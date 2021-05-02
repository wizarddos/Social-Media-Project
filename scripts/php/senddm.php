<?php 
require_once "../../includes/connect.php";
require_once "scripts.php";

$content = $_POST['content'];
$toWho = $_POST['toWho'];

if($_SESSION['user']->sendMessage($toWho, $content)){
     header("Location: ../../views/wiadomosci");
}else{
     header("Location: ../../views/wiadomosci");

}