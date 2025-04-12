<?php
header('Content-Type: application/json');
require_once('../db/Database.php');

//JSONデータを受け取る
$data = json_decode(file_get_contents('php://input'), true);

$tags = $data['tags'] ?? [];

if(empty($tags)){
    //全検索
    //データベース関連
    $db = new Database();
    $query = 'SELECT * FROM trn_diary;';
    $select_results = $db->select($query);

    echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
}else{
    //タグでソート
    //データベース関連
    $db = new Database();
    //tagをダブルクウォートで囲みANDで並列させる処理
    $query = "SELECT * FROM trn_diary WHERE tag LIKE'%". implode("%'AND LIKE '%", $tags). "%';";
    $select_results = $db->select($query);

    echo json_encode($select_results, JSON_UNESCAPED_UNICODE);
}
?>