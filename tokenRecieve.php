<?php
// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('トークン受け取り画面');
debug('==============================================');

$token_flg = false;

// GETパラメータのトークンを取得
$token_get = (!empty($_GET['token'])) ? $_GET['token'] : '';
if(!empty($_GET)) {
    try {
        if($token_get === $_SESSION['token']) {
            $token_flg = true;
            $expired_id = validEmailExpired($_SESSION['email']);
            // 退会ユーザーの場合、UPDATEで登録する。
            if(!empty($expired_id)) {
                $dbh = dbConnect();
                $sql = 'UPDATE users SET `delete_flg` = :d_flg, `password` = :pass WHERE `email` = :email';
                $data = array(':d_flg' => 0, ':pass' => $_SESSION['password'], ':email' => $_SESSION['email']);
                $stmt = queryPost($dbh, $sql, $data);

                // ユーザーIDを格納
                $_SESSION['user_id'] = $expired_id;

            // 新規ユーザーの場合、INSERTで登録する。
            } else {
                $dbh = dbConnect();
                $sql = 'INSERT INTO users (`email`, `password`, `login_time`, `create_date`) VALUES(:email, :pass, :login_time,:create_date)';
                $data = array(':email' => $_SESSION['email'], ':pass' => $_SESSION['password'], 
                ':login_time' => date('Y-m-d H:i:s'), 
                ':create_date' => date('Y-m-d H:i:s'));
                // クエリ実行
                $stmt = queryPost($dbh, $sql, $data);
                // ユーザーIDを格納
                $_SESSION['user_id'] = $dbh->lastInsertId();
            }

            // クエリ成功の場合
            if(!empty($stmt)) {
                $sesLimit = 60*60;
                // 最終ログイン日時を現在日時に
                $_SESSION['login_date'] = time();
                $_SESSION['login_limit'] = $sesLimit;
            }
        }else{
            $token_flg = false;

            if(!empty($_POST)) {
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;

               include('sendMailSubmit.php');
            }
        }
    } catch (Exception $e) {
        error_log('エラー発生：'.$e->getMessage());
        $err_msg['common'] = MSG::UNEXPECTED;
    }
}

?>
<?php
$headTitle = 'ユーザー登録画面';
require('head.php');
?>

<body>

<?php
require('header.php');
?>

<main id="l-main">
        <div class="p-tokenRecieve">
            <?php
                if($token_flg === true) {
            ?>
            <p>ユーザー登録完了しました。</p>
            <a href="mypage.php">マイページへ移動する</a>
            <?php
                }else{
            ?>
            <p>ユーザー登録できませんでした。</p>
            <p>もう一度、トークン付きURLを送信してください。</p>
            <form method="post" action="">
                <button name="submit" class="c-form__submit" type="submit">もう一度、URLを発行する</button>
            </form>
            <?php
                }
            ?>
        </div>
    </main>

<?php
require('footer.php');
?>
<!-- 共通ファイル -->
<script src="js/app.js"></script>
</body>
</html>