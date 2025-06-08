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
        $query = "SELECT * FROM trn_diary WHERE user_id ='{$user_id}' ORDER BY insert_datetime DESC;";
        $select_results = $db->select($query);

        echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
        exit();
    }else{
        //タグでソート
        //データベース関連
        $db = new Database();
        $query = "SELECT * FROM trn_diary WHERE tag = '{$tag}' AND user_id ='{$user_id}' ORDER BY insert_datetime DESC;";
        $select_results = $db->select($query);

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
    $query = "INSERT INTO trn_diary (body, tag, user_id) VALUES ('{$body}', '{$tag}', '{$user_id}');";
    $insert_result = $db->insert($query);

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
    $query = "UPDATE trn_diary SET body = '{$body}', tag = '{$tag}' WHERE user_id = {$user_id} AND id = {$article_id};";
    $update_result = $db->update($query);

    echo json_encode($update_result, JSON_UNESCAPED_UNICODE);
    exit();
}elseif($http_method === 'DELETE'){
    //削除
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = $_SESSION['user_id'];
    $article_id = $data['article_id'] ?? '';

    //データベース関連
    $db = new Database();
    $query = "DELETE FROM trn_diary WHERE user_id = '{$user_id}' AND id = '{$article_id}';";
    $delete_result = $db->delete($query);

    echo json_encode($delete_result, JSON_UNESCAPED_UNICODE);
    exit();
}else{

}
?>