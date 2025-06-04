<?php
require_once('session_congig.php');
require_once('config.php');

class Database{
    public $db;
    
    //コンストラクタ
    public function __construct(){
        $this->db = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

        return $this->connect($this->db);
    }
    //デストラクタ
    public function __destruct(){
        $this->db->close();
    }

    //DBとのコネクションを確認する関数
    public function connect($db){
        if($db->connect_error){
            echo $db->connect_error;
            exit();
        }else{
            return true;
        }
    }
    //DBのクエリーを処理する関数
    public function query($query){
        return $this->db->query($query);
    }
    //DBのセレクトをする関数
    public function select($query){
        $results = array();
        if($result = $this->query($query)){

            while($rows = $result->fetch_assoc()){
                $results[] = $rows;
            }

            return $results;
        }else{
            return false;
        }
    }
    //インサートする関数
    public function insert($query){
        return $this->query($query);
    }
    //アップデートする関数
    public function update($query){
        return $this->query($query);
    }
    //デリートする関数
    public function delete($query){
        return $this->query($query);
    }
}
?>