<html>
    <head>
        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel = "stylesheet" href="../styles/styles.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>404 - Nie znaleziono strony</title>
    </head>
    <body>
        <?php
            require_once "../scripts/php/scripts.php";
            generate_header();
        ?>
            <h1>404 - Nie znaleziono strony</h1>
            <?php 
                if(isset($_SESSION['user'])){
                    echo '<a href = "../views/homepages/loged.php">Wroć na stronę główną</a>';
                }else{
                    echo '<a href = "../views/homepages/unloged.php">zaloguj się</a>';
                }
            ?>
        <script src="../scripts/js/sidenav.js"></script>
    </body>
</html>