<?php

// ================================================
// ログ
// ================================================
ini_set('log_errors', 'on');
ini_set('error_log', 'error.log');

// =====================================
// セッション準備・セッション有効期限を延ばす
// =====================================
// デフォルトだと、24分でセッションが削除されてしまうので、置き場所変更
session_save_path("/var/tmp/");
// ガーベージコレクションが削除するセッションの有効期限を設定（30日に設定）
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
// 上の設定は、session_start()の前に書かないといけない。キャッシュなどのヘッダー情報が送信される。
session_start();
// セッションIDを再発行
session_regenerate_id();

//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
    debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
    debug('セッションID：'.session_id());
    debug('セッション変数の中身：'.print_r($_SESSION,true));
    debug('現在日時タイムスタンプ：'.time());
    if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
      debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
    }
}

// ================================================
// デバッグ
// ================================================
$debug_flg = false;
function debug($str) {
    global $debug_flg;
    if(!empty($debug_flg)){
        error_log('デバッグ:'.$str);
    }
}

// ================================================
// 定数
// ================================================
// バリデーションメッセージ
class VALID {
    const REQUIRED = '入力必須です。';
    const EMAIL = 'Email形式で入力してください。';
    const EMAILDUP = 'このEmailは既に登録されています。';
    const TEXTMIN = '6文字以上入力してください。';
    const TEXTMAX = '最大文字数を超えています。';
    const HALFENG = '半角英数字で入力してください。';
    const NOMATCH = 'パスワードとパスワード（再入力）があっていません。';
    const NOTLOGIN = 'メールアドレスまたはパスワードが違います。';
}
class MSG {
    const UNEXPECTED = '予期せぬエラーが発生しました。しばらく経ってから、やり直してください。';
}

// ================================================
// グローバル変数
// ================================================
$err_msg = array();

// ================================================
// 関数
// ================================================
// バリデーション
// ************************************************
function validRequired($str, $key){
    global $err_msg;
    if($str === ''){
        $err_msg[$key] = VALID::REQUIRED;
    }
}
// Email形式化どうか判定
function validEmail($str, $key){
    global $err_msg;
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
        $err_msg[$key] = VALID::EMAIL;
    }
}
// Email重複チェック
function validEmailDup($str, $key){
    global $err_msg;
    $dbh = dbConnect();
    $sql = 'SELECT id FROM users WHERE email = :email AND delete_flg = 0';
    $data = array(':email' => $str);
    $stmt = queryPost($dbh, $sql, $data);
    $rst = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($rst)){
        $err_msg[$key] = VALID::EMAILDUP;
    }else{
        return false;
    }
}
// 最小文字数以上かどうか判定
function validMin($str, $key, $min = 6){
    global $err_msg;
    if(mb_strlen($str) < $min){
        $err_msg[$key] = VALID::TEXTMIN;
    }
}
// 最大文字数以内かどうか判定
function validMax($str, $key, $max = 256){
    global $err_msg;
    if($max <= mb_strlen($str)){
        $err_msg[$key] = VALID::TEXTMAX;
    }
}
// 半角英数字かどうか判定
function validHalf($str, $key){
    global $err_msg;
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
        $err_msg[$key] = VALID::HALFENG;
    }
}
// 値がマッチしているか判定
function validMatch($str, $str2, $key){
    global $err_msg;
    if($str !== $str2){
        $err_msg[$key] = VALID::NOMATCH;
    }
}
// バリデーションを反映
// ************************************************
function showErrMsg($key) {
    global $err_msg;
    if(!empty($err_msg[$key])) {
        return $err_msg[$key];
    }
}
function showErrStyle($key) {
    global $err_msg;
    if(!empty($err_msg[$key])) {
        return 'u-err-input';
    }
}
// データベース
// ************************************************
function dbConnect(){
    // DB接続準備
    $dsn = 'mysql:dbname=farmshops;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
}
// クエリー実行関数
function queryPost($dbh, $sql, $data){
    // クエリ作成
    $stmt = $dbh->prepare($sql);
    // SQL実行
    if(!$stmt->execute($data)){
        debug('クエリ失敗しました。');
        debug('失敗したSQL:'.print_r($stmt, true));
        $err_msg['common'] = MSG::UNEXPECTED;
        return 0;
    }
    debug('クエリ成功しました。');
    return $stmt;
}

//================================
// メール送信
//================================
function sendMail($from, $to, $subject, $comment){
    if(!empty($to) && !empty($subject) && !empty($comment)){
        //文字化けしないように設定
        mb_language("Japanese"); //現在使っている言語を設定する
        mb_internal_encoding("UTF-8"); //内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定
        
        //メールを送信（送信結果はtrueかfalseで返ってくる）
        $result = mb_send_mail($to, $subject, $comment, "From: ".$from);
        //送信結果を判定
        if ($result) {
          debug('メールを送信しました。');
        } else {
          debug('【エラー発生】メールの送信に失敗しました。');
        }
    }
}

//================================
// その他
//================================
// サニタイズ
function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
}