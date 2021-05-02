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
        <link rel="stylesheet" href="../styles/add.css"/>
        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
        <title>PostIt! - Przyjaciele</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
     </head>
     <body>
          <?php 
               generate_header();
          ?>
          <form action="" method="POST">
               <input type="text" name = "friends"> 
               <button type="submit"></button>

          </form>
          <?php
                
          ?>

        <script src="../scripts/js/sidenav.js"></script>
     </body>
</html>