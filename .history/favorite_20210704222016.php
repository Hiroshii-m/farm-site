<?php
// 共通ファイルの読み込み
require_once('function.php');

debug('==============================================');
debug('お気に入り登録画面');
debug('==============================================');

$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
debug($_POST);

if((isLogin() === true) && !empty($_POST['shopId'])) {
    $s_id = (!empty($_POST['shopId'])) ? $_POST['shopId'] : '';
    // すでに登録されている場合、削除
    if(isFavorite($s_id, $u_id) === true) {
        try {
            $dbh = dbConnect();
            $sql = 'DELETE FROM `favorites` WHERE `user_id` = :u_id AND `shop_id` = :s_id';
            $data = array(':u_id' => $u_id, ':s_id' => $s_id);
            $stmt = queryPost($dbh, $sql, $data);
        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    // 登録されていない場合、追加
    }else{
        try {
            $dbh = dbConnect();
            $sql = 'INSERT INTO `favorites`(`user_id`, `shop_id`, `create_date`) VALUES(:u_id, :s_id, :create_date)';
            $data = array(':u_id' => $u_id, ':s_id' => $s_id, ':create_date' => date('Y-m-d'));
            $stmt = queryPost($dbh, $sql, $data);
        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
    // ログインしていない場合、なにもしない。
}