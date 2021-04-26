<?php session_start();
  if(isset($_SESSION['user'])){
    header("Location: homepages/loged.php");
  }
?>
<!DOCTYPE html>
<html lang = "pl">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset = "UTF-8"/>
    <link rel="icon" type="image/ico" href="../img/deafultimg/favicon/favicon.ico">
    <link rel = "stylesheet" href = "../styles/styles.css"/>
    <link rel = "stylesheet" href = "../styles/register.css"/>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>PostIt! - Zarejestruj się</title>
  </head>
  <body>
    <main>
      <h1>Zarejestruj się</h1>
      <br/>
      <br/>
      <form class = "form" method="POST" action="../scripts/php/register.php">
          <label class = "label">Login <br/><input type = "text" name = "login" class = "form__input" placeholder="Login" required/></label><br/><br/>
          <?php
            if(isset($_SESSION['e_login'])){
              echo '<span style = "color:red">'.$_SESSION['e_login'].'</span>';
              unset($_SESSION['e_login']);
            }
          ?><br/>
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
          <section>
            <input type = "text" name = "name" class = "section__input" placeholder="Imię" required/><br/>
            <input type = "text" name = "surname"  class = "section__input surname" placeholder= "Nazwisko" required/>
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
          <div class="g-recaptcha" data-sitekey="6LczE2caAAAAAPd85wWlVhHIJsMv1Z1a9uQ6iP1Z"></div>
          <br/>
          <input type = "hidden" value = "registr"/>
          <input type = "submit" value = "zarejestruj się" class = "submit"/>
          <?php
            if(isset($_SESSION['e_serv'])){
              echo '<span style = "color:red">'.$_SESSION['e_serv'].'</span>';
              unset($_SESSION['e_serv']);
            }
          ?>
        </form>
    </main>
    <script src = "../scripts/js/showpass.js"></script>
  </body>
</html>
