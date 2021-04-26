<?php

require_once "scripts.php";
require_once "../../includes/connect.php";

if(isset($_POST['submited'])){
     $profileimg = $_FILES['pfp'];
     
     $pfpname = $_FILES['pfp']['name'];
     $pfpTmpName = $_FILES['pfp']['tmp_name'];
     $pfpSize = $_FILES['pfp']['size'];
     $pfpError = $_FILES['pfp']['error'];
     $pfpType = $_FILES['pfp']['type'];

     $pfpExt = explode('.', $pfpname);
     $pfpRelExt = strtolower(end($pfpExt));
     
     $allowed = array('jpg', 'jpeg', 'png');
     if (in_array($pfpRelExt, $allowed)) {
          if($pfpError === 0){
               if($pfpSize < 40000){
                    $pfpNewName = $_SESSION['user']->getlogin().'.'.$pfpRelExt;
                    $pfpDestin = '../../img/pfpics/'.$pfpNewName;
                    if (move_uploaded_file($pfpTmpName, $pfpDestin)) {
                         try{
                              global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
                              $db = new PDO($db_dsn, $db_user, $db_pass);
                              $sql = "UPDATE users SET profpic = ? WHERE id = ?";
                              $stmt = $db->prepare($sql);
                              $stmt->bindParam(1, $pfpNewName);
                              $stmt->bindParam(2, $_SESSION['user']->id);
                              $stmt->execute();
                              $_SESSION['e_file'] = "Przesyłanie powiodło się";
                              header("Location: ../../views/Profile.php");
                         }catch(PDOException $e){
                              $_SESSION['e_file'] = "Błąd przesyłania pliku, spróbuj za kilka minut kod(PFP02)";
                              unlink($pfpDestin);
                              header("Location: ../../views/Profile.php");
                         }
                    }

               }else{
                    $_SESSION['e_file'] = "Plik jest za duży";
                    header("Location: ../../views/Profile.php");  
               }
          }else{
               $_SESSION['e_file'] = "Błąd przesyłania pliku, spróbuj za kilka minut kod(PFP01)";
               header("Location: ../../views/Profile.php");
          }
     }else{
          $_SESSION['e_file'] = "Niedozwolone rozszerzenie";
          header("Location: ../../views/Profile.php");
     }
}