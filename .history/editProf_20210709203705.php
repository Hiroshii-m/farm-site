<?php
// 予想時間（プロフィール編集画面）：3h
// かかった時間：3h58mi
// 予想時間（機能面）:3h
// かかった時間：6h45mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('プロフィール編集画面');
debug('==============================================');

$u_id = $_SESSION['user_id'];
$dbFormData = getUser($u_id);
$city_name = ($dbFormData['city_id'] !== 0) ? getCityName($dbFormData['city_id']) : '';
$dbFormData['city_name'] = $city_name;

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

// POSTチェック
if(!empty($_POST)) {
    // 入力された値を変数に格納
    $screen_name = (!empty($_POST['screen_name'])) ? $_POST['screen_name'] : '';
    $last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : '';
    $first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : '';
    $last_name_kana = (!empty($_POST['last_name_kana'])) ? $_POST['last_name_kana'] : '';
    $first_name_kana = (!empty($_POST['first_name_kana'])) ? $_POST['first_name_kana'] : '';
    $birthday_year = (!empty($_POST['birthday_year'])) ? $_POST['birthday_year'] : 0;
    $birthday_month = (!empty($_POST['birthday_month'])) ? $_POST['birthday_month'] : 0;
    $birthday_day = (!empty($_POST['birthday_day'])) ? $_POST['birthday_day'] : 0;
    $postcode = (!empty($_POST['postcode'])) ? $_POST['postcode'] : '';
    $prefecture_id = (!empty($_POST['prefecture_id'])) ? $_POST['prefecture_id'] : 0;
    $city_name = (!empty($_POST['city_name'])) ? $_POST['city_name'] : '';
    $street = (!empty($_POST['street'])) ? $_POST['street'] : '';
    $building = (!empty($_POST['building'])) ? $_POST['building'] : '';

    // バリデーションチェック
    if(!empty($screen_name)) {
        validMaxLen($screen_name, 'screen_name', 30, VALID::TEXTMAX_30);
    }
    if(!empty($last_name)) {
        validMaxLen($last_name, 'last_name', 30, VALID::TEXTMAX_30);
        if(empty($err_msg['last_name'])) {
            validKanjiHira($last_name, 'last_name');
        }
    }
    if(!empty($first_name)) {
        validMaxLen($first_name, 'first_name', 30, VALID::TEXTMAX_30);
        if(empty($err_msg['first_name'])) {
            validKanjiHira($first_name, 'first_name');
        }
    }
    if(!empty($last_name_kana)) {
        validMaxLen($last_name_kana, 'last_name_kana', 30, VALID::TEXTMAX_30);
        if(empty($err_msg['last_name_kana'])) {
            validKana($last_name_kana, 'last_name_kana');
        }
    }
    if(!empty($first_name_kana)) {
        validMaxLen($first_name_kana, 'first_name_kana', 30, VALID::TEXTMAX_30);
        if(empty($err_msg['first_name_kana'])) {
            validKana($first_name_kana, 'first_name_kana');
        }
    }
    if(is_numeric($postcode) || !empty($postcode)) {
        validZip($postcode, 'postcode');
    }
    if(is_numeric($prefecture_id)) {
        validHalfNum($prefecture_id, 'prefecture_id');
    }
    // 市区町村データが合っているか
    if(!empty($prefecture_id) && !empty($city_name)) {
        $city_id = getCityMatch($prefecture_id, $city_name, 'city_name');
    }
    if(!empty($street)) {
        validMaxLen($street, 'street');
    }
    if(!empty($building)) {
        validMaxLen($building, 'building');
    }

    // 全てエラーがなければ、ファイルをアップロードし、パスを変数へ格納
    if(empty($err_msg)) {
        // 一旦飛ばす。FILEのなかみに値が入らない。
        $avatar_image_path = (!empty($_FILES['avatar_image_path']['name'])) ? uploadImg($_FILES['avatar_image_path'], 'avatar_image_path') : '';
        $avatar_image_path = ( empty($avatar_image_path) && !empty($dbFormData['avatar_image_path']) ) ? $dbFormData['avatar_image_path'] : $avatar_image_path;
    }

    // DBへ更新する
    if(empty($err_msg)) {
        try {
            $dbh = dbConnect();
            $sql = 'UPDATE users SET `screen_name` = :s_name, `last_name` = :l_name, `first_name` = :f_name, `last_name_kana` = :l_name_kana, `first_name_kana` = :f_name_kana, `birthday_year` = :b_year, `birthday_month` = :b_month, `birthday_day` = :b_day, `avatar_image_path` = :a_path, `prefecture_id` = :p_id, `city_id` = :c_id, `street` = :street, `building` = :building, `postcode` = :postcode WHERE `id` = :u_id';
            $data = array(':u_id' => $u_id, ':s_name' => $screen_name, ':l_name' => $last_name, ':f_name' => $first_name, ':l_name_kana' => $last_name_kana, ':f_name_kana' => $first_name_kana, ':b_year' => $birthday_year, ':b_month' => $birthday_month, ':b_day' => $birthday_day, ':a_path' => $avatar_image_path, ':p_id' => $prefecture_id, ':c_id' => $city_id, ':street' => $street, ':building' => $building, ':postcode' => $postcode);
            $stmt = queryPost($dbh, $sql, $data);

            // マイページへ移動
            header("Location:mypage.php");
        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
}

?>

<?php
$headTitle = 'プロフィール編集';
include('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php
    include('header.php');
    ?>

    <main id="l-main">
        <form method="post" class="c-form js-sp-menu-target" enctype="multipart/form-data">
            <h2 class="c-form__title">プロフィール編集</h2>
            <div class="u-err-msg">
                <?= showErrMsg('common'); ?>
            </div>
            <label class="c-form__label" for="">
                プロフィール表示名
                <input class="c-form__input <?= showErrStyle('screen_name'); ?>" type="text" name="screen_name" value="<?= sanitize(getFormData('screen_name')); ?>">
                <div class="u-err-msg">
                    <?= showErrMsg('screen_name'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                氏名（全角）
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide2 <?= showErrStyle('last_name'); ?>" type="text" name="last_name" placeholder="姓" value="<?= sanitize(getFormData('last_name')); ?>">
                    <input class="c-form__input c-form__divide2 <?= showErrStyle('first_name'); ?>" type="text" name="first_name" placeholder="名" value="<?= sanitize(getFormData('first_name')); ?>">
                </div>
                <div class="u-err-msg">
                    <?= showErrMsg('last_name', 'first_name'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                シメイ（全角）
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide2 <?= showErrStyle('last_name_kana'); ?>" type="text" name="last_name_kana" placeholder="姓カナ" value="<?= sanitize(getFormData('last_name_kana')); ?>">
                    <input class="c-form__input c-form__divide2 <?= showErrStyle('first_name_kana'); ?>" type="text" name="first_name_kana" placeholder="名カナ" value="<?= sanitize(getFormData('first_name_kana')); ?>">
                </div>
                <div class="u-err-msg">
                    <?= showErrMsg('last_name_kana', 'first_name_kana'); ?>
                </div>
            </label>
            <label class="c-form__label" for="">
                生年月日
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide3 <?= showErrStyle('birthday_year'); ?>" type="number" min="1900" max="2014" name="birthday_year" placeholder="年" value="<?= sanitize(getFormData('birthday_year')); ?>">
                    <input class="c-form__input c-form__divide3 <?= showErrStyle('birthday_month'); ?>" type="number" min="1" max="12" name="birthday_month" placeholder="月" value="<?= sanitize(getFormData('birthday_month')); ?>">
                    <input class="c-form__input c-form__divide3 <?= showErrStyle('last_name_day'); ?>" type="number" min="1" max="31" name="birthday_day" placeholder="日" value="<?= sanitize(getFormData('birthday_day')); ?>">
                </div>
                <div class="u-err-msg">
                    <?= showErrMsg('birthday_year'); ?>
                    <?= showErrMsg('birthday_month'); ?>
                    <?= showErrMsg('birthday_day'); ?>
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
                住所（市区町村）（例）札幌市中央区,世田谷区,明石市...
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
                TOP画像 ＊画像サイズは、3MB以下にしてください
                <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                    <input class="c-form__file js-file-input" type="file" name="avatar_image_path">
                    <img class="c-form__img js-avatar-img" alt="" src="<?= sanitize(getFormData('avatar_image_path')); ?>">
                    <p class="c-form__areaText">ドラッグ&ドロップ</p>
                </label>
                <div class="u-err-msg">
                    <?= showErrMsg('avatar_image_path'); ?>
                </div>
            </label>
            
            <input class="c-form__submit" type="submit" value="変更">
        </form>
    </main>
    
    <!-- フッター -->
    <?php include('footer.php'); ?>
    <!-- プロフィール編集画面のjsファイル -->
    <script src="js/app_uploadImg.js"></script>
</body>
</html>