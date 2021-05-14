<?php
// 共通ファイルの読み込み
require_once('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('ブログ編集');
debug('==============================================');

// GETパラメータ取得
$b_id = (!empty($_GET['b_id'])) ? $_GET['b_id'] : '';
// ユーザーidを格納
$u_id = $_SESSION['user_id'];
// ブログ情報を取得
$dbFormData = getBlogOne($b_id);

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
            $sql = 'UPDATE `blogs` SET `title` = :title, `img` = :img, `content` = :content WHERE `id` = :b_id';
            $data = array(':title' => $title, ':img' => $img, ':content' => $content, ':b_id' => $b_id);
            $stmt = queryPost($dbh, $sql, $data);
            if(!empty($stmt)) {
                header("Location:mypage.php");
            }
        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
}

?>
<?php
$headTitle = 'ブログ編集ページ';
include('head.php');
?>
    <body>
        <!-- ヘッダー -->
        <?php include('header.php'); ?>
    
        <main id="l-main">
            <form method="post" class="c-form js-sp-menu-target" enctype="multipart/form-data">
            <!-- パンクズリスト -->
            <div class="c-pankuzu">
                <a href="myBlogList.php<?= appendGetParam(array('b_id')); ?>" class="u-prev p-article__prev">&ang;記事一覧へ遷移する</a>
            </div><!-- /パンクズリスト -->
                <h2 class="c-form__title">記事を編集する</h2>
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
                    <textarea class="c-form__textarea <?= showErrStyle('content'); ?>" name="content" id="" placeholder="ブログの内容"><?= sanitize(getFormData('content')); ?></textarea>
                    <div class="u-err-msg">
                        <?= showErrMsg('content'); ?>
                    </div>
                </label>
                <label class="c-form__label" for="">
                    TOP画像
                    <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                        <input class="c-form__file js-file-input" type="file" name="img">
                        <img src="<?= sanitize(getFormData('img')); ?>" class="c-form__img js-avatar-img" alt="">
                        <p class="c-form__areaText">ドラッグ&ドロップ</p>
                    </label>
                    <div class="u-err-msg">
                        <?= showErrMsg('img'); ?>
                    </div>
                </label>
                
                <input class="c-form__submit" type="submit" value="記事更新">
            </form>
        </main>
        
        <!-- フッター -->
        <?php include('footer.php'); ?>
        <!-- 専用ファイル -->
        <script src="js/app_uploadImg.js"></script>
    </body>
    </html>