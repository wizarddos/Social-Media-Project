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
        <title>PostIt! - Dziękujemy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
     </head>
     <body>
          <noscript><h1>Włącz Obsługę Javascript w Swojej przeglądarce</h1></noscript>
          <?php 
               generate_header();
          ?>
          <h1 style="text-align: center;">dziękujemy za współtworzenie naszej społeczności</h1>
          <a href="strona-glowna">Wróć do głównej</a>

        <script src="../scripts/js/sidenav.js"></script>
     </body>
</html>