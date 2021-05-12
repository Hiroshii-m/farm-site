<?php
// 予想時間:1h
// かかった時間：

// 共通ファイルの読み込み
require_once('function.php');
require('auth.php');

debug('==============================================');
debug('お気に入り一覧画面');
debug('==============================================');

// 変数初期化
// ================================
$dbShopData = array();

// GETパラメータを取得
// ================================
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
$currentPageNum = (!empty($_GET['page_id'])) ? $_GET['page_id'] : 1;
// 表示件数
$listSpan = 10;
// 現在のレコードの先頭を算出
$currentMinNum = (($currentPageNum-1) * $listSpan);
$dbShopData = getFavoShop($u_id, $currentMinNum, $listSpan);
// debug(print_r($dbShopData, true));


?>
<?php
$headTitle = 'お気に入り一覧画面';
include_once('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php include_once('header.php'); ?>

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">
        
            <!-- 店舗一覧 -->
            <section id="l-shopList" class="">
                <div class="p-shopList">
                    <h2 class="p-shopList__heading">
                        <p class="p-shopList__title">お気に入り一覧</p>
                        <p class="p-shopList__showNum">
                        <?php if(1 <= $currentPageNum){ ?>
                            <?= $currentMinNum + 1; ?>~<?= $currentMinNum + count($dbShopData['data']); ?>
                        <?php }else{ echo '0'; } ?>
                            件表示/合計<?= (!empty($dbShopData['total'])) ? $dbShopData['total'] : '0'; ?>件ヒット</p>
                    </h2>
                    <?php if(!empty($dbShopData)) { ?>
                    <ul class="p-shopList__body">
                        <?php foreach($dbShopData['data'] as $key => $val): ?>
                        <li class="c-card">
                            <div class="c-card__head u-flex-between">
                                <div class="c-card__img">
                                    <img src="<?= sanitize(showImg($val['shop_img1'])); ?>" alt="">
                                </div>
                                <div class="c-card__summary">
                                    <p class="c-card__category">野菜</p>
                                    <a href="single.php<?= appendGetParam().'&shop_id='.sanitize($val['shop_id']); ?>" class="c-card__title"><?= sanitize(showData($val['shop_name'])); ?></a>
                                </div>
                                <div class="c-submission__icon">
                                    <i class="fa-heart c-submission__fav js-click-animation <?= ((!empty($u_id)) && isFavorite($val['shop_id'], $u_id)) ? 'fas is-active' : 'far'; ?>" data-shopid="<?= sanitize($val['shop_id']); ?>"></i>
                                    <i class="fa-heart c-submission__fav2 js-click-animation2 <?= ((!empty($u_id)) && isFavorite($val['shop_id'], $u_id)) ? 'far is-active' : 'fas'; ?>"></i>
                                </div>
                            </div>
                            <div class="c-card__body">
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-shopping-bag"></i>&nbsp;商品</p>
                                    <p class="c-card__detail">
                                    <?php foreach($val['products'] as $products => $product){ ?>
                                        <?= sanitize($product['p_name']); ?>
                                        <?= sanitize($product['p_value']); ?>円
                                        <?= sanitize($product['p_number']); ?>
                                    <?php } ?>
                                    </p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-file-alt"></i>&nbsp;詳細</p>
                                    <p class="c-card__detail"><?= sanitize(showData($val['social_profile'])); ?></p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-map-marker-alt"></i>&nbsp;住所</p>
                                    <p class="c-card__detail"><?= sanitize(showData($val['city_name'].$val['street'].$val['building'])); ?></p>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- ページング -->
                    <?php pagination($currentPageNum, $dbShopData['total_page']); ?>
                    <?php }else{ ?>
                    <p>お気に入り登録された店舗はありません。</p>
                    <?php } ?>
                </div>
            </section><!-- /店舗一覧 -->
            
        </div>
        <!-- サイドバー -->
        <?php include('sidebar_mypage.php'); ?>
    </main>
    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up js-goTop"></i>
    </div>

    <!-- フッター -->
    <?php include_once('footer.php'); ?>
</body>
</html>