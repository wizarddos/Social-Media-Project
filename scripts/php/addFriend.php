<?php 
require_once "scripts.php";
require_once "../../includes/connect.php";
if(!isset($_SESSION['user'])){
     header("Location: unloged.php");
     echo "nie Powinno cię tu być";
     exit();
}

$id = $_POST['id'];
$ShouldAdd = $_POST['add'];


try{
     global $db_dsn, $db_user, $db_pass;
     $db = new PDO($db_dsn, $db_user, $db_pass);
     $sql = "SELECT friends FROM users WHERE id = ?";
     $stmt = $db->prepare($sql);
     $stmt->bindParam(1, $_SESSION['user']->id);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     $friends = $result['friends'];
     if(strpos($friends, $id) != false){
          $toreplace = $id.", ";
          $friendsFull = str_replace($toreplace, "", $friends);
          
     }else{
          $friendsFull = $friends." ".$id.", ";
     }
     $sql2 = "UPDATE users SET friends = ? WHERE id = ?";
     $stmt2 = $db->prepare($sql2);
     $stmt2->bindParam(1, $friendsFull);
     $stmt2->bindParam(2, $_SESSION['user']->id);
     $stmt2->execute();
     echo "udało się";
     $db = NULL;
}catch (PDOException $e){
     echo $e;
}
