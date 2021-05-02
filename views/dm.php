<?php
require_once "../scripts/php/scripts.php";
require_once "../includes/connect.php";
if(!isset($_SESSION['user'])){
    header("Location: unloged.php");
}
?>
<!DOCTYPE html>
<html lang = "pl">
    <head>
        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel="stylesheet" href="../styles/styles.css"/>
        <link rel="stylesheet" href="../styles/dm.css"/>
        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico"/>

        <title>PostIt! - Twoje wiadomości</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
        
    </head>
    <body>

        <?php generate_header();?>
        <main class = "main">
            
            <iframe src="../scripts/php/dmstoyou.php" ></iframe>
            <section class = "sendmsg">
                <h2>Wyślij wiadomość</h2>
                <form action="../scripts/php/senddm.php" method="POST">
                    <label for="content">Zawartość<br/></label>
                    <textarea name="content" id="content"  class = "content"></textarea>
                    <label for="title"><br/>do kogo<br/></label>
                    <input type="text" id = "title" class = "text_input" name="toWho"><br/><br/>
                    <button type="submit" class= "submit">Wyślij</button>
                    <?php
                        if(isset($_SESSION['e_mes'])){
                            echo '<span style = "color:red">'.$_SESSION['e_mes']."</span>";
                            unset($_SESSION['e_mes']);
                        }
                    ?>
                </form>
            </section>
        </main>

        

        <script src="../scripts/js/sidenav.js"></script>
    </body>
</html>