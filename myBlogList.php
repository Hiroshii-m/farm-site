<?php
// 共通ファイルの読み込み
require_once('function.php');
require('auth.php');

debug('==============================================');
debug('ブログ一覧画面');
debug('==============================================');

// 変数初期化
// ================================
$dbFromData = array();

// GETパラメータを取得
// ================================
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
$currentPageNum = (!empty($_GET['page_id'])) ? $_GET['page_id'] : 1;
$s_id = (!empty($_GET['s_id'])) ? $_GET['s_id'] : '';
// 表示件数
$listSpan = 10;
// 現在のレコードの先頭を算出
$currentMinNum = (($currentPageNum-1) * $listSpan);
$dbFormData = getBlogList($s_id, $currentMinNum, $listSpan);


?>
<?php
$headTitle = 'ブログ一覧画面';
include_once('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php include_once('header.php'); ?>

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">
            <!-- ブログ一覧 -->
            <section id="l-shopList" class="">
                <div class="p-shopList">
                    <h2 class="p-shopList__heading">
                        <p class="p-shopList__title">ブログ一覧</p>
                        <p class="p-shopList__showNum">
                        <?php if(1 <= $currentPageNum){ ?>
                            <?= $currentMinNum + 1; ?>~<?= $currentMinNum + count($dbFormData['data']); ?>
                        <?php }else{ echo '0'; } ?>
                            件表示/合計<?= (!empty($dbFormData['total'])) ? $dbFormData['total'] : '0'; ?>件ヒット</p>
                    </h2>
                    <?php if(!empty($dbFormData['data'])) { ?>
                        <ul class="p-shopList__body">
                        <?php foreach($dbFormData['data'] as $key => $val): ?>
                        <li class="c-card">
                            <div class="c-card__head">
                                <div class="c-card__img">
                                    <img src="<?= sanitize(showImg($val['img'])); ?>" alt="">
                                </div>
                                <div class="c-card__summary u-margin-left-20">
                                    <a class="c-card__title"><?= sanitize($val['title']); ?></a>
                                </div>
                            </div>
                            <div class="c-card__body">
                                <?= sanitize($val['content']); ?>
                            </div>
                            <div class="p-product__edit">
                                <a href="editBlog.php<?= (!empty(appendGetParam())) ? appendGetParam().'&b_id='.$val['id'] : '?b_id='.$val['id']; ?>" class="p-product__btn p-product__bg1">編集する</a>
                                <a href="deleteBlog.php<?= (!empty(appendGetParam())) ? appendGetParam().'&b_id='.$val['id'] : '?b_id='.$val['id']; ?>" name="delete_id" value="" class="p-product__btn p-product__bg2 js-delete-product">削除する</a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- ページング -->
                    <?php pagination($currentPageNum, $dbFormData['total_page']); ?>
                    <?php }else{ ?>
                        <p>登録された記事はありません。</p>
                    <?php } ?>
                </div>
            </section><!-- /店舗一覧 -->
            
        </div>
        <!-- サイドバー -->
        <?php include('sidebar_mypage.php'); ?>
    </main>

    <!-- フッター -->
    <?php include_once('footer.php'); ?>
</body>
</html>