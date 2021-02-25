<?php
session_start();
if($_SESSION['loged']){
    header("Location: views/homepages/loged.php");
    exit();
}else{
    header("Location: views/homepages/unloged.html");
    exit();
}