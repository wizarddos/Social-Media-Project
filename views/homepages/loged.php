<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../../styles/styles.css"/>
        <link rel="stylesheet" href="../../styles/fontello/css/fontello.css"/>
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
        </div>
            <button onclick="openNav()"><i class = "icon-menu"></i></button>
            <section class = "headerSection"> 
                <a href = "#" class = "headerA">Home</a>
                <a href = "" class = "headerA"><i class = "icon-plus"></i></a>
                <a href = "" class = "headerA"><i class = "icon-search"></i></a>
                <a href = "" class = "headerA"><i class = "icon-comment-alt"></i></a>
            </section>
        </header>
        <main>
            <section class = "Posts" id = "Posts">

            </section>
            <nav class = "friends">

            </nav>
        </main>

        <script src="../../scripts/js/sidenav.js"></script>
        <script src="../../scripts/js/AsyncPostsScripts.js"></script>
        <script>
            showPhotos();
        </script>
    </body>
</html>