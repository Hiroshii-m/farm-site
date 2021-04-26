<?php
// 予想時間: 3h
// かかった時間：1h18mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('商品登録');
debug('==============================================');

// カテゴリーを取得
$category = getCategory();
// ユーザーidを格納
$u_id = $_SESSION['user_id'];
// 店舗情報を取得
$shop = getShop($u_id);
$s_id = $shop['id'];

if(!empty($_POST)) {
    $p_name = (!empty($_POST['p_name'])) ? $_POST['p_name'] : '';
    $p_value = (!empty($_POST['p_value'])) ? $_POST['p_value'] : 0;
    $p_number = (!empty($_POST['p_number'])) ? $_POST['p_number'] : '';
    $p_detail = (!empty($_POST['p_detail'])) ? $_POST['p_detail'] : '';
    $term = (!empty($_POST['term'])) ? $_POST['term'] : '';
    $c_id = ($_POST['c_id'] !== 0) ? $_POST['c_id'] : 0;
    
    validRequired($p_name, 'p_name');
    if(empty($err_msg['p_name'])) {
        validMaxLen($p_name, 'p_name');
    }
    if(empty($err_msg)) {
        $p_img = (!empty($_FILES['p_img']['name'])) ? uploadImg($_FILES['p_img'], 'p_img') : '';
        $p_img = ( empty($p_img) && !empty($dbFormData['p_img']) ) ? $dbFormData['p_img'] : $p_img;
    }

    if(empty($err_msg)) {
        try {
            // 商品を登録
            $dbh = dbConnect();
            $sql = 'INSERT INTO products(`shop_id`, `user_id`, `p_name`, `p_detail`, `category_id`, `term`, `p_value`, `p_number`, `p_img`, `create_date`) VALUES(:s_id, :u_id, :p_name, :p_detail, :c_id, :term, :p_value, :p_number, :p_img, :create_date)';
            $data = array(':s_id' => $s_id, ':u_id' => $u_id, ':p_name' => $p_name, ':p_detail' => $p_detail, ':c_id' => $c_id, ':term' => $term, ':p_value' => $p_value, ':p_number' => $p_number, ':p_img' => $p_img, ':create_date' => date('Y-m-d H:i:s'));
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
$headTitle = '商品登録ページ';
require('head.php');
?>
    <body>
        <!-- ヘッダー -->
        <?php require('header.php'); ?>
    
        <main id="l-main">
            <form method="post" class="c-form js-sp-menu-target" enctype="multipart/form-data">
                <h2 class="c-form__title">商品を登録する</h2>
                <div class="u-err-msg">
                    <?= showErrMsg('common'); ?>
                </div>
                <label class="c-form__label" for="">
                    商品名
                    <input class="c-form__input <?= showErrStyle('p_name'); ?>" type="text" name="p_name" value="<?= sanitize(getFormData('p_name')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('p_name'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    値段
                    <input class="c-form__input <?= showErrStyle('p_value'); ?>" type="number" min="0" name="p_value" value="<?= sanitize(getFormData('p_value')); ?>" placeholder="円">
                    <div class="u-err-msg">
                        <?= showErrMsg('p_value'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    数量・質量
                    <input class="c-form__input <?= showErrStyle('p_number'); ?>" type="text" name="p_number" value="<?= sanitize(getFormData('p_number')); ?>" placeholder="グラム（g）、数（本、個）">
                    <div class="u-err-msg">
                        <?= showErrMsg('p_number'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    商品情報
                    <textarea class="c-form__textarea <?= showErrStyle('p_detail'); ?>" name="p_detail" id="" value="<?= sanitize(getFormData('p_detail')); ?>" placeholder="商品の特徴（見た目、形、味、大きさ等）"></textarea>
                    <div class="u-err-msg">
                        <?= showErrMsg('p_detail'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    収穫時期・販売時期
                    <textarea class="c-form__textarea <?= showErrStyle('term'); ?>" name="term" id="" value="<?= sanitize(getFormData('term')); ?>" placeholder="春、夏、秋、冬、3月〜等"></textarea>
                    <div class="u-err-msg">
                        <?= showErrMsg('term'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    カテゴリー
                    <select name="c_id" id="" class="c-form__select <?= showErrStyle('c_id'); ?>">
                        <option value="0">選択してください</option>
                        <?php foreach($category as $key => $val): ?>
                            <option value="<?= $val['id']; ?>"><?= $val['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="u-err-msg">
                        <?= showErrMsg('c_id'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    商品画像
                    <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                        <input class="c-form__file js-file-input" type="file" name="p_img">
                        <img src="" class="c-form__img js-avatar-img" alt="">
                        <p class="c-form__areaText">ドラッグ&ドロップ</p>
                    </label>
                    <div class="u-err-msg">
                        <?= showErrMsg('p_img'); ?>
                    </div>
                </label>
                
                <input class="c-form__submit" type="submit" value="登録">
            </form>
        </main>
        
        <!-- フッター -->
        <?php require('footer.php'); ?>
        <!-- 専用ファイル -->
        <script src="js/app_uploadImg.js"></script>
    </body>
    </html>