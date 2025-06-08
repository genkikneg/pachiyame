<?php
require_once('session_config.php');
header("Access-Control-Allow-Origin: https://misoon.net");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials: true"); 
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require_once('../db/Database.php');

$http_method = $_SERVER['REQUEST_METHOD'];

if($http_method === 'GET'){
    //取得
    $tag = $_GET['tag'] ?? '';
    $user_id = $_SESSION['user_id'];

    if (empty($tag)){
        //全検索
        //データベース関連
        $db = new Database();
        $stmt = $db->prepare("SELECT * FROM trn_diary WHERE user_id = ? ORDER BY insert_datetime DESC;");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $select_results = $db->select($stmt);

        echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
        exit();
    }else{
        //タグでソート
        //データベース関連
        $db = new Database();
        $stmt = $db->prepare("SELECT * FROM trn_diary WHERE tag = ? AND user_id =? ORDER BY insert_datetime DESC;");
        $stmt->bind_param("si", $tag, $user_id);
        $stmt->execute();
        $select_results = $db->select($stmt);

        echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
        exit();
    }
}elseif($http_method === 'POST'){
    //作成
    //JSONデータを受け取る
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user_id'] ?? '';
    $body = $data['body'] ?? '';
    $tag = $data['tag'] ?? '';


    //データベース関連
    $db = new Database();
    $stmt = $db->prepare("INSERT INTO trn_diary (body, tag, user_id) VALUES (?, ?, ?);");
    $stmt->bind_param("ssi", $body, $tag, $user_id);
    $stmt->execute();
    $insert_result = $db->insert($stmt);

    echo json_encode($insert_result, JSON_UNESCAPED_UNICODE);

    exit();
}elseif($http_method === 'PUT'){
    //更新
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user_id'] ?? '';
    $body = $data['body'] ?? '';
    $tag = $data['tag'] ?? '';
    $article_id = $data['article_id'] ?? '';

    //データベース関連
    $db = new Database();
    $stmt = $db->prepare("UPDATE trn_diary SET body = ?, tag = ? WHERE user_id = ? AND id = ?;");
    $stmt->bind_param("ssii", $body, $tag, $user_id, $article_id);
    $stmt->execute();
    $update_result = $db->update($stmt);

    echo json_encode($update_result, JSON_UNESCAPED_UNICODE);
    exit();
}elseif($http_method === 'DELETE'){
    //削除
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user_id'];
    $article_id = $data['article_id'] ?? '';

    //データベース関連
    $db = new Database();
    $stmt = $db->prepare("DELETE FROM trn_diary WHERE user_id = ? AND id = ?;");
    $stmt->bind_param("ii", $user_id, $article_id);
    $stmt->execute();
    $delete_result = $db->delete($stmt);

    echo json_encode($delete_result, JSON_UNESCAPED_UNICODE);
    exit();
}else{

}
?>