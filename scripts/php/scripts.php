<?php
session_start();

/*
szybkie wyjaśnienie skrótów (piewrwszych liter zmiennych)
(nic) - atrubut klasy
C - parametr konstruktora
db - Zmienne bazodanowe
arg - Argument funkcji

*/


class DeafultViews{
    public function home(){
        if(isset($_SESSION['user'])){
            header("Location: views/strona-glowna");
        }else{
            header("Location: views/zaloguj-sie");
        }
    }
    public function login(){
        
    }

    public function register(){
        
    }

    public function settings(){

    }

    public function ToS(){

    }

    public function template(){

    }
}

function generate_header(){
    if(isset($_SESSION['user'])){
        echo<<<END
            <header>
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="http://localhost/Social-Media-Project/views/dodaj-post">Dodaj</a>
                    <a href="#">Znajomi</a>
                    <a href="http://localhost/Social-Media-Project/views/wiadomosci">wiadomości</a>
                    <br/>
                    <br/>
                    <a href = "http://localhost/Social-Media-Project/scripts/php/unlog.php">Wyloguj się</a>
                </div>
                    <button onclick="openNav()"><i class = "icon-menu"></i></button>
                    <section class = "headerSection"> 
                        <a href = "http://localhost/Social-Media-Project/views/strona-glowna" class = "headerA"><i class = "icon-home"></i></a>
                        <a href = "http://localhost/Social-Media-Project/views/dodaj-post" class = "headerA"><i class = "icon-plus"></i></a>
                        <a href = "http://localhost/Social-Media-Project/views/przyjaciele" class = "headerA"><i class = "icon-search"></i></a>
                        <a href = "http://localhost/Social-Media-Project/views/wiadomosci" class = "headerA"><i class = "icon-comment"></i></a>
                    </section>
                    <a href="http://localhost/Social-Media-Project/views/twoj-profil"><i class = "icon-user"></i></a>
            </header>
        END;
    }else{
        echo '<header style = ""><h1 style = "text-align: center"><a href = "../views/homepages/unloged.php">Zaloguj się</a><br/></h1></header>';
    }
}

function login($login, $pass){
    try{
        $slogin = htmlentities($login, ENT_HTML5, "UTF-8");
        require_once "../../includes/connect.php";
        global $db_dsn, $db_user, $db_pass;
        $db = new PDO($db_dsn, $db_user, $db_pass);
        $sql = "SELECT * FROM `users` WHERE `user` = ?";
        $query1 = $db->prepare($sql);
        $query1->bindParam(1, $slogin, PDO::PARAM_STR);
        $query1->execute();
        $result = $query1->fetch(PDO::FETCH_ASSOC);
        if($query1->rowCount() > 0){
            if(password_verify($pass, $result['pass'])){
                return $result;
            }else{
                $_SESSION['err'] = "Nieprawidłowy login lub hasło";
                return false;
            }
        }else{
            $_SESSION['err'] = "Nieprawidłowy login lub hasło";
            return false;
        }

    }catch(PDOException $e){
        $_SESSION['err'] = "BŁąd serwera";
    }
}
    
