<?php
// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('メアドパスワード変更トークン受け取り画面');
debug('==============================================');

$token_flg = false;

// GETパラメータのトークンを取得
$token_get = (!empty($_GET['token'])) ? $_GET['token'] : '';
if(!empty($_GET)) {
    try {
        if($token_get === $_SESSION['token']) {
            $token_flg = true;

            $dbh = dbConnect();
            $sql = 'UPDATE users SET `email` = :email WHERE `id` = :u_id';
            $data = array(':email' => $_SESSION['email'], ':u_id' => $_SESSION['user_id']);
            $stmt = queryPost($dbh, $sql, $data);

        }else{
            $token_flg = false;

            if(!empty($_POST)) {
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;

                // 変更メールを送信
                include('sendMailEdit.php');
            }
        }
    } catch (Exception $e) {
        error_log('エラー発生：'.$e->getMessage());
        $err_msg['common'] = MSG::UNEXPECTED;
    }
}

?>
<?php
$headTitle = 'トークン受け取り（メアド・パスワード変更）画面';
include_once('head.php');
?>
<body>
<?php
include_once('header.php');
?>

<main id="l-main">
        <div class="p-tokenRecieve">
            <?php
                if($token_flg === true) {
            ?>
            <p>メールアドレス変更できました。</p>
            <a href="mypage.php">マイページへ移動する</a>
            <?php
                }else{
            ?>
            <p>メールアドレス変更に失敗しました。</p>
            <p>もう一度、トークン付きURLを送信してください。</p>
            <form method="post" action="" type="">
                <button name="submit" class="c-form__submit" type="submit">もう一度、URLを発行する</button>
            </form>
            <?php
                }
            ?>
        </div>
    </main>

<?php
include_once('footer.php');
?>
</body>
</html>