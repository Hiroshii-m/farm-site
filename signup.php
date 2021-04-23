<?php
// 予想時間（ユーザー登録）：4h
// かかった時間：4h19mi（基本的な機能）
// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('ユーザー登録画面');
debug('==============================================');

debugLogStart();

if(!empty($_POST)) {
    debug('POSTされました。');
    $email = (!empty($_POST['email'])) ? $_POST['email'] : '';
    $pass = (!empty($_POST['pass'])) ? $_POST['pass'] : '';
    $pass_re = (!empty($_POST['pass_re'])) ? $_POST['pass_re'] : '';

    validRequired($email, 'email');
    if(empty($err_msg['email'])) {
        validMaxLen($email, 'email');
    }
    if(empty($err_msg['email'])) {
        validEmail($email, 'email');
    }
    validRequired($pass, 'pass');
    if(empty($err_msg['pass'])) {
        validMinLen($pass, 'pass');
    }
    if(empty($err_msg['pass'])) {
        validMaxLen($pass, 'pass');
    }
    if(empty($err_msg['pass'])) {
        validHalf($pass, 'pass');
    }
    validRequired($pass_re, 'pass_re');
    if(empty($err_msg['pass_re'])) {
        validMatch($pass, $pass_re, 'pass_re');
    }

    if(empty($err_msg)) {
        try {
            debug('バリデーションOKです。');
            $token = bin2hex(random_bytes(32)); // 認証キー生成

            // 認証に必要な情報をセッションへ保存
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = password_hash($pass, PASSWORD_DEFAULT);
    
            // メール送信
            $_SESSION['email'] = $email;
            include('sendMailSubmit.php');
            debug('URL発行');
            debug($url);
    
        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }

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
        <form method="post" class="c-form">
            <h2 class="c-form__title">ユーザー登録</h2>
            <div class="u-err-msg">
                <?= showErrMsg('common'); ?>
            </div>
            <label class="c-form__label" for="">
                Email
                <input class="c-form__input <?= showErrStyle('email'); ?>" type="text" name="email" value="<?= sanitize(getFormData('email')); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('email'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                パスワード
                <input class="c-form__input <?= showErrStyle('pass'); ?>" type="password" name="pass" value="<?= sanitize(getFormData('pass')); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('pass'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                パスワード（再入力）
                <input class="c-form__input <?= showErrStyle('pass_re'); ?>" type="password" name="pass_re" value="<?= sanitize(getFormData('pass_re')); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('pass_re'); ?>
                </div>
            </label>
            <input class="c-form__submit" type="submit" value="確認メールを送信">
        </form>
    </main>
    
<?php
require('footer.php');
?>
</body>
</html>