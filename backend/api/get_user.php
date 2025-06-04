<?php
    require_once('session_config.php');

    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json');

    
    if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
        echo json_encode(['msg' => true]);
    }else{
        echo json_encode(['msg' => false]);
    }
?>