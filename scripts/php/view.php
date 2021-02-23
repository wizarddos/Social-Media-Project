<?php
/*
szybkie wyjaśnienie skrótów (piewrwszych liter zmiennych)
(nic) - atrubut klasy
C - parametr konstruktora
db - Zmienne bazodanowe

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

$db_dsn = "mysql:host=localhost;dbname=Social-Media";
$db_user = "root";
$db_pass = "";
function login(){}
function register(){}
function getPosts(){}

class User{
    public $email;
    public $id;
    public $age;
    public $name;
    public $surname;

    public function __construct($Cemail, $Cid, $Cage, $Cname, $Csurname )
    {
        $this->email = $Cemail;
        $this->id = $Cid;
        $this->age = $Cage;
        $this->name = $Cname;
        $this->surname = $Csurname;

    }

    public function editProfile(){

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



