<?php
// 予想時間:3h
// かかった時間：2h40mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');
// editShopがある場合、

debug('==============================================');
debug('店舗登録');
debug('==============================================');

// 都道府県の配列生成
$pref = array(
    '1'=>'北海道',
    '2'=>'青森県',
    '3'=>'岩手県',
    '4'=>'宮城県',
    '5'=>'秋田県',
    '6'=>'山形県',
    '7'=>'福島県',
    '8'=>'茨城県',
    '9'=>'栃木県',
    '10'=>'群馬県',
    '11'=>'埼玉県',
    '12'=>'千葉県',
    '13'=>'東京都',
    '14'=>'神奈川県',
    '15'=>'新潟県',
    '16'=>'富山県',
    '17'=>'石川県',
    '18'=>'福井県',
    '19'=>'山梨県',
    '20'=>'長野県',
    '21'=>'岐阜県',
    '22'=>'静岡県',
    '23'=>'愛知県',
    '24'=>'三重県',
    '25'=>'滋賀県',
    '26'=>'京都府',
    '27'=>'大阪府',
    '28'=>'兵庫県',
    '29'=>'奈良県',
    '30'=>'和歌山県',
    '31'=>'鳥取県',
    '32'=>'島根県',
    '33'=>'岡山県',
    '34'=>'広島県',
    '35'=>'山口県',
    '36'=>'徳島県',
    '37'=>'香川県',
    '38'=>'愛媛県',
    '39'=>'高知県',
    '40'=>'福岡県',
    '41'=>'佐賀県',
    '42'=>'長崎県',
    '43'=>'熊本県',
    '44'=>'大分県',
    '45'=>'宮崎県',
    '46'=>'鹿児島県',
    '47'=>'沖縄県'
);
// ユーザーIDを格納
$u_id = $_SESSION['user_id'];

