<?php
// 予想時間:1h
// かかった時間：1h 19mi

// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('認証キー受け取り画面（パスワードリマインダー）');
debug('==============================================');

if(!empty($_POST) && time() < $_SESSION['auth_limit']) {
    $auth_key = (!empty($_POST['auth_key'])) ? $_POST['auth_key'] : '';

    validLength($auth_key, 'auth_key');
    if(empty($err_msg)) {
        if($_SESSION['auth_key'] === $auth_key) {
            try {
                $pass = makeRandomKey();

                $dbh = dbConnect();
                $sql = 'UPDATE users SET `password` = :pass WHERE `email` = :email';
                $data = array(':pass' => password_hash($pass, PASSWORD_DEFAULT), ':email' => $_SESSION['email']);
                $stmt = queryPost($dbh, $sql, $data);

                // 変更されたパスワードをメールで送信する
                $to = $_SESSION['email'];
                $from = 'karinoaca3@gmail.com';
                $subject = 'パスワードを再発行いたしましました。';
                $comment = <<<EOT
ノウハンをご利用いただきありがとうございます。

パスワードが再発行されました。以下のパスワードでログインできます。
新しいパスワード：{$pass}

*このメールは返信しても届きません。お問い合わせは、本サイト下部の「お問い合わせ」からお願いいたします。

■ご登録の覚えがないのにこのメールが届いたという方
ご迷惑をおかけし申し訳ありません。大変お手数ですが、下記のメールアドレスまでご連絡をお願いいたします。
support@nouhan.jp
EOT;

                sendMail($from, $to, $subject, $comment);
                debug('パスワード発行');
                debug($pass);
                header("Location:login.php");
                exit;

            } catch ( Exception $e ) {
                error_log('エラー発生:' . $e->getMessage());
                $err_msg['common'] = MSG::UNEXPECTED;
            }
        }
    }
}

?>
<?php
$headTitle = '認証キー確認画面';
require('head.php');
?>
<body>
    <div class="p-flash js-show-msg u-bgColor-accent">
        <?= getFlashMessage($_SESSION['msg']); ?>
    </div>
    <!-- ヘッダー -->
    <?php require('header.php') ?>;

    <main id="l-main">
        <form method="post" class="c-form js-sp-menu-target">
            <h2 class="c-form__title">認証キー確認画面</h2>
            <div class="u-err-msg">
                <?= showErrMsg('common'); ?>
            </div>
            <label class="c-form__label" for="">
                認証キー
                <input class="c-form__input <?= showErrStyle('auth_key'); ?>" type="text" name="auth_key" value="<?= sanitize(getFormData('auth_key')); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('auth_key'); ?>
                </div>
            </label>
            
            <input class="c-form__submit" type="submit" value="確認">
            <a href="remindPassSend.php">パスワード再発行のメールを再送信する</a>
        </form>
    </main>
    
    <!-- フッター -->
    <?php require('footer.php'); ?>
    <!-- 共通ファイル -->
    <script src="js/app.js"></script>
</body>
</html>