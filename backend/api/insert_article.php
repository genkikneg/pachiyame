<?php
header('Content-Type: application/json');
require_once('../db/Database.php');

//JSONデータを受け取る
$data = json_decode(file_get_contents('php://input'), true);

$body = $data['body'] ?? '';
$tags = $data['tags'] ?? [];


//データベース関連
$db = new Database();
$query = "INSERT INTO trn_diary (body, tag) VALUES ('". $body ."', '". implode(',', $tags). "');";
$insert_result = $db->insert($query);

echo json_encode($insert_result);

?>