<?php

//ログインフォーム
//ページ作成時参考リンク:https://www.spiral-platform.co.jp/article/member/503/#modal-close

//エラーメッセージを空に
$err_msg ="";

//submitが押されたときの処理
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    //データがわたってきたときの処理
    try{
        $db = new PDD('mysql:host= localhost ', dbname='データベース名', 'ユーザー名', 'パスワード');
        $sql = 'select count(*) from users(/*認証テーブル*/ ) where username = ? and password = ?';
        $stmt = $db -> prepare($sql);
        $stmt -> execute(arry($username, $password));
        $result = $stmt ->fetch();
        $stmt = nyll;
        $db = null;

        //ログイン認証ができたときの処理
        if($result[0] != 0){
            header('Location: ../../frontend/index.html');
            exit;
        }
        //アカウントが間違っていた時の処理
        else{
            $err_msg ="アカウント情報が間違っています";
        }
    }
        //データが渡ってこなかったときの処理
    catch(PDOExeption $e){
        echo $r ->getMessage();
        exit;
    }
}
?>
