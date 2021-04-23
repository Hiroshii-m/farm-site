<?php
// 予想時間（退会機能）：1h
// かかった時間：1h13mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('退会画面');
debug('==============================================');

$u_id = $_SESSION['user_id'];

if(!empty($_POST)) {
    try {
        $dbh = dbConnect();
        $sql = 'UPDATE users SET `delete_flg` = 1 WHERE `id` = :u_id';
        $data = array(':u_id' => $u_id);
        $stmt = queryPost($dbh, $sql, $data);

        if(isset($stmt)) {
            // ブラウザ内のセッションを削除
            $_SESSION = array();
            // ブラウザのセッションIDを破棄
            if(isset($_COOKIE[session_name()])){
                setcookie(session_name(), '', time()-42000, '/');
            }
            // サーバー側のセッション削除
            session_destroy();
    
            // ログインページへ
            header('Location:login.php');
        }
        
    } catch ( Exception $e ) {
        error_log('エラー発生' . $e->getMessage());
        $err_msg['common'] = MSG::UNEXPECTED;
    }
}

?>
<?php
$headTitle = '退会画面';
require('head.php');
?>
<body>
    <!-- ヘッダー -->
   <?php
   require('header.php');
   ?>

    <main id="l-main">
        <form method="post" class="c-form js-sp-menu-target">
            <h2 class="c-form__title">退会</h2>
            <div class="u-err-msg"></div>
            <input name="withdraw" class="c-form__submit" type="submit" value="退会する">
        </form>
    </main>
    
    <!-- フッター -->
    <?php
    require('footer.php');
    ?>
</body>
</html>