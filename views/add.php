<?php
     require_once "../scripts/php/scripts.php";
     require_once "../includes/connect.php";
     if(!isset($_SESSION['user'])){
          header("Location: homepages/unloged.php");
     }
?>
<!DOCTYPE html>
<html>
     <head>
        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="../styles/styles.css"/>
        <link rel="stylesheet" href="../styles/add.css"/>
        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
        
        
        <title>PostIt! - Dodaj Posty</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
     </head>
     <body>
          <noscript><h1>Włącz Obsługę Javascript w Swojej przeglądarce</h1></noscript>
          <?php 
               generate_header();
          ?>
          <main>
               <section class = "add">
                    <h2>Dodaj Zdjęcie</h2>
                    <form action="../scripts/php/addPhoto.php" method="POST" enctype="multipart/form-data">
                         <label for = "title">Tytuł posta</label><br/>
                         <input type="text" name="title" placeholder="Tytuł posta" maxlength="80" id = "title" class = "title" required/><br/>
                         <label for="file">Zdjęcie</label><br/>
                         <input type="file" name="photo" id="file" required><br/>
                         <label for="desc">Opis</label><br/>
                         <textarea name="desc" id = "desc" maxlength="180" required></textarea><br/>
                         <button type="submit" class = "submit">Dodaj post</button>
                         <br/>
                         <?php
                              if(isset($_SESSION['e_file'])){
                                   echo $_SESSION['e_file'];
                                   unset($_SESSION['e_file']);
                              }
                         ?>
                    </form>
               </section>
               <section class = "add">
                    <h2>Dodaj Myśl</h2><br/>
                    <form class = "addForm" action="../scripts/php/add.php" method="POST">
                         <label>Tytuł<br/><input type = "text" maxlength="80" class = "title" name = "title" placeholder = "tytuł"/></label><br/><br/>
                         <label>Treść<br/><textarea maxlength="180" name = "content" placeholder = "treść"></textarea></label>
                         <input type = "submit" class = "submit" value = "Podziel się ze światem"/>
                    </form>
               </section>
          </main>
          
        <script src="../scripts/js/sidenav.js"></script>
     </body>
</html>