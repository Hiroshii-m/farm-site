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
// 表示する商品のカウント初期化
$count_product = 0;

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
                        <li class="c-submission__item">
                            <div class="c-submission__visual">
                                <div class="c-submission__img"><img src="images/pic2.jpeg" alt=""></div>
                                <p class="c-submission__author">北海の農家</p>
                            </div>
                            <div class="c-submission__content">
                                <a href="" class="c-submission__tit">今こそ五感で楽しむ「バナナ」</a>
                                <div class="c-submission__detail">
                                    どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。
                                </div>
                            </div>
                            <div class="c-submission__icon">
                                <i class="far fa-heart c-submission__fav js-click-animation"></i>
                                <i class="fas fa-heart c-submission__fav2 js-click-animation2"></i>
                            </div>
                        </li>
                        <li class="c-submission__item">
                            <div class="c-submission__visual">
                                <div class="c-submission__img"><img src="images/pic2.jpeg" alt=""></div>
                                <p class="c-submission__author">北海の農家</p>
                            </div>
                            <div class="c-submission__content">
                                <a href="" class="c-submission__tit">今こそ五感で楽しむ「バナナ」</a>
                                <div class="c-submission__detail">
                                    どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。
                                </div>
                            </div>
                            <div class="c-submission__icon">
                                <i class="far fa-heart c-submission__fav js-click-animation"></i>
                                <i class="fas fa-heart c-submission__fav2 js-click-animation2"></i>
                            </div>
                        </li>
                        <li class="c-submission__item">
                            <div class="c-submission__visual">
                                <div class="c-submission__img"><img src="images/pic2.jpeg" alt=""></div>
                                <p class="c-submission__author">北海の農家</p>
                            </div>
                            <div class="c-submission__content">
                                <a href="" class="c-submission__tit">今こそ五感で楽しむ「バナナ」</a>
                                <div class="c-submission__detail">
                                    どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。どうも、北海の農家です。
                                </div>
                            </div>
                            <div class="c-submission__icon">
                                <i class="far fa-heart c-submission__fav js-click-animation"></i>
                                <i class="fas fa-heart c-submission__fav2 js-click-animation2"></i>
                            </div>
                        </li>
                    </ul>
                    <button class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</button>
                </div>
            </section><!-- /最近登録された販売所 -->

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
                                        <img src="images/pic3.jpeg" alt="">
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
                    <form action="" method="post">
                        <input type="hidden" name="count_product" value="<?= $count_product; ?>">
                        <button name="add_product" class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color" value="1">もっと見る</button>
                    </form>
                </div>
            </section><!-- /登録した商品 -->
            <?php } ?>

        </div>
        <!-- サイドバー -->
        <?php include('sidebar_mypage.php'); ?>
    </main>


    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>
    <!-- フッター -->
    <?php include_once('footer.php'); ?>
    <!-- 個別のjsファイル -->
    <script src="js/app_icon.js"></script>
    <script src="js/app_modal.js"></script>
</body>
</html>