function register($arg_login, $arg_pass, $arg_pass2, $arg_email, $arg_age, $arg_status, $arg_name, $arg_surname){
    $login = $arg_login;
    $email = $arg_email;
    $pass1 = $arg_pass;
    $pass2 = $arg_pass2;
    $age = $arg_age;
    $status = $arg_status;
    $name = $arg_name;
    $surname = $arg_surname;
    $isOK = true;
    if(strlen($login)>20){
        $isOK = false;
        $_SESSION['e_login'] = "Login może posiadać max 20 znaków";
    }
    if(!ctype_alnum($login)){
        $isOK = false;
        $_SESSION['e_login'] = "Login może się składać tylko z liter i cyfr (baz polskich znaków)";
    }

    if (strlen($pass1)<9){
        $isOK=false;
        $_SESSION['e_pass']="Hasło musi posiadać min. 9 znaków";
    }
            
    if ($pass1!=$pass2){
        $isOK=false;
        $_SESSION['e_pass']="Podane hasła nie są identyczne!";
    }	

    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL)==false) || ($emailS!=$email)){
        $isOK=false;
        $_SESSION['e_mail']="Podaj poprawny adres e-mail!";
    }


    $sekret = "6LczE2caAAAAAF_2y-t-HFJPqkI2Rkrq4yijQ8nY";
    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
    $odpowiedz = json_decode($sprawdz);
            
    if ($odpowiedz->success==false){
        $isOK=false;
        $_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
    }

    if(!is_numeric($arg_age)){
        $isOK = false;
        $_SESSION['e_age'] = "wiek musi być liczbą";
    }

    switch($arg_status){
        case "single":
        case "maried": break;

        deafult: $_SESSION['e_stat'] = "zły status związku";
    }

    if(!is_string($arg_name)){  
        $_SESSION['e_name'] = "Imię musi być ciągiem znakowym";
        $isOK = false;
    }

    if(!is_string($arg_surname)){  
        $_SESSION['e_name'] = "Nazwisko musi być ciągiem znakowym";
        $isOK = false;
    }


    $status = htmlentities($status, ENT_HTML5, "UTF-8");
    $age = htmlentities($age, ENT_HTML5, "UTF-8");
    $name = htmlentities($name, ENT_HTML5, "UTF-8");
    $surname = htmlentities($surname, ENT_HTML5, "UTF-8");
    if(!$isOK){
        return false;
    }else{
        try{
            require_once "../../includes/connect.php";
            global $db_dsn, $db_user, $db_pass;
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $sql1 = "SELECT `id` FROM users WHERE user = ?";
            $prepared = $db->prepare($sql1);
            $prepared->bindParam(1, $login, PDO::PARAM_STR );
            $prepared->execute();
            if($prepared->rowCount() > 0){
                $_SESSION['e_login'] = "Login zajęty";
                return false;
            }else{
                $empty = "";
                $sql2 = "SELECT `id` FROM users WHERE email = ? ";
                $prepared2 = $db->prepare($sql2);
                $prepared2->bindParam(1, $emailS, PDO::PARAM_STR);
                $prepared2->execute();
                if($prepared2->rowCount() > 0){
                    $_SESSION['e_mail']="Email Zajęty";
                    return false;
                }else{
                    $hashed = password_hash($pass1, PASSWORD_DEFAULT);
                    $sql3 = "INSERT INTO users VALUES(:id, :user, :pass, :email, :imie, :surname, :age, :couple, :friends, :pfp)";
                    $prepared3 = $db->prepare($sql3);
                    $null = NULL;
                    $friends = " ";
                    $prepared3->bindParam(":id", $null);
                    $prepared3->bindParam(":user", $login);
                    $prepared3->bindParam(":pass", $hashed);
                    $prepared3->bindParam(":email", $emailS);
                    $prepared3->bindParam(":imie", $name);
                    $prepared3->bindParam(":surname", $surname);
                    $prepared3->bindParam(":age", $age);
                    $prepared3->bindParam(":couple", $status);
                    $prepared3->bindParam(":friends", $friends);
                    $prepared3->bindParam(":pfp", $empty);
                    $prepared3->execute();
                    return true;
                }
            }
            $db= NULL;
        }catch(PDOException $e){
            $_SESSION['e_serv'] = $e;
            return false;
            
        }
    }
}
class User{
    public $email;
    public $id;
    public $age;
    public $name;
    public $surname;
    public $status;

    public function __construct($Cemail, $Cid, $Cage, $Cname, $Csurname, $Cstatus ){
        $this->email = $Cemail;
        $this->id = $Cid;
        $this->age = $Cage;
        $this->name = $Cname;
        $this->surname = $Csurname;
        $this->status = $Cstatus;

    }

    public function getLogin(){
        try{
            global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $sql = "SELECT user FROM users WHERE id = ?";
            $prepared = $db->prepare($sql);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            $assoc = $prepared->fetch(PDO::FETCH_ASSOC);
            $db = NULL;

            return $assoc['user'];
        }catch(PDOException $e){
            echo "error detected";
        }
    }

