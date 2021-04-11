<?php
// 共通ファイルの読み込み
require('function.php');

if(!empty($_POST)) {
    debug('POSTされました。');
    $email = (!empty($_POST['email'])) ? $_POST['email'] : '';
    $pass = (!empty($_POST['pass'])) ? $_POST['pass'] : '';
    $pass_re = (!empty($_POST['pass_re'])) ? $_POST['pass_re'] : '';

    validRequired($email, 'email');
    if(empty($err_msg['email'])) {
        validMax($email, 'email');
    }
    if(empty($err_msg['email'])) {
        validEmail($email, 'email');
    }
    validRequired($pass, 'pass');
    if(empty($err_msg['pass'])) {
        validMin($pass, 'pass');
    }
    if(empty($err_msg['pass'])) {
        validMax($pass, 'pass');
    }
    if(empty($err_msg['pass'])) {
        validHalf($pass, 'pass');
    }
    validRequired($pass_re, 'pass_re');
    if(empty($err_msg['pass_re'])) {
        validMatch($pass, $pass_re, 'pass_re');
    }
    if(empty($err_msg)) {
        debug('バリデーションOKです。');

        $token = makeRandKey(); // 認証キー生成

        // メール送信
        $to = $email;
        $from = 'karinoaca3@gmail.com';
        $subject = '【ユーザー登録】| ノウハン';
        $comment = <<<EOT
ノウハンをご利用いただきありがとうございます。

以下のURLへ進むとユーザー登録されます。



*認証キーの有効期限は30分です。
*このメールは返信しても届きません。お問い合わせは、本サイト下部の「お問い合わせ」からお願いいたします。

■ご登録の覚えがないのにこのメールが届いたという方
ご迷惑をおかけし申し訳ありません。大変お手数ですが、下記のメールアドレスまでご連絡をお願いいたします。
support@nouhan.jp

EOT;

        sendMail($from, $to, $subject, $comment);
        debug('認証キーです。'.$auth_key);

        // 認証に必要な情報をセッションへ保存
    }
}

?>
<?php
require('header.php');
?>

    <main id="l-main">
        <form method="post" class="c-form">
            <h2 class="c-form__title">ユーザー登録</h2>
            <div class="u-err-msg">
                <?= showErrMsg('common'); ?>
            </div>
            <label class="c-form__label" for="">
                Email
                <input class="c-form__input <?= showErrStyle('email'); ?>" type="text" name="email" value="<?= sanitize(retain($_POST['email'])); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('email'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                パスワード
                <input class="c-form__input <?= showErrStyle('pass'); ?>" type="password" name="pass" value="<?= sanitize(retain($_POST['pass'])); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('pass'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                パスワード（再入力）
                <input class="c-form__input <?= showErrStyle('pass_re'); ?>" type="password" name="pass_re" value="<?= sanitize(retain($_POST['pass_re'])); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('pass_re'); ?>
                </div>
            </label>
            <input class="c-form__submit" type="submit" value="送信">
        </form>
    </main>
    
<?php
require('footer.php');
?>