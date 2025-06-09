<?php
    require_once('api/session_config.php');
    session_unset();
    session_destroy();
    
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);
    exit();
?>