if(!empty($_POST)) {
    $shop_name = (!empty($_POST['shop_name'])) ? $_POST['shop_name'] : '';
    $social_profile = (!empty($_POST['social_profile'])) ? $_POST['social_profile'] : '';
    $postcode = (!empty($_POST['postcode'])) ? $_POST['postcode'] : '';
    $prefecture_id = (!empty($_POST['prefecture_id'])) ? $_POST['prefecture_id'] : 0;
    $city_id = '';
    $city_name = (!empty($_POST['city_name'])) ? $_POST['city_name'] : '';
    $street = (!empty($_POST['street'])) ? $_POST['street'] : '';
    $building = (!empty($_POST['building'])) ? $_POST['building'] : '';
    $tel = (!empty($_POST['tel'])) ? $_POST['tel'] : '';
    
    // 画像
    $shop_img1 = (!empty($_FILES['shop_img1']['name'])) ? uploadImg($_FILES['shop_img1'], 'shop_img1') : '';
    $shop_img1 = ( empty($shop_img1) && !empty($dbFormData['shop_img1']) ) ? $dbFormData['shop_img1'] : $shop_img1;
    $shop_img2 = (!empty($_FILES['shop_img2']['name'])) ? uploadImg($_FILES['shop_img2'], 'shop_img2') : '';
    $shop_img2 = ( empty($shop_img2) && !empty($dbFormData['shop_img2']) ) ? $dbFormData['shop_img2'] : $shop_img2;
    $shop_img3 = (!empty($_FILES['shop_img3']['name'])) ? uploadImg($_FILES['shop_img3'], 'shop_img3') : '';
    $shop_img3 = ( empty($shop_img3) && !empty($dbFormData['shop_img3']) ) ? $dbFormData['shop_img3'] : $shop_img3;

    // バリデーションチェック
    validRequired($shop_name, 'shop_name');
    if(empty($err_msg['shop_name'])) {
        validMaxLen($shop_name, 'shop_name');
    }
    if(!empty($social_profile)) {
        validMaxLen($social_profile, 'social_profile');
    }
    validRequired($postcode, 'postcode');
    if(empty($err_msg['postcode'])) {
        validZip($postcode, 'postcode');
    }
    validRequiredSelect($prefecture_id, 'prefecture_id');
    if(is_numeric($prefecture_id)) {
        validHalfNum($prefecture_id, 'prefecture_id');
    }
    validRequired($city_name, 'city_name');
    if(empty($err_msg['city_name'])) {
        $city_id = getCityMatch($prefecture_id, $city_name, 'city_name');
    }
    validRequired($street, 'street');
    if(empty($err_msg['street'])) {
        validMaxLen($street, 'street');
    }
    if(!empty($building)) {
        validMaxLen($building, 'building');
    }
    if(!empty($tel)) {
        validMinLen($tel, 'tel', 9);
        if(empty($err_msg['tel'])) {
            validTel($tel, 'tel');
        }
    }

    // DBへ登録
    if(empty($err_msg)) {
        try {
            // 店舗登録
            $dbh = dbConnect();
            $sql = 'INSERT INTO shops (`user_id`, `shop_name`, `social_profile`, `postcode`, `prefecture_id`, `city_id`, `street`, `building`, `tel`, `map_iframe`, `shop_img1`, `shop_img2`, `shop_img3`, `create_date`) VALUES (:u_id, :shop_name, :social_profile, :postcode, :prefecture_id, :city_id, :street, :building, :tel, :shop_img1, :shop_img2, :shop_img3, :create_date);';
            $data = array(':u_id' => $u_id, ':shop_name' => $shop_name, ':social_profile' => $social_profile, ':postcode' => $postcode, ':prefecture_id' => $prefecture_id, ':city_id' => $city_id, ':street' => $street, ':building' => $building, ':tel' => $tel, ':shop_img1' => $shop_img1, ':shop_img2' => $shop_img2, ':shop_img3' => $shop_img3, ':create_date' => date('Y-m-d'));
            queryPost($dbh, $sql, $data);

            header("Location:mypage.php");
        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
}

?>
<?php
$headTitle = '店舗登録';
require('head.php');
?>
    <body>
        <!-- ヘッダー -->
        <?php require('header.php'); ?>
    
        <main id="l-main">
            <form method="post" class="c-form js-sp-menu-target" enctype="multipart/form-data">
                <h2 class="c-form__title">店舗を登録する</h2>
                <div class="u-err-msg">
                    <?= showErrMsg('common'); ?>
                </div>
                <label class="c-form__label" for="">
                    店舗名
                    <input class="c-form__input <?= showErrStyle('shop_name'); ?>" type="text" name="shop_name" value="<?= sanitize(getFormData('shop_name')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('shop_name'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    店の情報（任意）
                    <textarea class="c-form__textarea js-text-count <?= showErrStyle('social_profile'); ?>" type="text" name="social_profile"><?= sanitize(getFormData('social_profile')); ?></textarea>
                    <p class="u-text--right"><span class="js-count-num">0</span>/255</p>
                    <div class="u-err-msg">
                        <?= showErrMsg('social_profile'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    郵便番号（ハイフンなし）
                    <input class="c-form__input <?= showErrStyle('postcode'); ?>" type="text" name="postcode" value="<?= sanitize(getFormData('postcode')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('postcode'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（都道府県）
                    <select name="prefecture_id" id="" class="c-form__select <?= showErrStyle('prefecture_id'); ?>">
                        <option value="0">選択してください</option>
                        <?php foreach($pref as $key => $val): ?>
                            <option value="<?= $key; ?>" <?php echo (getFormData('prefecture_id') == $key) ? 'selected' : ''; ?>><?= $val; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="u-err-msg">
                        <?= showErrMsg('prefecture_id'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（市区町村）
                    <input class="c-form__input <?= showErrStyle('city_name'); ?>" type="text" name="city_name" value="<?= sanitize(getFormData('city_name')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('city_name'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（番地）
                    <input class="c-form__input <?= showErrStyle('street'); ?>" type="text" name="street" value="<?= sanitize(getFormData('street')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('street'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（建物名）＊任意
                    <input class="c-form__input <?= showErrStyle('building'); ?>" type="text" name="building" value="<?= sanitize(getFormData('building')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('building'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    電話番号&emsp;＊任意
                    <input class="c-form__input <?= showErrStyle('tel'); ?>" type="text" name="tel" value="<?= sanitize(getFormData('tel')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('tel'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    お店の画像
                    <div class="u-flex-between u-flex-wrap">
                        <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                            <input class="c-form__file js-file-input" type="file" name="shop_img1">
                            <img src="<?= sanitize(getFileData('shop_img1', $shop_img1)); ?>" class="c-form__img js-avatar-img" alt="">
                            <p class="c-form__areaText">ドラッグ&ドロップ</p>
                        </label>
                        <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                            <input class="c-form__file js-file-input" type="file" name="shop_img2">
                            <img src="<?= sanitize(getFileData('shop_img2', $shop_img2)); ?>" class="c-form__img js-avatar-img" alt="">
                            <p class="c-form__areaText">ドラッグ&ドロップ</p>
                        </label>
                        <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                            <input class="c-form__file js-file-input" type="file" name="shop_img3">
                            <img src="<?= sanitize(getFileData('shop_img3', $shop_img3)); ?>" class="c-form__img js-avatar-img" alt="">
                            <p class="c-form__areaText">ドラッグ&ドロップ</p>
                        </label>
                    </div>
                    <div class="u-err-msg">
                        <?= showErrMsg('shop_img1'); ?>
                        <?= showErrMsg('shop_img2'); ?>
                        <?= showErrMsg('shop_img3'); ?>
                    </div>
                </label>
                
                <input class="c-form__submit" type="submit" value="登録">
            </form>
        </main>
        
        <!-- フッター -->
        <?php require('footer.php'); ?>
        <!-- 共通ファイル -->
        <script src="js/app.js"></script>
        <!-- 専用ファイル -->
        <script src="js/app_uploadImg.js"></script>
    </body>
    </html>