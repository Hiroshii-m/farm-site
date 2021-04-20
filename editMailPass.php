<?php
// 予想時間（プロフィール編集画面）：10mi
// かかった時間：9mi
// 予想時間（機能面）: 1h
// かかった時間: 1h41mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('メールアドレスとパスワードの変更画面');
debug('==============================================');

$u_id = $_SESSION['user_id'];
$dbFormData = getMail($u_id);

if(!empty($_POST)) {
    $email = (!empty($_POST['email'])) ? $_POST['email'] : $dbFormData['email'];
    $pass_prev = (!empty($_POST['pass_prev'])) ? $_POST['pass_prev'] : '';
    $pass_next = (!empty($_POST['pass_next'])) ? $_POST['pass_next'] : '';
    $pass_next_re = (!empty($_POST['pass_next_re'])) ? $_POST['pass_next_re'] : '';

    // バリデーションチェック
    // メールアドレスのチェック
    validRequired($email, 'email');
    if(empty($err_msg['email'])) {
        validMaxLen($email, 'email');
    }
    if(empty($err_msg['email'])) {
        validEmail($email, 'email');
    }
    // 入力があった場合
    if(!empty($pass_prev) || !empty($pass_next) || !empty($pass_next_re)) {
        // 現在のパスワードのチェック
        validRequired($pass_prev, 'pass_prev');
        if(empty($err_msg['pass_prev'])) {
            validMinLen($pass_next, 'pass_next');
        }
        // 新パスワードのチェック
        validRequired($pass_next, 'pass_next');
        if(empty($err_msg['pass_next'])) {
            validMaxLen($pass_next, 'pass_next');
        }
        if(empty($err_msg['pass_next'])) {
            validHalf($pass_next, 'pass_next');
        }
        // 新パスワード（確認）のチェック
        validRequired($pass_next_re, 'pass_next_re');
        if(empty($err_msg['pass_next_re'])) {
            validMatch($pass_next, $pass_next_re, 'pass_next_re');
        }
    }

    if(empty($err_msg)) {
        try {
            // Emailの変更があった場合
            if($email !== $dbFormData['email']) {
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                $_SESSION['email'] = $email;
                // 変更メールを送信
                include('sendMailEdit.php');
            }
            if(!empty($pass_next) && !empty($pass_next_re)) {
                $dbh = dbConnect();
                $sql = 'SELECT `id`, `password` FROM users WHERE id = :u_id';
                $data = array(':u_id' => $u_id);
                $stmt = queryPost($dbh, $sql, $data);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // マッチした場合
                if(!empty($result) && password_verify($pass_prev, $result['password'])) {
                    // パスワードをアップデート
                    $dbh = dbConnect();
                    $sql = 'UPDATE users SET `password` = :pass_next WHERE `id` = :u_id';
                    $data = array(':pass_next' => $pass_next, ':u_id' => $u_id);
                    $stmt = queryPost($dbh, $sql, $data);
                }
                header("Location:mypage.php");
            }

        } catch ( Exception $e ) {
            error_log('エラー発生' . $e->getMessage());
        }
    }
}

?>
<?php
$headTitle = 'メールアドレスとパスワードの変更画面';
include('head.php');
?>
<body>
    <?php include('header.php'); ?>
    
    <main id="l-main">
        <form method="post" class="c-form js-sp-menu-target">
            <h2 class="c-form__title">メールアドレスとパスワードの変更</h2>
            <div class="u-err-msg">
                
            </div>
            <label class="c-form__label" for="">
                メールアドレス
                <input class="c-form__input" type="text" name="email" value="<?= sanitize(getFormData('email')); ?>">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <p>メールアドレスを変更すると確認メールが送信されます。メール内のURLをクリックすると変更完了です。</p>
            <label class="c-form__label" for="">
                現在のパスワード
                <input class="c-form__input" type="password" name="pass_prev" value="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                新しいパスワード
                <input class="c-form__input" type="password" name="pass_next" value="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                新しいパスワード（確認）
                <input class="c-form__input" type="password" name="pass_next_re" value="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <p>パスワードを設定したい場合は上記を全て入力してください。</p>
            
            <input class="c-form__submit" type="submit" value="変更">
        </form>
    </main>
    
    <!-- フッター -->
    <?php include('footer.php'); ?>
    <!-- 共通ファイル -->
    <script src="js/app.js"></script>
</body>
</html>