    public function editProfile($arg_pass, $arg_pass2, $arg_email, $arg_age, $arg_status, $arg_name, $arg_surname){
        $email = $arg_email;
        $pass1 = $arg_pass;
        $pass2 = $arg_pass2;
        $age = $arg_age;
        $status = $arg_status;
        $name = $arg_name;
        $surname = $arg_surname;
        $isGood = true; 
    
        if (strlen($pass1)<9){
            $isGood=false;
            $_SESSION['e_pass']="Hasło musi posiadać min. 9 znaków";
        }
                
        if ($pass1!=$pass2){
            $isGood=false;
            $_SESSION['e_pass']="Podane hasła nie są identyczne!";
        }	
    
        $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailS, FILTER_VALIDATE_EMAIL)==false) || ($emailS!=$email)){
            $isGood=false;
            $_SESSION['e_mail']="Podaj poprawny adres e-mail!";
        }
        $status = htmlentities($status, ENT_HTML5, "UTF-8");
        $age = htmlentities($age, ENT_HTML5, "UTF-8");
        $name = htmlentities($name, ENT_HTML5, "UTF-8");
        $surname = htmlentities($surname, ENT_HTML5, "UTF-8");
        switch($status){
            case "single":
            case "married":
                break;
            default: $_SESSION['e_status'] = "Zły status"; $isGood = false;
        }
        if(!$isGood){
            return false;
        }else{
            try{
                require_once "../../includes/connect.php";
                $db = new PDO($db_dsn, $db_user, $db_pass);
                $sql1 = "SELECT `email` FROM users WHERE email = ?";
                $prepared = $db->prepare($sql1);
                $prepared->bindParam(1, $emailS, PDO::PARAM_STR);
                $prepared->execute();
                if($prepared->rowCount() > 0){
                    $_SESSION['e_mail'] = "Email zajęty";
                    return false;
                }else{
                    $hashed = password_hash($pass1, PASSWORD_DEFAULT);
                    $sql2 = "UPDATE users SET pass = :pass, email = :mail, name = :nam, surname = :sur, age = :age, status = :stat WHERE id = :id  ";
                    $prepared2 = $db->prepare($sql2);
                    $prepared2->bindParam(':pass', $hashed);
                    $prepared2->bindParam(':mail', $emailS);
                    $prepared2->bindParam(':nam', $name);
                    $prepared2->bindParam(':sur', $surname);
                    $prepared2->bindParam(':age', $age);
                    $prepared2->bindParam(':stat', $status);
                    $prepared2->bindParam(':id', $this->id);
                    $prepared2->execute();
                    return true;
                }
                $db = NULL;
            }catch(PDOException $e){
                echo $e;
            }
        }
    }



    public function showFriends(){
        try{
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT `friends` FROM users WHERE id = ?";
            $prepared = $db->prepare($query);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            if($prepared->rowCount() != 0){
                return $prepared->fetch(PDO::FETCH_ASSOC);
            }else{
                return "Nie znaleziono żadnych wyników";
            }
            $db = NULL;
        }catch(PDOException $e){
            echo $e;
        }
    }

    public function showThinks(){
        try{
            global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $sql = "SELECT friends FROM users WHERE id = ?";
            $prepared = $db->prepare($sql);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            $assoc = $prepared->fetch(PDO::FETCH_ASSOC);
            $db = NULL;

            //-----------------------------------------------//

            $friends = $assoc['friends'];
            
            if($friends != " " ){
                $friends = $friends.", ".$this->id;
                $db2 = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if($db2->connect_errno != 0){
                    throw new mysqli_sql_exception($db2->connect_error);
                }
                if(!$result = $db2->query("SELECT * FROM thinks WHERE WhoPosted IN($friends) ORDER BY WhenPosted DESC")){
                    throw new mysqli_sql_exception($db2->error);
                }
                $row = $result->fetch_assoc();
                foreach($result as $row){
                    echo '<h3>'.$row['title']."</h3>";
                    echo $row['content']."<br/><br/>";
                    
                }
                $db2->close();
            }else{
                echo "<br/>Nie masz dodanych Przyjaciół <br/> więc nie ma innych Myśli niż twoje<br/>";
                echo '<br/><a href = "../znajdz-przyjaciol" >Szukaj Przyjaciół</a>';
            }
        }catch(PDOException $e){
            echo "error detected";
        }catch(mysqli_sql_exception $e){
            echo $e;
        }
    }

    public function showPhotos(){
        try{
            global $db_dsn, $db_user, $db_pass, $db_host, $db_name;
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $sql = "SELECT friends FROM users WHERE id = ?";
            $prepared = $db->prepare($sql);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            $assoc = $prepared->fetch(PDO::FETCH_ASSOC);
            $db = NULL;

            //-----------------------------------------------//

            $friends = $assoc['friends'];
            
            if($friends != " " ){
                $friends = $friends.", ".$this->id;
                $db2 = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if($db2->connect_errno != 0){
                    throw new mysqli_sql_exception($db2->connect_error);
                }
                if(!$result = $db2->query("SELECT * FROM photos WHERE WhoPosted IN($friends)")){
                    throw new mysqli_sql_exception($db2->error);
                }
                $row = $result->fetch_assoc();
                $i = 0;
                foreach($result as $row){
                    echo '<div class="photo">';
                    echo " <h2>".$row['title']."</h2>";
                    echo ' <img src="../img/posts/'.$row['Pname'].'" alt="" width="40%"/>';
                    echo '<section class = "post-section"><p>'.$row['description'].'</p> &nbsp';
                    echo '<button class = "like" ><i class = "icon-heart-empty" onclick = "toogleLike(this,'.$row['id'].')"  id = "'.$i.'"></i></button></section>';
                    echo 'Likeów: <span id = "'.$row['id'].'">'.$row['likes'].'</span><br/>';
                    echo '<input type = "hidden" id = "'.$i.'" value = "'.$row['id'].'"/></div>';
                    $i+1;
                }
                echo "<br/><br/>To tyle! Więcej postów nie ma";
                $db2->close();
            }else{
                echo "nie ma żadnych postów<br/>";
                echo '<br/><a href = "../znajdz-przyjaciol" >Szukaj Przyjaciół</a>';
            }
        }catch(PDOException $e){
            echo "error detected";
        }catch(mysqli_sql_exception $e){
            echo $e;
        }
    }

    public function sendMessage($arg_towho, $arg_content){
        $to_who = $arg_towho;
        $from_who = $this->getLogin();
        $content = $arg_content;
        $content = htmlentities($content, ENT_HTML5, "UTF-8");
        $to_who = htmlentities($to_who, ENT_HTML5, "UTF-8");
        if($this->getLogin() != $to_who){
            try{
                require_once "../../includes/connect.php";
                global $db_dsn, $db_user, $db_pass;
                $db = new PDO($db_dsn, $db_user, $db_pass);
                $Select1 = "SELECT `id` FROM users WHERE user = ?";
                $prepared = $db->prepare($Select1);
                $prepared->bindParam(1,$to_who, PDO::PARAM_STR);
                $prepared->execute();
                $result = $prepared->fetch(PDO::FETCH_ASSOC);
                if($prepared->rowCount() == 0){
                    $_SESSION['e_mes'] = "nie ma takiego usera";
                    return false;
                }else{
                    $to_who =  $result['id'];
                    $NULL = NULL;
                    $Insert1 = "INSERT INTO messages VALUES(:id, :cont, :frm, :tw , :dat)";
                    $prepared = $db->prepare($Insert1);
                    $prepared->bindParam(":id", $NULL, PDO::PARAM_NULL);
                    $prepared->bindParam(":cont", $content, PDO::PARAM_STR);
                    $prepared->bindParam(":frm", $to_who, PDO::PARAM_INT);
                    $prepared->bindParam(":tw", $from_who, PDO::PARAM_STR);
                    $prepared->bindParam(":dat", date("Y-m-d"), PDO::PARAM_STR);
                    $prepared->execute();
                    $_SESSION['e_mes'] = "Pomyślnie wysłano wiadomość";
                    return true;
                }  
                $db = NULL;
            }catch(PDOException $e){
                $_SESSION['e_mes'] = $e;
                return false;
            }
        }else{
            $_SESSION['e_mes'] = "nie można wysłać wiadomości do samego siebie";
            return false;
        }
    }
    
}


