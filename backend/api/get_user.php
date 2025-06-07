<?php
    require_once('session_config.php');

    header("Access-Control-Allow-Origin: https://misoon.net");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Credentials: true"); 
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json');

    if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
        echo json_encode([
            'msg' => true,
            'user_id' => $_SESSION['user_id']
        ]);
    }else{
        echo json_encode(['msg' => false]);
    }
?>