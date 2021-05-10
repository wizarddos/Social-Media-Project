<?php
     require_once "../scripts/php/scripts.php";
     require_once "../includes/connect.php";
     if(!isset($_SESSION['user'])){
     header("Location: unloged.php");
     }
?>
<!DOCTYPE html>
<html>
     <head>
        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="../styles/styles.css"/>
        <link rel="stylesheet" href="../styles/friends.css"/>
        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
        <title>PostIt! - Przyjaciele</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
     </head>
     <body>
          <?php 
               generate_header();
          ?>
          <main class = "main">
               <form action="" method="GET">
                    <h2>Szukaj znajomych</h2>
                    <label>Login Przyjaciela<br/><input type="text" name = "friends" class = "searchInput" required/> </label>
                    <button type="submit" class = "submit">Szukaj</button>
               </form><br/>
          </main>
          <section>
               <?php
                    if (isset($_GET['friends'])) {
                         $search = $_GET['friends'];
                         if(ctype_alnum($search)){
                              $searchS = htmlentities($search, ENT_HTML5, "UTF-8");
                              try{
                                   global $db_dsn, $db_user, $db_pass;
                                   $db = new PDO($db_dsn, $db_user, $db_pass);
                                   $sql = "SELECT * FROM USERS WHERE user = ? OR surname = ? OR name = ? EXCEPT SELECT * FROM users WHERE id = ?";
                                   $stmt = $db->prepare($sql);
                                   $stmt->bindParam(1, $searchS);
                                   $stmt->bindParam(2, $searchS);
                                   $stmt->bindParam(3, $searchS);
                                   $stmt->bindParam(4, $_SESSION['user']->id);
                                   $stmt->execute();
                                   if($stmt->rowCount() > 0){
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                             $username = $row['user'];
                                             $name = $row['name']." ".$row['surname'];
                                             if($row['profpic'] != ""){$pfpic = "../img/pfpics/".$row['profpic'];}
                                             else{$pfpic = "../img/deafultimg/default.jpg";}
                                             $age = $row['age'];
                                             if($row['status'] == "single"){$status = "singiel";}
                                             else{$status = "W związku";}
                                             $id = $row['id'];
                                             echo<<<END
                                                  <br/>
                                                  <div class = "profile">
                                                       <img src = "$pfpic" width="70px" height="80px"/>
                                                       &nbsp;
                                                       &nbsp;
                                                       &nbsp;
                                                       <div class="info">
                                                            Login: $username<br/>
                                                            Imię: $name<br/>
                                                            Wiek: $age<br/>
                                                            Status: $status
                                                       </div>
                                                       &nbsp;
                                                       &nbsp;
                                                       &nbsp;
                                                       <div class = "add">
                                                            <button class = "btn-add" id = "$id" onClick = "add(this)">Dodaj<br/> Przyjaciela</button>
                                                       </div>
                                                  </div><br/><br/>
                                             END;
                                        }
                                   }else{
                                        echo "Nie ma takiego użytkownika<br/>";
                                        echo "Dobrze wpisałeś login?";
                                   }
                              }catch(PDOException $e){
                                   echo "BŁąd Serwera";
                              }
                         }else{
                              echo "znaki muszą być alfanumeryczne (litery i cyfry bez spacji)";
                         }
                    }
               ?>
          </section>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script src="../scripts/js/sidenav.js"></script>
          <script src="../scripts/js/addFriend.js"></script>
          <script>
               const add = (btn)=>{
                    let id = btn.id;
                    $.ajax({
                         url: "../scripts/php/addFriend.php",
                         method: "POST",
                         data: "id="+id+"&add="+true,

                         success:(val)=>{
                              alert(val);
                         }
                    });
               }

          </script>
     </body>
</html>