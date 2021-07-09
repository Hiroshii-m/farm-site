<?php 
// 共通ファイルの読み込み
require_once('function.php');

try{
    $dbh = dbConnect();
    $sql = 'INSERT INTO users (`screen_name`, `email`, `password`, `avatar_image_path`, `create_date`) VALUES(:s_name, :email, :pass, :a_path, :create_date)';

    for($i = 71; $i <= 100; $i++){
        $email = 'aiueo'.$i.'@auieo.com';
        $data = array(':s_name' => 'ファイター', ':email' => $email, ':pass' => password_hash('password', PASSWORD_DEFAULT), ':a_path' => 'uploads/adbd82b24995d123735af7cfe0eacc38a73f768e.jpeg', ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        queryPost($dbh, $sql, $data);
        header("Location:mypage.php");
    }


} catch (Exception $e){
    error_log('エラー発生：'.$e->getMessage());
}

?>