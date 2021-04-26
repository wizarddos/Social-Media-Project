<?php

require_once "scripts.php";
require_once "../../includes/connect.php";

if(isset($_POST['title'])){
     $title = $_POST['title'];
     $desc = $_POST['desc'];
     $isOk = true;
     if(strlen($title) > 80){
          $_SESSION['e_file'] = "za długi tytuł";
          $isOk = false;
     }

     if(strlen($desc) > 180){
          $_SESSION['e_file'] = "za długi opis";
          $isOk = false;
     }

     if($isOk){
          $titleS = htmlentities($title, ENT_HTML5, "UTF-8");
          $descS = htmlentities($desc, ENT_HTML5, "UTF-8");

          $profileimg = $_FILES['photo'];
          
          $pfpname = $_FILES['photo']['name'];
          $pfpTmpName = $_FILES['photo']['tmp_name'];
          $pfpSize = $_FILES['photo']['size'];
          $pfpError = $_FILES['photo']['error'];
          $pfpType = $_FILES['photo']['type'];

          $pfpExt = explode('.', $pfpname);
          $pfpRelExt = strtolower(end($pfpExt));
          
          $allowed = array('jpg', 'jpeg', 'png');

          if (in_array($pfpRelExt, $allowed)) {
               if($pfpError === 0){
                    if($pfpSize > 25000){
                         $pfpNewName = uniqid('', true).'.'.$pfpRelExt;
                         $pfpDestin = '../../img/posts/'.$pfpNewName;
                         if (move_uploaded_file($pfpTmpName, $pfpDestin)) {
                              try{
                                   $null = null;
                                   $zero = 0;
                                   global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
                                   $db = new PDO($db_dsn, $db_user, $db_pass);
                                   $sql = "INSERT INTO photos VALUES(:id, :title, :nam, :descr, :who, :likes)";
                                   $stmt = $db->prepare($sql);
                                   $stmt->bindParam(':id', $null);
                                   $stmt->bindParam(":title", $titleS);
                                   $stmt->bindParam(":nam", $pfpNewName);
                                   $stmt->bindParam(":descr", $descS);
                                   $stmt->bindParam(":who", $_SESSION['user']->id);
                                   $stmt->bindParam(":likes", $zero);
                                   $stmt->execute();
                                   $_SESSION['e_file'] = "Przesyłanie powiodło się";
                                   header("Location: ../../views/thankyou.php");
                              }catch(PDOException $e){
                                   $_SESSION['e_file'] = "Błąd przesyłania pliku, spróbuj za kilka minut kod(PFP02)";
                                   unlink($pfpDestin);
                                   $_SESSION['e_file'] = $e;
                                   header("Location: ../../views/add.php");
                              }
                         }

                    }else{
                         $_SESSION['e_file'] = "Plik jest za duży";
                         header("Location: ../../views/add.php");  
                    }
               }else{
                    $_SESSION['e_file'] = "Błąd przesyłania pliku, spróbuj za kilka minut kod(PFP01)";
                    header("Location: ../../views/add.php");
               }
          }else{
               $_SESSION['e_file'] = "Niedozwolone rozszerzenie";
               header("Location: ../../views/add.php");
          }
     }else{
          header("Location: ../../views/add.php");
     }

}