<?php
session_start();
if(!isset($_SESSION['user'])){
    exit();
}
require_once "../../includes/connect.php";
try{
    $db = new PDO($db_dsn, $db_user, $db_pass);


    $Select1 = "SELECT `friends` FROM users WHERE id = ? ";
    $prepared = $db->prepare($Select1);
    $prepared->bindParam(1,$_SESSION['user']->id, PDO::PARAM_INT);
    $prepared->execute();
    $result1 = $prepared->fetch(PDO::FETCH_ASSOC);

    $friendIds = $result['friends'].", ".$_SESSION['user']->id;

    $Select2 = "SELECT * FROM photos WHERE WhoPosted IN($friendIds)";
    
    $result = $db->query($Select2, PDO::FETCH_ASSOC);
    if($result->rowCount() > 0){
        $assoc['rows'] = [];
        foreach($result as $resultassoc){
            $assoc['rows'][] = $resultassoc;
        }
        echo json_encode($assoc);
    }else{
        
    }
    
    
}catch(PDOException $e){
    
}
