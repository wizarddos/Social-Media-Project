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
        if($_SESSION['loged']){
            require_once "../../views/homepages/loged.php";
        }else{
            require_once "../../views/homepages/unloged.html";
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
                    <a href="#">zdjęcia</a>
                    <a href="#">Dodaj</a>
                    <a href="#">Myśli</a>
                    <a href="#">Znajomi</a>
                    <a href="#">Grupy</a>
                    <a href="#">wiadomości</a>
                    <br/>
                    <br/>
                    <a href = "http://post.it/Social-Media-Project/scripts/php/unlog.php">Wyloguj się</a>
                </div>
                    <button onclick="openNav()"><i class = "icon-menu"></i></button>
                    <section class = "headerSection"> 
                        <a href = "http://post.it/Social-Media-Project/views/homepages/loged.php" class = "headerA"><i class = "icon-home"></i></a>
                        <a href = "" class = "headerA"><i class = "icon-plus"></i></a>
                        <a href = "#" class = "headerA"><i class = "icon-search"></i></a>
                        <a href = "" class = "headerA"><i class = "icon-comment"></i></a>
                    </section>
                    <a href="#"><i class = "icon-user"></i></a>
            </header>
        END;
    }else{
        echo '<header style = ""><h1 style = "text-align: center"><a href = "../views/homepages/unloged.php">Zaloguj się</a><br/></h1></header>';
    }
}

