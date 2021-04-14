<?php
// 予想時間（ログイン認証画面）：30mi
// かかった時間：20mi

//================================
// ログイン認証・自動ログアウト
//================================
// ログインしている場合
if(!empty($_SESSION['login_date'])) {
    // 現在日時が最終日時＋有効期限を超えている場合
    if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
        debug('ログイン有効期限切れです。');

        session_destroy();
        header("Location:login.php");
        // 現在日時が最終日時＋有効期限を超えていない場合
    } else {
        debug('ログイン有効期限内です。');
        $_SESSION['login_date'] = time();

        // 現在ページがlogin.phpの場合
        if(basename($_SERVER['PHP_SELF']) === 'login.php'){
            debug('マイページへ遷移します。');
            header("Location:mypage.php"); // マイページへ
        }
    }

    // ログインしていない場合
}else{
    // 未ログイン
    if(basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header("Location:login.php");
    }
}
