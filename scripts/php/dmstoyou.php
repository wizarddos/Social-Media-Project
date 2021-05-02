
<head>
     <link rel = "stylesheet" href = "../../styles/styles.css"/>
     <style>
          body{
              margin: 4%; 
          }
     </style>
</head>
<?php
echo "<h2>Wiadomości do ciebie</h2><br/>";
require_once "../../includes/connect.php";
require_once "scripts.php";
try {
     $id = $_SESSION['user']->id;
     $db = new PDO($db_dsn, $db_user, $db_pass);
     $sql = "SELECT * FROM messages WHERE toWho = ? ORDER BY id DESC";
     $stmt = $db->prepare($sql);
     $stmt->bindParam(1, $id , PDO::PARAM_INT);
     $stmt->execute();
     $howmany = $stmt->rowCount();
     
     if($howmany > 0){
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
               echo "<p>".$result['content']."</p>";
               echo "<p> Od: ".$result['fromWho']."</p>";
               echo "<p> Wysłano: ".$result['date']."</p><br/><br/>";
          }
     }else{
          echo "<h3>brak wiadomości</h3>";
          echo "<p>wyślij jakąś a może ktoś odpisze</p>";
     }

}catch(PDOException $e){
     
}
