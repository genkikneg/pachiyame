<?php
    ini_set('session.gc_maxlifetime', 1800);    //セッションの有効期限
    session_set_cookie_params(1800);           //クッキーの有効期限
    session_start();

    error_log('PHPSESSID: ' . session_id());
    error_log('SESSION: ' . print_r($_SESSION, true));

    //タイムアウト処理
    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800){
        session_unset();
        session_destroy();
        header('Location: login.html?timeout=1');
    }

    $_SESSION['last_activity'] = time();
?>