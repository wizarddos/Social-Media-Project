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
        <link rel="stylesheet" href="../styles/profile.css"/>
        <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
        <title>PostIt! - Twój Profil</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8"/>
        
    </head>
    <body>

        <?php generate_header();?>
        <main class = "main">
            <section class = "Posts">
               <h1>Twój profil</h1>
               <section class = "Profile">
                    <article>
                        <?php
                            try{
                                global $db_dsn, $db_user, $db_pass;
                                $db = new PDO($db_dsn, $db_user, $db_pass);
                                $sql = "SELECT profpic FROM users WHERE id = ?";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(1, $_SESSION['user']->id);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                if($result['profpic'] == ""){
                                    echo '<img src = "../img/deafultimg/default.jpg" />';
                                    echo<<<END
                                        
                                    END;
                                }else{
                                    echo '<img src = "../img/pfpics/'.$result['profpic'].'"/>';
                                }

                            }catch(PDOException $e){
                                echo "<span style = 'color: red'>nie można wyświetlić zdjęcia profilowego</span>";
                            }
                        ?>  

                    </article>
                    <article>
                         <h2>Witaj <?php echo $_SESSION['user']->name ?></h2>
                    </article>
               </section>
               <br/>
               <br/>
               <section  class = "Profile">
                   <article>                       
                       <form action = "../scripts/php/addpfp.php" method = "post" enctype="multipart/form-data">
                            <h2>Zmień zdjęcie profilowe</h2>
                            <br/>
                            <input type="file" name = "pfp" required>
                            <br/><br/>
                            <button type ="submit" name = "submited" class = "submit pfpupdate">Ustaw profilowe</button>
                            <?php
                                if(isset($_SESSION['e_file'])){
                                    echo $_SESSION['e_file'];
                                    unset($_SESSION['e_file']);
                                }
                            ?>
                        </form>
                    </article>
               <article>
                    <h2>twoje dane</h2>
                        <?php
                            echo "<b>Imię: </b> ".$_SESSION['user']->name."<br/>";
                            echo "<b>Nazwisko:</b> ".$_SESSION['user']->surname."<br/>";
                            echo "<b>wiek</b>: ".$_SESSION['user']->age."<br/>";
                            echo "<b>email: </b>".$_SESSION['user']->email."<br/>";
                            if($_SESSION['user']->status == "Married"){
                                echo "<b>Status związku:</b> W związku";
                            }else{
                                echo "<b>Status związku:</b> Singiel";
                            }
                        ?>
                </article>
               </section>
            </section>
            <section class = "Posts">
               <h1>Edytuj profil</h1>
               <form class = "form" method="POST" action="../scripts/php/editprof.php">
                    <label class = "label">Hasło <br/><input type = "password" id = "pass1" name = "pass" class = "form__input" placeholder="Haslo" minlength = "9" required/></label><br/><br/>
                    <label class = "label">Powtórz Hasło <br/><input type = "password" id = "pass2" name = "pass2" class = "form__input" placeholder="Haslo" minlength = "9" required/></label><br/><br/>
                    <label>Pokaż Hasła<input type = "checkbox" id = "check"/></label>
                    <?php
                        if(isset($_SESSION['e_pass'])){
                        echo '<span style = "color:red">'.$_SESSION['e_pass'].'</span>';
                        unset($_SESSION['e_pass']);
                        }
                    ?><br/>
                    <label class = "label">Email<br/><input type = "email" name = "email" class = "form__input"  placeholder="Email" required/></label><br/><br/>
                    <?php
                        if(isset($_SESSION['e_mail'])){
                        echo '<span style = "color:red">'.$_SESSION['e_mail'].'</span>';
                        unset($_SESSION['e_mail']);
                        }
                    ?><br/>
                    <section class = "section">
                        <input type = "text" name = "name" class = "form__input" placeholder="Imię" required/><br/>
                        <input type = "text" name = "surname" style = "margin-left: 2px" class = "form__input surname" placeholder= "Nazwisko" required/>
                        <?php
                        if(isset($_SESSION['e_name'])){
                        echo '<span style = "color:red">'.$_SESSION['e_name'].'</span>';
                        unset($_SESSION['e_name']);
                        }
                    ?><br/>
                    </section><br/><br/>
                    <section class = "section">
                        <input type = "number" name = "age" class = "section__input" placeholder="Wiek" required/>
                        <label class="section__label">W związku &nbsp;<input type="radio" name="status" value="Married"></label>
                        <label class="section__label">Singiel &nbsp;<input type="radio" name="status" value="single"></label>
                        <?php
                            if(isset($_SESSION['e_age'])){
                            echo '<span style = "color:red">'.$_SESSION['e_age'].'</span>';
                            unset($_SESSION['e_age']);
                            }
                        ?><br/>
                        <?php
                            if(isset($_SESSION['e_stat'])){
                            echo '<span style = "color:red">'.$_SESSION['e_stat'].'</span>';
                            unset($_SESSION['e_stat']);
                            }
                        ?><br/>
                    </section>
                    <br/>
                    <input type = "hidden" value = "registr"/>
                    <input type = "submit" value = "edytuj profil" class = "submit"/>
                    <?php
                        if(isset($_SESSION['e_serv'])){
                        echo $_SESSION['e_serv'];
                        unset($_SESSION['e_serv']);
                        }
                    ?>
                </form>
            </section>
            

        </main>

        <script src="../scripts/js/sidenav.js"></script>
        <script src="../scripts/js/showpass.js"></script>
    </body>
</html>