function login($login, $pass){
    $login = htmlentities($login, ENT_HTML5, "UTF-8");
    try{
        require_once "../../includes/connect.php";
        global $db_dsn, $db_user, $db_pass;
        $db = new PDO($db_dsn, $db_user, $db_pass);
        $sql = "SELECT * FROM users WHERE user = ?";
        $prepared = $db->prepare($sql);
        $prepared->bindParam(1, $login, PDO::PARAM_STR);
        $prepared->execute();
        if($prepared->rowCount() == 0){
            return "Nieprawidłowy login lub hasło";
        }else{
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
            if(password_verify($result['pass'], $pass)){
                return "Nieprawidłowy logi lub hasło";
            }else{
                return $result;
            }
        }
        $db = NULL;
    }catch(PDOException $e){
        $e = $e;
        return $e;
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
                $sql2 = "SELECT `id` FROM users WHERE email = ? ";
                $prepared2 = $db->prepare($sql2);
                $prepared2->bindParam(1, $emailS, PDO::PARAM_STR);
                $prepared2->execute();
                if($prepared2->rowCount() > 0){
                    $_SESSION['e_mail']="Email Zajęty";
                    return false;
                }else{
                    $hashed = password_hash($pass1, PASSWORD_DEFAULT);
                    $sql3 = "INSERT INTO users VALUES(:id, :user, :pass, :email, :imie, :surname, :age, :couple, :friends)";
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
    public $login;

    public function __construct($Cemail, $Cid, $Cage, $Cname, $Csurname, $Cstatus ){
        $this->email = $Cemail;
        $this->id = $Cid;
        $this->age = $Cage;
        $this->name = $Cname;
        $this->surname = $Csurname;
        $this->status = $Cstatus;

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
                $prepared->bindParam(1, $this->email, PDO::PARAM_STR);
                $prepared->execute();
                if($prepared->rowCount() > 0){
                    $_SESSION['e_mail'] = "Email zajęty";
                    return false;
                }else{
                    $hashed = password_hash($pass1, PASSWORD_DEFAULT);
                    $sql2 = "UPDATE users SET pass = ?, email = ?, name = ?, surname = ?, age = ?, status = ? WHERE id = ?  ";
                    $prepared2 = $db->prepare($sql2);
                    $prepared2->bindParam(1, $hashed, PDO::PARAM_STR);
                    $prepared2->bindParam(2, $emailS, PDO::PARAM_STR);
                    $prepared2->bindParam(3, $name, PDO::PARAM_STR);
                    $prepared2->bindParam(4, $surname, PDO::PARAM_STR);
                    $prepared2->bindParam(5, $age, PDO::PARAM_INT);
                    $prepared2->bindParam(6, $status, PDO::PARAM_STR);
                    $prepared2->bindParam(7, $this->id, PDO::PARAM_INT);
                    $prepared2->execute();
                    return true;
                }
                $db = NULL;
            }catch(PDOException $e){
                echo $e;
            }
        }
    }

    public function showProfile(){
        try{
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT * FROM users WHERE id = ?";
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

    public function showSendedMessages(){
        try{
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT * FROM messages WHERE fromWho = ?";
            $prepared = $db->prepare($query);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            if($prepared->rowCount() != 0){
                return $prepared->fetch(PDO::FETCH_ASSOC);
            }else{
                return "Nie znaleziono żadnych wyników";
            }
        }catch(PDOException $e){
            echo $e;
        }
    }

    public function showMessagesToYou(){
        try{
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT * FROM messages WHERE toWho = ?";
            $prepared = $db->prepare($query);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            if($prepared->rowCount() != 0){
                return $prepared->fetch(PDO::FETCH_ASSOC);
            }else{
                return "Nie znaleziono żadnych wyników";
            }
        }catch(PDOException $e){
            echo $e;
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
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT * FROM thinks WHERE whoPosted = ?";
            $prepared = $db->prepare($query);
            $prepared->bindParam(1, $this->id, PDO::PARAM_INT);
            $prepared->execute();
            if($prepared->rowCount() != 0){
                return $prepared->fetch(PDO::FETCH_ASSOC);
            }else{
                return "Nie znaleziono żadnych wyników";
            }
        }catch(PDOException $e){
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
                $db2 = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if($db2->connect_errno != 0){
                    throw new mysqli_sql_exception($db2->connect_error);
                }
                $friends = 1;
                if(!$result = $db2->query("SELECT * FROM photos WHERE WhoPosted IN($friends)")){
                    throw new mysqli_sql_exception($db2->error);
                }
                $row = $result->fetch_assoc();
                foreach($result as $row){
                    echo $row['title'];
                }
                $db2->close();
            }else{
                echo "Nie masz dodanych Przyjaciół <br/> więc nie ma żadnych postów<br/>";
                echo '<br/><a href = "../findFriends.php" >Szukaj Przyjaciół</a>';
            }
        }catch(PDOException $e){
            echo "error detected";
        }catch(mysqli_sql_exception $e){
            echo $e;
        }
    }

    public function sendMessage($arg_towho, $arg_content){
        $to_who = $arg_towho;
        $from_who = $this->login;
        $content = $arg_content;
        $content = htmlentities($content, ENT_HTML5, "UTF-8");
        $to_who = htmlentities($to_who, ENT_HTML5, "UTF-8");
        $from_who = htmlentities($from_who, ENT_HTML5, "UTF-8");
        if($this->login != $to_who){
            try{
                require_once "../../includes/connect.php";
                $db = new PDO($db_dsn, $db_user, $db_pass);
                $Select1 = "SELECT `id` FROM users WHERE user = ?";
                $prepared = $db->prepare($Select1);
                $prepared->bindParam(1,$to_who, PDO::PARAM_STR);
                $prepared->execute();
                if($prepared->rowCount() == 0){
                    $_SESSION['e_mes'] = "nie ma takiego usera";
                    return false;
                }else{
                    $Insert1 = "INSERT INTO messages VALUES(? ? ? ? ?)";
                    $prepared = $db->prepare($Insert1);
                    $prepared->bindParam(1, NULL, PDO::PARAM_NULL);
                    $prepared->bindParam(2, $from_who, PDO::PARAM_STR);
                    $prepared->bindParam(3, $to_who, PDO::PARAM_STR);
                    $prepared->bindParam(4, $content, PDO::PARAM_STR);
                    $prepared->bindParam(5, date("Y-m-d"), PDO::PARAM_STR);
                    $prepared->execute();
                    $_SESSION['e_mes'] = "Pomyślnie wysłano wiadomość";
                    return true;
                }  
                $db = NULL;
            }catch(PDOException $e){
                echo $e;
            }
        }else{
            $_SESSION['e_mes'] = "nie można wysłać wiadomości do samego siebie";
            return false;
        }
    }
    
    
}



