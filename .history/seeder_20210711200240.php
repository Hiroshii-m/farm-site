<?php 
// 共通ファイルの読み込み
require_once('function.php');

try{
    $dbh = dbConnect();

    $sql = 'INSERT INTO users (`screen_name`, `email`, `password`, `avatar_image_path`, `create_date`) VALUES(:s_name, :email, :pass, :a_path, :create_date)';
    
    for($i = 2701; $i <= 3000; $i++){
        $email = 'aiueo'.$i.'@auieo.com';
        $data = array(':s_name' => '山崎', ':email' => $email, ':pass' => password_hash('password', PASSWORD_DEFAULT), ':a_path' => 'uploads/8cb250283c5a4cfebe93aa914eec33ffb4935e17.png', ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        queryPost($dbh, $sql, $data);
        header("Location:mypage.php");
    }

    // $sql = 'INSERT INTO shops (`user_id`, `shop_name`, `social_profile`, `postcode`, `prefecture_id`, `city_id`, `street`, `shop_img1`, `shop_img2`, `shop_img3`, `create_date`) VALUES(:u_id, :s_name, :s_profile, :postcode, :p_id, :c_id, :street, :img1, :img2, :img3, :create_date)';

    // for($i = 1; $i <= 189; $i++){
    //     $u_id = 26 + $i;
    //     $c_id = $i;
    //     $data = array(':u_id' => $u_id, ':s_name' => '木村農園', ':s_profile' => '新鮮な野菜を置いてます！

    //     取扱商品（旬野菜等）
    //     ・野菜
    //     　トマト・なす・きゅうり・えだまめ・さんどまめ・とうがらし・ピーマン・いちご・えんどう・
    //     トウモロコシ・かぶ・ほうれんそう・きく菜・小松菜・ねぎ・
    //     畑菜・金時人参・西洋人参・水菜・壬生菜・きゃべつ・白菜・ブロッコリー・カリフラワー・
    //     花菜
    //     ・果実
    //     柿
    //     ・米', ':postcode' => '7231234', ':p_id' => '1', ':c_id' => $c_id, ':street' => '東2条5番地', ':img1' => 'uploads/aecdf9a4649fc3397eb22797c4b03383edc5e210.jpeg', ':img2' => 'uploads/41aad9be5552cf469f62b8c61df1ed380d23f8fa.jpeg', ':img3' => 'uploads/8bb0826ff7f7e2a6223010afb1f4861ca24624ca.jpeg', ':create_date' => date('Y-m-d H:i:s'));
    //     // クエリ実行
    //     queryPost($dbh, $sql, $data);
    //     header("Location:mypage.php");
    // }

} catch (Exception $e){
    error_log('エラー発生：'.$e->getMessage());
}

?>