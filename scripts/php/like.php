<?php

require_once "../../includes/connect.php";
require_once "scripts.php";
try{
     $id = $_POST['id'];
     $shouldAdd = $_POST['add'];
     $sql = "SELECT * FROM photos WHERE id = ?";
     $db = new PDO($db_dsn, $db_user, $db_pass);
     $stmt = $db->prepare($sql);
     $stmt->bindParam(1, $id);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     
     if($shouldAdd == 'true' && true){
          $likes = $result['likes']+1;
     }else{
          $likes = $result['likes'];
          $likes--;
     }

     $sql2 = "UPDATE photos SET likes = :likes WHERE id = :id";
     $prepared = $db->prepare($sql2);
     $prepared->bindParam(':likes', $likes, PDO::PARAM_INT);
     $prepared->bindParam(':id', $id, PDO::PARAM_INT);
     $prepared->execute();
     echo $likes;


}catch(PDOException $e){
     echo json_encode($e);
}