<?php
// 共通ファイルの読み込み
require_once('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('ブログ削除');
debug('==============================================');

// GETパラメータ取得
$b_id = (!empty($_GET['b_id'])) ? $_GET['b_id'] : '';
// ユーザーidを格納
$u_id = $_SESSION['user_id'];
// ブログ情報を取得
$dbFormData = getBlogOne($b_id);

if(!empty($_POST['delete'])) {
    try {
        // ブログを登録
        $dbh = dbConnect();
        $sql = 'UPDATE `blogs` SET `delete_flg` = 1 WHERE `id` = :b_id';
        $data = array(':b_id' => $b_id);
        $stmt = queryPost($dbh, $sql, $data);
        if(!empty($stmt)) {
            header("Location:mypage.php");
        }
    } catch ( Exception $e ) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = MSG::UNEXPECTED;
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
            <form method="post" class="c-form js-sp-menu-target">
            <!-- パンクズリスト -->
            <div class="c-pankuzu">
                <a href="myBlogList.php<?= appendGetParam(array('b_id')); ?>" class="u-prev p-article__prev">&ang;記事一覧へ遷移する</a>
            </div><!-- /パンクズリスト -->
                <h2 class="c-form__title">記事を削除する</h2>
                <div class="u-err-msg">
                    <?= showErrMsg('common'); ?>
                </div>
                <label class="c-form__label" for="">
                    ブログタイトル
                    <p><?= sanitize(getFormData('title')); ?></p>
                </label>
                <label class="c-form__label" for="">
                    内容
                    <p><?= sanitize(getFormData('content')); ?></p>
                </label>
                <label class="c-form__label" for="">
                    TOP画像
                    <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                        <img src="<?= sanitize(getFormData('img')); ?>" class="c-form__img js-avatar-img" alt="">
                    </label>
                </label>
                
                <input name="delete" class="c-form__submit" type="submit" value="記事削除">
            </form>
        </main>
        
        <!-- フッター -->
        <?php include('footer.php'); ?>
        <!-- 専用ファイル -->
        <script src="js/app_uploadImg.js"></script>
    </body>
    </html>