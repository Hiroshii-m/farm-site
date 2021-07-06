<?php
// 予想時間: 3h
// かかった時間：1h18mi

// 共通ファイルの読み込み
require_once('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('ブログ作成');
debug('==============================================');

// ユーザーidを格納
$u_id = $_SESSION['user_id'];
// 店舗情報を取得
$shop = getShop($u_id);
$s_id = $shop['id'];

if(!empty($_POST)) {
    $title = (!empty($_POST['title'])) ? $_POST['title'] : '';
    $content = (!empty($_POST['content'])) ? $_POST['content'] : '';
    
    validRequired($title, 'title');
    if(empty($err_msg['title'])) {
        validMaxLen($title, 'title');
    }
    validRequired($content, 'content');
    if(empty($err_msg['content'])) {
        validMaxLen($content, 'content');
    }
    if(empty($err_msg)) {
        $img = (!empty($_FILES['img']['name'])) ? uploadImg($_FILES['img'], 'img') : '';
        $img = ( empty($img) && !empty($dbFormData['img']) ) ? $dbFormData['img'] : $img;
    }

    if(empty($err_msg)) {
        try {
            // ブログを登録
            $dbh = dbConnect();
            $sql = 'INSERT INTO `blogs`(`shop_id`, `title`, `img`, `content`, `create_date`) VALUES(:s_id, :title, :img, :content, :create_date)';
            $data = array(':s_id' => $s_id, ':title' => $title, ':img' => $img, ':content' => $content, ':create_date' => date('Y-m-d'));
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
$headTitle = 'ブログ作成ページ';
include('head.php');
?>
    <body>
        <!-- ヘッダー -->
        <?php include('header.php'); ?>
    
        <main id="l-main">
            <form method="post" class="c-form js-sp-menu-target" enctype="multipart/form-data">
                <h2 class="c-form__title">記事を作成する</h2>
                <div class="u-err-msg">
                    <?= showErrMsg('common'); ?>
                </div>
                <label class="c-form__label" for="">
                    ブログタイトル
                    <input class="c-form__input <?= showErrStyle('title'); ?>" type="text" name="title" value="<?= sanitize(getFormData('title')); ?>">
                    <div class="u-err-msg">
                        <?= showErrMsg('title'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    内容
                    <textarea class="c-form__textarea js-text-count <?= showErrStyle('content'); ?>" name="content" id="" placeholder="ブログの内容"><?= sanitize(getFormData('content')); ?></textarea>
                    <p class="u-text--right"><span class="js-count-num">0</span>/255</p>
                    <div class="u-err-msg">
                        <?= showErrMsg('content'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    TOP画像
                    <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                        <input class="c-form__file js-file-input" type="file" name="img">
                        <img src="" class="c-form__img js-avatar-img" alt="">
                        <p class="c-form__areaText">ドラッグ&ドロップ</p>
                    </label>
                    <div class="u-err-msg">
                        <?= showErrMsg('img'); ?>
                    </div>
                </label>
                
                <input class="c-form__submit" type="submit" value="記事作成">
            </form>
        </main>
        
        <!-- フッター -->
        <?php include('footer.php'); ?>
        <!-- 専用ファイル -->
        <script src="js/app_uploadImg.js"></script>
    </body>
    </html>