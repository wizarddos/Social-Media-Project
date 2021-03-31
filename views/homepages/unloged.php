<?php session_start();
  if(isset($_SESSION['user'])){
    header("Location: loged.php");
  }
?>
<!DOCTYPE html>
<html lang = "pl">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset = "UTF-8"/>
  <link rel="stylesheet" href="../../styles/login.css"/>
  <link rel="icon" type="image/ico" href="../../img/deafultimg/favicon/favicon.ico">
  <title>PostIt! - Zaloguj się</title>
  </head>
<body>



<div class="container">
  <form action="../../scripts/php/login.php" method="POST">
    <div class="row">
      <h2 style="text-align:center">Zaloguj się</h2>
      <div class="vl">
        <span class="vl-innertext">lub</span>
      </div>

      <div class="col">
        <a href="#" class="fb btn">
          <i class="fa fa-facebook fa-fw"></i> zaloguj się Facebookiem
        </a>
        <a href="#" class="twitter btn">
          <i class="fa fa-twitter fa-fw"></i> zaloguj się Twitterrem
        </a>
        <a href="#" class="google btn"><i class="fa fa-google fa-fw">
          </i> zaloguj się Google
        </a>
      </div>

      <div class="col">
        <div class="hide-md-lg">
          <p>lub naszym kontem</p>
        </div>

        <input type="text" name="login" placeholder="login" class = "logintext" required>
        <input type="password" name="pass" placeholder="Hasło" id = "pass" required><br/>
        <label><input type = "checkbox" id = "showpass"/> Pokaż hasło </label>
        <input type="submit" value="zaloguj się">
        <?php 
          if(isset($_SESSION['err'])){
            echo '<span style = "color:red">'.$_SESSION['err']."</span>";
            unset($_SESSION['err']);
          }
        ?>
      </div>
      
    </div>
  </form>
</div>

<div class="bottom-container">
  <div class="row">
    <div class="col">
      <a href="../register.php" style="color:white" class="btn">Nie masz konta?</a>
    </div>
    <div class="col">
      <a href="#" style="color:white" class="btn">Zapomniałeś Hasła?</a>
    </div>
  </div>
</div>
<script src="../../scripts/js/showpass.js"></script>
</body>
</html>
