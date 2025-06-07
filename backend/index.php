<?php
    require_once('api/session_config.php');
    require_once('db/Database.php');
    //ログインフォーム

    //submitが押されたときの処理
    if($_POST['key'] === 'regist'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_id = '';

        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        $db = new Database();
        $sql = 
        "
        INSERT INTO
            mst_users
            (username, password)
        VALUE
            ('{$username}', '{$hashed_pass}')
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
                password='{$hashed_pass}'
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
            id, password
        FROM
            mst_users
        WHERE
            username='{$username}'
        ;
        ";
        $result = $db->select($sql);
        
        if(password_verify($password, $result[0]['password'])){
            $user_id = $result[0]['id'];
            //セッション
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;

            header('Location: ../frontend/index.html');
            exit();
        }else{
            //エラーを返す
            http_response_code(500);
            exit();
        }
    }

?>
