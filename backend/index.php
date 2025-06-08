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
        $stmt = $db->prepare("INSERT INTO mst_users (username, password) VALUE (?, ?);");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $db->insert($stmt);
        if($result){
            header('Location: ../frontend/index.html');
            $stmt = $db->prepare( "SELECT id FROM mst_users WHERE username= ? AND password= ? ;");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $user_id = $db->select($stmt);
        }else{
            //エラーを返す
            header('Location: ../frontend/login.html');
            exit();
        }
    }else{
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user_id = '';

        $db = new Database();
        $stmt = $db->prepare("SELECT id, password FROM mst_users WHERE username= ? ;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $db->select($stmt);
        
        if(password_verify($password, $result[0]['password'])){
            $user_id = $result[0]['id'];
            //セッション
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;

            header('Location: ../frontend/index.html');
            exit();
        }else{
            //エラーを返す
            header('Location: ../frontend/login.html');
            exit();
        }
    }

?>
