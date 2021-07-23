<?php 
// 共通ファイルの読み込み
require_once('function.php');

try{
    $dbh = dbConnect();

    // $sql = 'INSERT INTO users (`screen_name`, `email`, `password`, `avatar_image_path`, `create_date`) VALUES(:s_name, :email, :pass, :a_path, :create_date)';
    
    // for($i = 9601; $i <= 9900; $i++){
    //     $email = 'aiueo'.$i.'@auieo.com';
    //     $data = array(':s_name' => 'ゴリさん', ':email' => $email, ':pass' => password_hash('password', PASSWORD_DEFAULT), ':a_path' => 'uploads/8cb250283c5a4cfebe93aa914eec33ffb4935e17.png', ':create_date' => date('Y-m-d H:i:s'));
    //     // クエリ実行
    //     queryPost($dbh, $sql, $data);
    //     header("Location:mypage.php");
    // }

    // $sql = 'INSERT INTO shops (`user_id`, `shop_name`, `social_profile`, `postcode`, `prefecture_id`, `city_id`, `street`, `shop_img1`, `shop_img2`, `shop_img3`, `create_date`) VALUES(:u_id, :s_name, :s_profile, :postcode, :p_id, :c_id, :street, :img1, :img2, :img3, :create_date)';

    // for($i = 675; $i <= 736; $i++){
    //     $k = $i - 674;
    //     $u_id = 2219 + $k;
    //     $c_id = $i;
    //     $data = array(':u_id' => $u_id, ':s_name' => '無農薬野菜', ':s_profile' => 'たくさん売れてます！

    //     取扱商品（旬野菜等）
    //     ・野菜
    //     　トマト・なす・きゅうり・えだまめ・さんどまめ・とうがらし・ピーマン・いちご・えんどう・
    //     トウモロコシ・かぶ・ほうれんそう・きく菜・小松菜・ねぎ・
    //     畑菜・金時人参・西洋人参・水菜・壬生菜・きゃべつ・白菜・ブロッコリー・カリフラワー・
    //     花菜
    //     ・果実
    //     柿
    //     ・米', ':postcode' => '7231234', ':p_id' => '13', ':c_id' => $c_id, ':street' => '東2条5番地', ':img1' => 'uploads/3002ac290f0d88b0cf1605d1b85624db7d663bbd.png', ':img2' => 'uploads/aecdf9a4649fc3397eb22797c4b03383edc5e210.jpeg', ':img3' => 'uploads/41aad9be5552cf469f62b8c61df1ed380d23f8fa.jpeg', ':create_date' => date('Y-m-d H:i:s'));
    // クエリ実行
    // queryPost($dbh, $sql, $data);
    // header("Location:mypage.php");

    $sql = 'INSERT INTO products (`shop_id`, `user_id`, `p_name`, `p_detail`, `category_id`, `term`, `p_value`, `p_number`, `p_img`,  `create_date`) VALUES(:s_id, :u_id, :p_name, :p_detail, :category_id, :term, :p_value, :p_number, :p_img, :create_date)';

    for($i = 0; $i <= 61; $i++){
        $s_id = 2282 + $i;
        $u_id = 2220 + $i;
        $c_id = $i;
        $data = array(':s_id' => $s_id, ':u_id' => $u_id, ':p_name' => 'トマト', ':p_detail' => '色や大きさも豊富で、栄養価も高いトマトは、市場の取扱金額トップの人気を誇る野菜です。
        皮が薄く、酸味が少ないピンク系と、皮も赤く、うま味が強い赤系のトマトがあります。トマトを生で食べることが多い日本では「桃太郎」に代表されるピンク系が主流。調理用トマトなどが赤系で、味が濃く、加熱するとうま味が増すのが特徴です。ケチャップやトマト缶などの加工品にも用いられています。', ':category_id' => 2, ':term' => '春、夏。', ':p_value' => '100', ':p_number' => '1個', ':p_img' => 'uploads/b1ec76f6cdc0ed3202e1d2683a742f2c164a1a5a.png', ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        queryPost($dbh, $sql, $data);
        header("Location:mypage.php");
    }
    // for($i = 0; $i <= 61; $i++){
    //     $s_id = 2282 + $i;
    //     $u_id = 2220 + $i;
    //     $c_id = $i;
    //     $data = array(':s_id' => $s_id, ':u_id' => $u_id, ':p_name' => '西洋カボチャ', ':p_detail' => '日本カボチャ、西洋カボチャ、ぺポカボチャの３種類に分けられ、現在の主流は、ほくほくして甘みの強い西洋カボチャです。', ':category_id' => 2, ':term' => '秋、夏。', ':p_value' => '100', ':p_number' => '500g', ':p_img' => 'uploads/b1ec76f6cdc0ed3202e1d2683a742f2c164a1a5a.png', ':create_date' => date('Y-m-d H:i:s'));
    //     // クエリ実行
    //     queryPost($dbh, $sql, $data);
    //     header("Location:mypage.php");
    // }

} catch (Exception $e){
    error_log('エラー発生：'.$e->getMessage());
}

?>