<?php
require_once "../../scripts/php/scripts.php";
require_once "../../includes/connect.php";
if(!isset($_SESSION['user'])){
    header("Location: unloged.php");
}
?>
<!DOCTYPE html>
<html lang = "pl">
    <head>
        <link rel="stylesheet" href="../../styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="../../styles/styles.css"/>

        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="../styles/styles.css"/>

        <link rel="stylesheet" href="styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="styles/styles.css"/>

        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
        
        <title>PostIt! - Strona główna</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
        
    </head>
    <body>

        <?php generate_header();?>
        <main class = "main">
            <section class = "Posts Friends">
                <?php
                    $_SESSION['user']->showPhotos();
                ?>
            </section>
            <section class = "Posts Friends">
                <h3 class = "ThinksHeader">Myśli:</h3><br/><br/>
                <?php
                    $_SESSION['user']->showThinks();
                ?>
            </section>

        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="../scripts/js/sidenav.js"></script>
        <script src="../scripts/js/like.js"></script>
    </body>
</html>