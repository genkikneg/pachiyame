<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require_once('../db/Database.php');

$http_method = $_SERVER['REQUEST_METHOD'];

if($http_method === 'GET'){
    //取得
    $tags = $_GET['tags'] ?? [];

    if (empty($tags)){
        //全検索
        //データベース関連
        $db = new Database();
        $query = 'SELECT * FROM trn_diary;';
        $select_results = $db->select($query);

        echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
        exit();
    }else{
        //タグでソート
        //データベース関連
        $db = new Database();
        //tagをダブルクウォートで囲みANDで並列させる処理
        $query = "SELECT * FROM trn_diary WHERE tags LIKE'%". implode("%'AND LIKE '%", $tags). "%';";
        $select_results = $db->select($query);

        echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
        exit();
    }
}elseif($http_method === 'POST'){
    //作成
    //JSONデータを受け取る
    $data = json_decode(file_get_contents('php://input'), true);

    $body = $data['body'] ?? '';
    $tags = $data['tags'] ?? [];


    //データベース関連
    $db = new Database();
    $query = "INSERT INTO trn_diary (body, tags) VALUES ('". $body ."', '". json_encode($tags, JSON_UNESCAPED_UNICODE). "');";
    $insert_result = $db->insert($query);

    echo json_encode($insert_result, JSON_UNESCAPED_UNICODE);

}elseif($http_method === 'PUT'){
    //更新
    exit();
}elseif($http_method === 'DELETE'){
    //削除
    exit();
}else{

}
?>