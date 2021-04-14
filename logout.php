<?php

// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('ログアウト画面');
debug('==============================================');

// ブラウザ内のセッションを削除
$_SESSION = array();
// ブラウザのセッションIDを破棄
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time()-42000, '/');
}
// サーバー側のセッション削除
session_destroy();
debug('セッションの中身'.print_r($_SESSION, true));

// ログインページへ
header('Location:login.php');