<?php
// 予想時間（プロフィール編集画面）：5mi
// かかった時間：1mi
// 予想時間（機能面）:1h
// かかった時間：29mi

// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('パスワードリマインダー送信画面');
debug('==============================================');

if(!empty($_POST)) {
    $email = (!empty($_POST['email'])) ? $_POST['email'] : '';

    validRequired($email, 'email');
    if(empty($err_msg['email'])) {
        validMaxLen($email, 'email');
    }
    if(empty($err_msg['email'])) {
        validEmail($email, 'email');
    }

    if(empty($err_msg)) {
        try {
            $dbh = dbConnect();
            $sql = 'SELECT `id` FROM users WHERE `email` = :email';
            $data = array(':email' => $email);
            $stmt = queryPost($dbh, $sql, $data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Emailがある場合、メール送信
            if(!empty($result)) {
                // 認証キー発行
                $auth_key = makeRandomKey();
                $_SESSION['auth_key'] = $auth_key;
                $_SESSION['email'] = $email;
                // 認証キーの有効期限を保存
                $_SESSION['auth_limit'] = time() + 30 * 60;
                $recieveUrl = $_SERVER['HTTP_HOST'].'/output2/farm/remindPassRecieve.php';
                $sendUrl = $_SERVER['HTTP_HOST'].'/output2/farm/remindPassSend.php';

                $to = $email;
                $from = 'karinoaca3@gmail.com';
                $subject = '認証キーを発行いたしましました。';
                $comment = <<<EOT
ノウハンをご利用いただきありがとうございます。
本メールアドレス宛にパスワード再発行のご依頼がありました。

下記のURLにて認証キーをご入力頂くとパスワードが発行されます。
パスワード発行認証キー入力ページ：{$recieveUrl}
認証キー：{$auth_key}
*認証キーの有効期限は30分です。

認証キーを再発行したい場合は下記のページより再度発行お願い致します。
{$sendUrl}

*このメールは返信しても届きません。お問い合わせは、本サイト下部の「お問い合わせ」からお願いいたします。
    
■ご登録の覚えがないのにこのメールが届いたという方
ご迷惑をおかけし申し訳ありません。大変お手数ですが、下記のメールアドレスまでご連絡をお願いいたします。
support@nouhan.jp
EOT;

                sendMail($from, $to, $subject, $comment);
                debug($recieveUrl);
                debug($auth_key);
            }

        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
}

?>
<?php
$headTitle = 'パスワードリマインダー送信画面';
require('head.php');
?>
    <body>
        <!-- ヘッダー -->
        <?php require('header.php'); ?>
    
        <main id="l-main">
            <form method="post" class="c-form js-sp-menu-target">
                <h2 class="c-form__title">パスワードリマインダー</h2>
                <div class="u-err-msg">
                    <?= showErrMsg('common'); ?>
                </div>
                <label class="c-form__label" for="">
                    メールアドレス
                    <input class="c-form__input <?= showErrStyle('email'); ?>" type="text" name="email" value="<?= sanitize(getFormData('email')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('email'); ?>
                    </div>
                </label>
                
                <input class="c-form__submit" type="submit" value="自分宛にメールを送信">
            </form>
        </main>
        
        <!-- フッター -->
        <?php require('footer.php'); ?>
        <!-- 共通ファイル -->
        <script src="js/app.js"></script>
    </body>
    </html>