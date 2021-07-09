<?php 
// 共通ファイルの読み込み
require_once('function.php');

try{
    $dbh = dbConnect();
    $sql = 'INSERT INTO users (`screen_name`, `email`, `password`, `avatar_image_path`, `create_date`) VALUES(:s_name, :email, :pass, :a_path, :create_date)';

    for($i = 61; $i <= 70; $i++){
        $data = array(':s_name' => 'ファイター', ':email' => $email, ':pass' => $pass, ':a_path' => $img, ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        queryPost($dbh, $sql, $data);
    }


} catch (Exception $e){
    error_log('エラー発生：'.$e->getMessage());
}

?>