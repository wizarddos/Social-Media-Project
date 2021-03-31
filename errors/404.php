<html>
    <head>
        <link rel="stylesheet" href="../styles/fontello/css/fontello.css"/>
        <link rel = "stylesheet" href="../styles/styles.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>404 - Nie znaleziono strony</title>
    </head>
    <body>
        <?php
            require_once "../scripts/php/view.php";
            generate_header();
        ?>
        <main class = "Posts">
            <h1>404 - Nie znaleziono strony</h1>
            <?php 
                if(isset($_SESSION['user'])){
                    echo '<a href = "../views/homepages/loged.php">Wroć na stronę główną</a>';
                }else{
                    echo '<a href = "../views/homepages/unloged.php">zaloguj się</a>';
                }
            ?>
        </main>
        <script src="../scripts/js/sidenav.js"></script>
    </body>
</html>