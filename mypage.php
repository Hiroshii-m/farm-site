<?php

// 共通ファイルの読み込み
require_once('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('マイページ画面');
debug('==============================================');

// ユーザーIDを格納
$u_id = $_SESSION['user_id'];
// 店舗idを取得
$s_id = getShopId($u_id);
// 登録した商品情報を取得
$products = getProducts($s_id);
// お気に入りの店舗情報を取得
$shops = getFavoShop($u_id);
// 表示する商品のカウント初期化
$count_product = 0;
// ブログ記事を取得
$blogs = getBlogList($s_id);

// POSTされた場合、登録した商品を追加取得
if(!empty($_POST['add_product'])) {
    // 商品を追加
    $count_product = (!empty($_POST['count_product'])) ? $_POST['count_product'] : 0;
    $count_product++;
    $products = array_merge($products, getProducts($s_id, $count_product));
}
if(!empty($_POST['delete_id'])) {
    $delete_id = (!empty($_POST['delete_id'])) ? $_POST['delete_id'] : '';
    if(!empty($_POST['yes'])) {
        require('delete_product.php');
    }
    $_POST = array();
}

?>
<?php
$headTitle = 'マイページ';
include_once('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php include_once('header.php'); ?>
    
    <!-- モーダル -->
    <section class="c-dropProduct js-modal">
        <div class="c-dropProduct__body js-modal-body">
            <i class="fas fa-times c-dropProduct__close js-modal-close"></i>
            <p class="c-dropProduct__head">本当にその商品を削除しますか？</p>
            <form action="" method="post" class="u-flex-center">
                <input class="js-modal-value" type="hidden" name="delete_id" value="">
                <button name="yes" value="1" class="c-dropProduct__btn">はい</button>
                <p name="no" value="1" class="c-dropProduct__btn js-modal-no">いいえ</p>
            </form>
        </div>
    </section><!-- /モーダル -->

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">
            
            <!-- 最近登録された販売所 -->
            <section id="l-sale">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">お気に入りの販売所</h2>
                    <ul class="c-submission__body">
                        <?php if(!empty($shops['data'])){ ?>
                            <?php foreach($shops['data'] as $key => $val): ?>
                            <li class="c-submission__item">
                                <div class="c-submission__visual">
                                    <div class="c-submission__img"><img src="<?= sanitize(showImg($val['shop_img1'])); ?>" alt=""></div>
                                    <p class="c-submission__author"><?= sanitize(showData($val['screen_name'])); ?></p>
                                </div>
                                <div class="c-submission__content">
                                    <a href="single.php<?= (!empty(appendGetParam())) ? appendGetParam().'&shop_id='.$val['shop_id'] : '?shop_id='.$val['shop_id']; ?>" class="c-submission__tit"><?= sanitize(showData($val['shop_name'])); ?></a>
                                    <div class="c-submission__detail js-card-text">
                                        <?= sanitize(showData($val['social_profile'])); ?>
                                    </div>
                                </div>
                                <div class="c-submission__icon">
                                    <i class="fa-heart c-submission__fav js-click-animation <?= (isFavorite($val['shop_id'], $u_id) === true) ? 'fas is-active' : 'far'; ?>" data-shopid="<?= sanitize($val['shop_id']); ?>"></i>
                                    <i class="fa-heart c-submission__fav2 js-click-animation2 <?= (isFavorite($val['shop_id'], $u_id) === true) ? 'far is-active' : 'fas'; ?>"></i>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        <?php }else{ ?>
                        <p>お気に入り登録されていません。</p>
                        <?php } ?>
                    </ul>
                    <a href="favoShopList.php" class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</a>
                </div>
            </section><!-- /最近登録された販売所 -->

            <!-- 作成した記事一覧 -->
            <section id="l-blogList">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">作成した記事</h2>
                    <ul class="c-submission__body">
                    <?php if(!empty($blogs['data'])): ?>
                        <?php foreach($blogs['data'] as $key => $val): ?>
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
                                <a href="editBlog.php<?= (!empty(appendGetParam())) ? appendGetParam().'&b_id='.$val['id'].'&s_id='.$s_id : '?b_id='.$val['id'].'&s_id='.$s_id; ?>" class="p-product__btn p-product__bg1">編集する</a>
                                <a href="deleteBlog.php<?= (!empty(appendGetParam())) ? appendGetParam().'&b_id='.$val['id'].'&s_id='.$s_id : '?b_id='.$val['id'].'&s_id='.$s_id; ?>" name="delete_id" value="" class="p-product__btn p-product__bg2 js-delete-product">削除する</a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </ul>
                    <a href="myBlogList.php?s_id=<?= $s_id; ?>" class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</a>
                </div>
            </section><!-- /作成した記事一覧 -->

            <?php if(!empty($products)){ ?>
            <!-- 登録した商品 -->
            <section id="l-blog">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">登録した商品</h2>
                    <ul class="c-submission__body">
                        <?php foreach($products as $key => $val): ?>
                        <li class="p-product__list">
                            <details <?= ($key === 0) ? 'open' : ''; ?>>
                                <summary class="p-product__summary">
                                    <span class="p-product__point ">【<i class="fas fa-shopping-bag u-padding-1"></i>商品名】</span><?= showData($val['p_name']); ?>
                                    <span class="p-product__point ">【<i class="fas fa-yen-sign u-padding-1"></i>値段】</span><?= showData($val['p_value']); ?>円
                                    <span class="p-product__point ">【<i class="fas fa-balance-scale u-padding-1"></i>数量・質量】</span><?= showData($val['p_number']); ?>
                                </summary>
                                <div class="p-product__info u-flex">
                                    <div class="p-product__img">
                                        <img src="<?= showImg($val['p_img']); ?>" alt="">
                                    </div>
                                    <div class="p-product__explain">
                                        <p class="u-font-weight-bold">＜カテゴリ＞</p>
                                        <p><?= showData($val['category_name']); ?></p>
                                        <p class="u-font-weight-bold">＜収穫時期・販売時期＞</p>
                                        <p><?= showData($val['term']); ?></p>
                                        <p class="u-font-weight-bold">＜説明＞</p>
                                        <p><?= showData($val['p_detail']); ?></p>
                                    </div>
                                </div>
                                <div class="p-product__edit">
                                    <a href="editProduct.php?p_id=<?= showData($val['id']); ?>" class="p-product__btn p-product__bg1">編集する</a>
                                    <a name="delete_id" value="<?= showData($val['id']); ?>" class="p-product__btn p-product__bg2 js-delete-product">削除する</a>
                                </div>
                            </details>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section><!-- /登録した商品 -->
            <?php } ?>

        </div>
        <!-- サイドバー -->
        <?php include('sidebar_mypage.php'); ?>
    </main>

    <!-- フッター -->
    <?php include_once('footer.php'); ?>
    <!-- 個別のjsファイル -->
    <script src="js/app_modal.js"></script>
</body>
</html>