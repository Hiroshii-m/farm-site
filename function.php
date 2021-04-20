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
$debug_flg = true;
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
    const TEXTMAX_30 = '30文字以内で入力してください。';
    const HALFENG = '半角英数字で入力してください。';
    const ILLEGAL = '不正な値が入りました。';
    const ZIP = '半角数字で7文字、入力してください。';
    const LENGTH = '文字で入力してください。';
    const KANJIHIRAGANA = '漢字またはひらがなで入力してください。';
    const KANA = 'カタカナで入力してください。';
    const NOMATCH = 'パスワードとパスワード（再入力）があっていません。';
    const NOTLOGIN = 'メールアドレスまたはパスワードが違います。';
    const WITHDRAW = 'このメールアドレスは、退会済のユーザーです。再度利用する場合、もう一度、ユーザー登録を行ってください。';
    const CITYNOMATCH = '正しい市区町村を漢字で入力してください。';
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
// 退会済ユーザーかどうかをチェック
function validEmailExpired($email) {
    $dbh = dbConnect();
    $sql = 'SELECT `id` FROM users WHERE `email` = :email AND `delete_flg` = :d_flg';
    $data = array(':email' => $email, ':d_flg' => 1);
    $stmt = queryPost($dbh, $sql, $data);
    $rst = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($rst)) {
        // 退会済のユーザーです。
        return $rst['id'];
    } else {
        // 退会済のユーザーではありません。
        return false;
    }
}
// 最小文字数以上かどうか判定
function validMinLen($str, $key, $min = 6, $msg = VALID::TEXTMIN){
    global $err_msg;
    if(mb_strlen($str) < $min){
        $err_msg[$key] = $msg;
    }
}
// 最大文字数以内かどうか判定
function validMaxLen($str, $key, $max = 255, $msg = VALID::TEXTMAX){
    global $err_msg;
    if($max <= mb_strlen($str)){
        $err_msg[$key] = $msg;
    }
}
// 半角英数字かどうか判定
function validHalf($str, $key){
    global $err_msg;
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
        $err_msg[$key] = VALID::HALFENG;
    }
}
// 半角数字かどうか判定
function validHalfNum($str, $key) {
    global $err_msg;
    if(!preg_match("/^[0-9]+$/", $str)) {
        $err_msg[$key] = VALID::ILLEGAL;
    }
}
// 値がマッチしているか判定
function validMatch($str, $str2, $key){
    global $err_msg;
    if($str !== $str2){
        $err_msg[$key] = VALID::NOMATCH;
    }
}
// 7文字の数字かどうか判定
function validZip($str, $key) {
    global $err_msg;
    if(!preg_match("/^[0-9]+$/", $str) || mb_strlen($str) !== 7) {
        $err_msg[$key] = VALID::ZIP;
    }
}
// 固定長の判定
function validLength($str, $key, $length = 8) {
    global $err_msg;
    if(mb_strlen($str) !== $length) {
        $err_msg[$key] = $length.VALID::LENGTH;
    }
}
// 漢字かひらがなか判定
function validKanjiHira($str, $key) {
    global $err_msg;
    if(!preg_match("/^[ぁ-ん一-龠]+$/u", $str)) {
        $err_msg[$key] = VALID::KANJIHIRAGANA;
    }
}
// カナ文字か判定
function validKana($str, $key) {
    global $err_msg;
    if(!preg_match("/^[ァ-ヶー]+$/u", $str)) {
        $err_msg[$key] = VALID::KANA;
    }
}
// 都道府県選択されていた場合、市区町村が正しいか判定
function getCityMatch($prefecture_id, $city_name, $key) {
    global $err_msg;
    $dbh = dbConnect();
    $sql = 'SELECT `id` FROM cites WHERE `prefecture_id` = :p_id AND `city_name` = :c_name';
    $data = array(':p_id' => $prefecture_id, ':c_name' => $city_name);
    $stmt = queryPost($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($result)) {
        return $result['id'];
    }else{
        $err_msg[$key] = VALID::CITYNOMATCH;
    }
}
// バリデーションを反映
// ************************************************
function showErrMsg($key, $key2 = '', $key3 = '') {
    global $err_msg;
    if(!empty($err_msg[$key])) {
        return $err_msg[$key];
    }else if(!empty($key2) && !empty($err_msg[$key2])) {
        return $err_msg[$key2];
    }else if(!empty($key3) && !empty($err_msg[$key3])) {
        return $err_msg[$key3];
    }
}
function showErrStyle($key) {
    global $err_msg;
    if(!empty($err_msg[$key])) {
        return 'u-err-input';
    }
}
// POST、DBの情報を表示
// ************************************************
function getFormData($str, $flg = false){
    if($flg){
        $method = $_GET;
    }else{
        $method = $_POST;
    }
    global $dbFormData;
    // dbFormDataがある場合
    if(!empty($dbFormData[$str])){
        // POSTされている場合
        if(!empty($_POST[$str])){
            return $_POST[$str];
            // されていなければ、db表示
        }else{
            return $dbFormData[$str];
        }
        // dbFormDataが無い場合
    }else{
        // POSTされているか
        if(!empty($_POST[$str])){
            return $_POST[$str];
        }else{
            return '';
        }
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
    foreach($data as $key => $val) {
        if(is_int($val)) {
            $stmt->bindValue($key, $val, PDO::PARAM_INT);
        }else{
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }
    }
    // SQL実行
    if(!$stmt->execute()){
        debug('クエリ失敗しました。');
        debug('失敗したSQL:'.print_r($stmt, true));
        $err_msg['common'] = MSG::UNEXPECTED;
        return 0;
    }
    debug('クエリ成功しました。');
    return $stmt;
}
// ユーザー情報を取得
function getUser($u_id) {
    $dbh = dbConnect();
    $sql = 'SELECT `id`, `screen_name`, `last_name`, `first_name`, `last_name_kana`, `first_name_kana`, `birthday_year`, `birthday_month`, `birthday_day`, `avatar_image_path`, `prefecture_id`, `city_id`, `street`, `building`, `postcode` FROM users WHERE `id` = :u_id AND `group_id` = 1';
    $data = array(':u_id' => $u_id);
    $stmt = queryPost($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
// メールアドレスだけ取得
function getMail($u_id) {
    $dbh = dbConnect();
    $sql = 'SELECT `email` FROM users WHERE `id` = :u_id';
    $data = array(':u_id' => $u_id);
    $stmt = queryPost($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
// 市区町村名を取得
function getCityName($city_id) {
    $dbh = dbConnect();
    $sql = 'SELECT `city_name` From cites WHERE `id` = :c_id';
    $data = array(':c_id' => $city_id);
    $stmt = queryPost($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($result)) {
        return $result['city_name'];
    }
}
// 画像をアップロード
function uploadImg($file, $key) {
    // 1.ファイルの中身が画像かどうかを判定
    if(isset($file['error']) || !is_int($file['error'])) {
        try {
            // 2.バリデーション
            switch ($file['error']){
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('ファイルが選択されていません。');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('ファイルサイズが大きすぎます。');
                default:
                    throw new RuntimeException('その他のエラーが発生しました。');
            }

            // 3.MIMEタイプをチェック
            $type = @exif_imagetype($file['tmp_name']);
            if(!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                throw new RuntimeException('画像形式が未対応です。');
            }
            // 4.ファイルからSHA-1ハッシュをとってファイル名を決定し、保存する。DBで保存したとき、どれが画像か分かるようにpathを指定
           $path = 'uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
            // 5.ファイルを保存（移動）
            if(!move_uploaded_file($file['tmp_name'], $path)) {
                throw new RuntimeException('ファイル保存時にエラーが発生しました。');
            }
            // 6.保存したファイルパスのパーミッション（権限）を変更する
            chmod($path, 0644);

            return $path;
        } catch ( Exception $e ) {
            debug($e->getMessage());
            global $err_msg;
            $err_msg[$key] = $e->getMessage();
        }
    }
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
// 8桁の認証キー発行
function makeRandomKey($length = 8) {
    $chars = 'abcdefghijelmnopqrstuvwxyzABCDEFGHIIJELMNOPQURSTUVWXYZ1234567890';
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $result .= $chars[mt_rand(0, 62)];
    }
    return $result;
}