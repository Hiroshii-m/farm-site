<?php
// 予想時間:3h
// かかった時間：2h10mi

// 共通ファイルの読み込み
require('function.php');

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

if(!empty($_POST)) {
    $shop_name = (!empty($_POST['shop_name'])) ? $_POST['shop_name'] : '';
    $social_profile = (!empty($_POST['social_profile'])) ? $_POST['social_profile'] : '';
    $postcode = (!empty($_POST['postcode'])) ? $_POST['postcode'] : '';
    $prefecture_id = (!empty($_POST['prefecture_id'])) ? $_POST['prefecture_id'] : 0;
    $city_name = (!empty($_POST['city_name'])) ? $_POST['city_name'] : '';
    $street = (!empty($_POST['street'])) ? $_POST['street'] : '';
    $building = (!empty($_POST['building'])) ? $_POST['building'] : '';
    $tel = (!empty($_POST['tel'])) ? $_POST['tel'] : '';

    // バリデーションチェック
    validRequired($shop_name, 'shop_name');
    if(empty($err_msg['shop_name'])) {
        validMaxLen($shop_name, 'shop_name');
    }
    if(!empty($social_profile)) {
        validMaxLen($social_profile, 'social_profile');
    }
    validRequired($postcode, 'postcode');
    if(!empty($err_msg['postcode'])) {
        validZip($postcode, 'postcode');
    }
    validRequired($prefecture_id, 'prefecture_id');
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
    // 全てエラーがなければ、ファイルをアップロードし、パスを変数へ格納
    if(empty($err_msg)) {
        // 一旦飛ばす。FILEのなかみに値が入らない。
        $shop_img = (!empty($_FILES['shop_img']['name'])) ? uploadImg($_FILES['shop_img'], 'shop_img') : '';
        $shop_img = ( empty($shop_img) && !empty($dbFormData['shop_img']) ) ? $dbFormData['shop_img'] : $shop_img;
    }

    // DBへ登録
    if(empty($err_msg)) {
        try {
            $dbh = dbConnect();
            $sql = 'INSERT INTO users (`shop_name`, `social_profile`, `postcode`, `prefecture_id`, `city_id`, `street`, `building`, `shop_img`) VALUES (:shop_name, :social_profile, :postcode, :prefecture_id, :city_id, :street, :building, :shop_img);';
            $data = array(':shop_name' => $shop_name, ':social_profile' => $social_profile, ':postcode' => $postcode, ':prefecture_id' => $prefecture_id, ':city_id' => $city_id, ':street' => $street, ':building' => $building, ':shop_img' => $shop_img);
            $stmt = queryPost($dbh, $sql, $data);
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
            <form action="post" class="c-form js-sp-menu-target">
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
                    店の情報
                    <input class="c-form__input <?= showErrStyle('social_profile'); ?>" type="text" name="social_profile" value="<?= sanitize(getFormData('social_profile')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('social_profile'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    カテゴリー
                    <div>
                        <label class="u-flex" for="grain">
                            <input class="c-form__check" type="checkbox" name="" id="grain">
                            <p id="">米・穀物・シリアル</p>
                        </label>
                        <label class="u-flex" for="vegetable">
                            <input class="c-form__check" type="checkbox" name="" id="vegetable">
                            <p id="">野菜</p>
                        </label>
                        <label class="u-flex" for="fish">
                            <input class="c-form__check" type="checkbox" name="" id="fish">
                            <p id="">水産物</p>
                        </label>
                        <label class="u-flex" for="meet">
                            <input class="c-form__check" type="checkbox" name="" id="meet">
                            <p id="">肉・肉加工品</p>
                        </label>
                        <label class="u-flex" for="egg">
                            <input class="c-form__check" type="checkbox" name="" id="egg">
                            <p id="">卵・チーズ・乳製品</p>
                        </label>
                        <label class="u-flex" for="fruit">
                            <input class="c-form__check" type="checkbox" name="" id="fruit">
                            <p id="">果物</p>
                        </label>
                        <label class="u-flex" for="bean">
                            <input class="c-form__check" type="checkbox" name="" id="bean">
                            <p id="">豆腐・納豆・漬物</p>
                        </label>
                        <label class="u-flex" for="jam">
                            <input class="c-form__check" type="checkbox" name="" id="jam">
                            <p id="">ジャム・ハチミツ</p>
                        </label>
                    </div>
                    <div class="u-err-msg">
                        <?= showErrMsg('category'); ?>
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
                    <input class="c-form__input <?= showErrStyle('city_name'); ?>" type="text" name="city_name">
                    <div class="u-err-msg">
                        <?= showErrMsg('city_name'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（番地）
                    <input class="c-form__input <?= showErrStyle('street'); ?>" type="text" name="street">
                    <div class="u-err-msg">
                        <?= showErrMsg('street'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    住所（建物名）＊任意
                    <input class="c-form__input <?= showErrStyle('building'); ?>" type="text" name="building">
                    <div class="u-err-msg">
                        <?= showErrMsg('building'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    電話番号&emsp;＊任意
                    <input class="c-form__input <?= showErrStyle('tel'); ?>" type="text" name="tel">
                    <div class="u-err-msg">
                        <?= showErrMsg('tel'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    お店の画像
                    <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                        <input class="c-form__file js-file-input" type="file" name="shop_img">
                        <img src="" class="c-form__img js-avatar-img" alt="">
                        <p class="c-form__areaText">ドラッグ&ドロップ</p>
                    </label>
                    <div class="u-err-msg">
                        <?= showErrMsg('shop_img'); ?>
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
        <script src="js/uploadImg.js"></script>
    </body>
    </html>