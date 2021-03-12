<?php
require_once "../../scripts/php/view.php";
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
        
        
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
        
    </head>
    <body>
        <header>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">zdjęcia</a>
            <a href="#">Dodaj</a>
            <a href="#">Myśli</a>
            <a href="#">Znajomi</a>
            <a href="#">Grupy</a>
            <a href="#">wiadomości</a>
            <br/>
            <br/>
            <a href = "../../scripts/php/unlog.php">Wyloguj się</a>
        </div>
            <button onclick="openNav()"><i class = "icon-menu"></i></button>
            <section class = "headerSection"> 
                <a href = "#" class = "headerA"><i class = "icon-home"></i></a>
                <a href = "" class = "headerA"><i class = "icon-plus"></i></a>
                <a href = "#" class = "headerA"><i class = "icon-search"></i></a>
                <a href = "" class = "headerA"><i class = "icon-comment"></i></a>
            </section>
            <a href="#"><i class = "icon-user"></i></a>
        </header>
        <main>
            <section class = "Posts">
                <?php 
                    $_SESSION['user']->showPhotos();
                ?>
            </section>

        </main>

        <script src="../../scripts/js/sidenav.js"></script>
        <script src="../../scripts/js/AsyncPostsScripts.js"></script>
    </body>
</html>