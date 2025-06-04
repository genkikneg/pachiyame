<?php
    require_once('api/session_config.php');
    require_once('db/Database.php');
    //ログインフォーム
    
    session_start();

    //submitが押されたときの処理
    if($_POST['key'] === 'regist'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_id = '';

        $db = new Database();
        $sql = 
        "
        INSERT INTO
            mst_users
            (username, password)
        VALUE
            ('{$username}', '{$password}')
        ;
        ";
        $result = $db->insert($sql);
        if($result){
            header('Location: ../frontend/index.html');
            $sql = 
            "
            SELECT
                id
            FROM
                mst_users
            WHERE
                username='{$username}' AND
                password='{$password}'
            ;
            ";
            $user_id = $db->select($sql);
        }else{
            //エラーを返す
            http_response_code(500);
            exit();
        }
    }else{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_id = '';

        $db = new Database();
        $sql = 
        "
        SELECT
            id
        FROM
            mst_users
        WHERE
            username='{$username}' AND
            password='{$password}'
        ;
        ";
        $result = $db->select($sql);
        if($result){
            header('Location: ../frontend/index.html');
            $user_id = $result;
        }else{
            //エラーを返す
            http_response_code(500);
            exit();
        }
        //セッション
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
    }

?>
