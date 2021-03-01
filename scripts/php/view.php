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


function login($login, $pass){
    $login = htmlentities($login, ENT_HTML5, "UTF-8");
    $pass = htmlentities($pass, ENT_HTML5, "UTF-8");
    try{
        require_once "../../includes/connect.php";
        $db = new PDO($db_dsn, $db_user, $db_pass);
        $sql = "SELECT * FROM users WHERE user = ?";
        $prepared = $db->prepare($sql);
        $prepared->bindParam(1, $login, PDO::PARAM_STR);
        $prepared->execute();
        if($prepared->rowCount() === 0){
            return "Nieprawidłowy login lub hasło";
        }else{
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
            if(!password_verify($result['pass'], $pass)){
                return "Nieprawidłowy login lub hasło";
            }else{
                $return = $result;
                
                return $return;

            }
        }
        $db = NULL;
    }catch(PDOException $e){
        echo $e;
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

    if (!isset($_POST['ToS'])){
        $isOK=false;
        $_SESSION['e_ToS']="Potwierdź akceptację regulaminu!";
    }

    $sekret = "6LczE2caAAAAAF_2y-t-HFJPqkI2Rkrq4yijQ8nY";
    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
    $odpowiedz = json_decode($sprawdz);
            
    if ($odpowiedz->success==false){
        $isOK=false;
        $_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
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

            $db = new PDO($db_dsn, $db_user, $db_pass);
            $sql1 = "SELECT `id` FROM users WHERE user = ?";
            $prepared = $db->prepare($sql1);
            $prepared->bindParam(1, $login, PDO::PARAM_STR );
            $prepared->execute();
            if($prepared->rowCount() > 0){
                $_SESSION['e_login'] = "Login zajęty";
            }else{
                $sql2 = "SELECT `id` FROM users WHERE email = ? ";
                $prepared2 = $db->prepare($sql2);
                $prepared2->bindParam(1, $emailS, PDO::PARAM_STR );
                $prepared2->execute();
                if($prepared2->rowCount() > 0){
                    $_SESSION['e_mail']="Email Zajęty";
                }else{
                    $hashed = password_hash($pass1, PASSWORD_DEFAULT);
                    $sql3 = "INSERT INTO users VALUES(?,?,?,?,?,?,?,?,?)";
                    $prepared3 = $db->prepare($sql3);
                    $prepared3->bindParam(1,NULL,PDO::PARAM_NULL);
                    $prepared3->bindParam(2,$login,PDO::PARAM_STR);
                    $prepared3->bindParam(3,$hashed,PDO::PARAM_STR);
                    $prepared3->bindParam(4,$emailS,PDO::PARAM_STR);
                    $prepared3->bindParam(5,$name,PDO::PARAM_STR);
                    $prepared3->bindParam(6,$surname,PDO::PARAM_STR);
                    $prepared3->bindParam(7," ", PDO::PARAM_STR);
                    $prepared->execute();
                    return true;
                }
            }
            $db= NULL;
        }catch(PDOException $e){
            return $e;
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
            require_once "../../includes/connect.php";
            $db = new PDO($db_dsn, $db_user, $db_pass);
            $query = "SELECT * FROM posts WHERE whoPosted = ?";
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



