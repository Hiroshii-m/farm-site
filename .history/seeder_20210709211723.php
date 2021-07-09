<?php 
// 共通ファイルの読み込み
require_once('function.php');

try{
    $dbh = dbConnect();
    $sql = 'INSERT INTO users (`screen_name`, `email`, `password`, `avatar_image_path`, `create_date`) VALUES(:s_name, :email, :pass, :a_path, :create_date)';

    for($i = 301; $i <= 400; $i++){
        $email = 'aiueo'.$i.'@auieo.com';
        $data = array(':s_name' => '川口淳', ':email' => $email, ':pass' => password_hash('password', PASSWORD_DEFAULT), ':a_path' => 'uploads/ad25e01010453a7fc8d4ae95fe10f731b581af71.jpeg', ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        queryPost($dbh, $sql, $data);
        header("Location:mypage.php");
    }


} catch (Exception $e){
    error_log('エラー発生：'.$e->getMessage());
}

?>