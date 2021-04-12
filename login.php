<?php
// 予想時間（ログインページ）：3h
// かかった時間：1h1mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('ログイン画面');
debug('==============================================');
debugLogStart();

if(!empty($_POST)) {
    debug('POSTされました。');
    $email = (!empty($_POST['email'])) ? $_POST['email'] : '';
    $pass = (!empty($_POST['pass'])) ? $_POST['pass'] : '';
    $pass_save = (!empty($_POST['pass_save'])) ? true : false;

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

    if(empty($err_msg)) {
        try {
            debug('バリデーションOKです。');

            $dbh = dbConnect();
            $sql = 'SELECT `id`, `password` FROM users WHERE email = :email AND delete_flg = 0';
            $data = array(':email' => $email);
            $stmt = queryPost($dbh, $sql, $data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // マッチした場合
            if(!empty($result) && password_verify($pass, $result['password'])) {
                // パスワード省略をチェックした場合
                if($pass_save === true) {
                    $sesLimit = 60 * 60 * 24;
                } else {
                    $sesLimit = 60*60;
                }
                // 最終ログイン日時を現在日時に
                $_SESSION['login_date'] = time();
                $_SESSION['login_limit'] = $sesLimit;
                // ユーザーIDを格納
                $_SESSION['user_id'] = $dbh->lastInsertId();
                debug('セッション変数の中身：'.print_r($_SESSION, true));

                header("Location:mypage.html");
            } else {
                $err_msg['common'] = VALID::NOTLOGIN;
            }
    
        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }

    }
}

?>
<?php
$headTitle = 'ログイン画面';
require('head.php');
?>

<body>

<?php
require('header.php');
?>

<main id="l-main">
        <form method="post" class="c-form">
            <h2 class="c-form__title">ログイン</h2>
            <div class="u-err-msg">
                <?= showErrMsg('common'); ?>
            </div>
            <label class="c-form__label" for="mail">
                Email
                <input id="mail" class="c-form__input <?= showErrStyle('email'); ?>" type="text" name="email" value="<?php echo (!empty($_POST['email'])) ? sanitize($_POST['email']) : ''; ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('email'); ?>
                </div>
            </label>
            <label class="c-form__label" for="password">
                パスワード
                <input id="password" class="c-form__input <?= showErrStyle('pass'); ?>" type="password" name="pass" value="<?php echo (!empty($_POST['pass'])) ? sanitize($_POST['pass']) : ''; ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('pass'); ?>
                </div>
            </label>
            <label for="pass_omit" class="c-form__label u-flex">
                <input id="pass_omit" class="c-form__check" type="checkbox" name="pass_save" <?php echo (!empty($_POST['pass_save'])) ? 'checked' : ''; ?>>次回ログインを省略する
            </label>

            <input class="c-form__submit" type="submit" value="送信">
            <a class="" href="">パスワードお忘れですか？</a>
        </form>
    </main>
    
<?php
require('footer.php');
?>
</body>
</html>