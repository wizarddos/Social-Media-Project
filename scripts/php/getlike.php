<?php
require_once "../../includes/connect.php";

try{
     $id = $_POST['id'];
     $sql = "SELECT * FROM photos WHERE id = ?";
     $db = new PDO($db_dsn, $db_user, $db_pass);
     $stmt = $db->prepare($sql);
     $stmt->bindParam(1, $id);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);

     echo $result['likes'];
     

}catch(PDOException $e){
     echo json_encode($e);
}