<?php
/*
szybkie wyjaśnienie skrótów (piewrwszych liter zmiennych)
(nic) - atrubut klasy
C - parametr konstruktora
db - Zmienne bazodanowe
arg - Argument funkcji

*/

class DeafultViews{
    public function home(){
        
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
                    $sql3 = "INSERT INTO users VALUES(?,?,?,?,?,?,?,?)";
                    $prepared3 = $db->prepare($sql3);
                    $prepared3->bindParam(1,NULL,PDO::PARAM_NULL);
                    $prepared3->bindParam(2,$login,PDO::PARAM_STR);
                    $prepared3->bindParam(3,$hashed,PDO::PARAM_STR);
                    $prepared3->bindParam(4,$emailS,PDO::PARAM_STR);
                    $prepared3->bindParam(5,$name,PDO::PARAM_STR);
                    $prepared3->bindParam(6,$surname,PDO::PARAM_STR);
                    $prepared->execute();
                    return true;
                }
            }
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

    public function __construct($Cemail, $Cid, $Cage, $Cname, $Csurname ){
        $this->email = $Cemail;
        $this->id = $Cid;
        $this->age = $Cage;
        $this->name = $Cname;
        $this->surname = $Csurname;

    }

    public function editProfile($arg_pass, $arg_pass2, $arg_email, $arg_age, $arg_status, $arg_name, $arg_surname){
        
    }

    public function showProfile(){

    }

    public function showMessages(){

    }

    public function showFriends(){

    }

    public function showThinks(){

    }

    public function showPhotos(){

    }

    public function sendMessage(){

    }
    
    
}



