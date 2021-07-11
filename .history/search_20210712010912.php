<?php

// 共通ファイルの読み込み
require_once('function.php');

debug('==============================================');
debug('検索画面');
debug('==============================================');

// 変数初期化
// ================================
$dbShopData = array();
// 検索クリアが押された場合
if(!empty($_GET['clear'])) {
    $_GET['word_search'] = '';
    $_GET['city_id'] = '';
    $_GET['category_id'] = '';
}

// GETパラメータを取得
// ================================
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
$word_search = (!empty($_GET['word_search'])) ? splitKeywords($_GET['word_search']) : '';
$city_id = (!empty($_GET['city_id'])) ? $_GET['city_id'] : '';
$category_id = (!empty($_GET['category_id'])) ? $_GET['category_id'] : '';
$currentPageNum = (!empty($_GET['page_id'])) ? $_GET['page_id'] : 1;
if(empty($p_id) && is_numeric($p_id)) {
    header("Location:index.php");
}
// 処理内容
// =================================
// 都道府県idから市区町村idと名前を取得
$cityInfo = (!empty($p_id)) ? array_merge(array(0 => array('city_name' => 'エリア')), getCityInfo($p_id)) : array();
// カテゴリー情報を取得
$category = array_merge(array(0 => array('category_name' => 'カテゴリー')), getCategory());
// 表示件数
$listSpan = 10;
// 現在のレコードの先頭を算出
$currentMinNum = (($currentPageNum-1) * $listSpan);
// DBからデータを取得
$dbShopData = getShopMatch($currentMinNum, $p_id, $city_id, $category_id, $word_search);
// 合計店舗数
$totalShopNum = (!empty($dbShopData['total'])) ? $dbShopData['total'] : 0;
// 合計ページ数
$totalPageNum = (!empty($dbShopData['total_page'])) ? $dbShopData['total_page'] : 0;
// 検索した市町村の名前
$cityName = '';
if(!empty($city_id)){
    foreach($cityInfo as $key => $val){
        if(!empty($val['id'])){
            if($city_id == $val['id']) {
                $cityName = $val['city_name'];
            }
        }
    }
}
// 検索したカテゴリーの名前
$cityName = '';
if(!empty($city_id)){
    foreach($cityInfo as $key => $val){
        if(!empty($val['id'])){
            if($city_id == $val['id']) {
                $cityName = $val['city_name'];
            }
        }
    }
}
?>
<?php
$headTitle = '検索画面';
include_once('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php include_once('header.php'); ?>

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">

            <!-- パンクズリスト -->
            <div class="c-pankuzu">
                <a href="index.php" class="u-prev p-article__prev">TOP</a><span>&nbsp;&gt;</span>
                <p class="u-prev p-article__prev">検索画面</p>
            </div><!-- /パンクズリスト -->

            <!-- 検索ボックス -->
            <section id="l-search" class="">
                <div class="p-search">
                    <form method="get" class="p-search__option">
                        <input type="hidden" name="p_id" value="<?= $p_id; ?>">
                        <input name="word_search" type="text" class="p-search__input" placeholder="キーワード[例：商品名、キャベツ、店名、季節、4月]" value="<?= getFormData('word_search', true); ?>">
                        <h2 class="p-search__title">条件を絞る</h2>
                        <div class="p-search__area">
                            <select class="p-search__select" name="city_id" id="">
                                <?php if(!empty(array_filter($cityInfo, "array_filter"))){ ?>
                                    <?php foreach($cityInfo as $key => $val): ?>
                                        <?php if(!empty($val['id'])): ?>
                                            <option value="<?= sanitize(showData($val['id'])); ?>" <?= ($city_id == $val['id']) ? 'selected' : ''; ?>><?= sanitize(showData($val['city_name'])); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__area">
                            <select class="p-search__select" name="category_id" id="">
                                <?php if(!empty(array_filter($category, "array_filter"))){ ?>
                                    <?php foreach($category as $key => $val): ?>
                                        <?php if(!empty($val['id'])): ?>
                                            <option value="<?= sanitize($val['id']); ?>" <?= ($category_id == $val['id']) ? 'selected' : ''; ?>><?= sanitize(showData($val['category_name'])); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__submit">
                            <button class="p-search__commit u-miniBtn">こだわり検索する</button>
                            <button name="clear" value="1" class="p-search__clear u-miniBtn">全てクリア</button>
                        </div>
                    </form>
                </div>
            </section><!-- /検索ボックス -->
        
            <!-- 店舗一覧 -->
            <section id="l-shopList" class="">
                <div class="p-shopList">
                    <h2 class="p-shopList__heading">
                        <p class="p-shopList__title">店舗一覧</p>
                        <p class="p-shopList__showNum">
                        <?php if(1 <= $currentPageNum){ ?>
                            <?= $currentMinNum + 1; ?>~<?= $currentMinNum + count($dbShopData['data']); ?>
                        <?php }else{ echo '0'; } ?>
                            件表示/合計<?= (!empty($dbShopData['total'])) ? $dbShopData['total'] : '0'; ?>件ヒット</p>
                        <div class="p-shopList__terms">
                            <?php if(!empty($_GET['city_id']) && is_numeric($_GET['city_id'])){ ?>
                                <span class="p-shopList__tag u-tag-sub"><?= $cityName; ?></span>
                            <?php } ?>
                            <?php if(!empty($_GET['category_id']) && is_numeric($_GET['category_id'])){ ?>
                                <span class="p-shopList__tag u-tag-accent"><?= sanitize($category[$_GET['category_id']]['category_name']); ?></span>
                            <?php } ?>
                        </div>
                    </h2>
                    <?php if(!empty($dbShopData)) { ?>
                    <ul class="p-shopList__body">
                        <?php foreach($dbShopData['data'] as $key => $val){ ?>
                        <li class="c-card">
                            <div class="c-card__head u-flex-between">
                                <div class="c-card__img">
                                    <img src="<?= sanitize(showImg($val['shop_img1'])); ?>" alt="">
                                </div>
                                <div class="c-card__summary">
                                    <p class="c-card__category"><?= sanitize(showData($val['category_name'])); ?></p>
                                    <a href="single.php<?= appendGetParam().'&shop_id='.sanitize($val['id']); ?>" class="c-card__title"><?= sanitize(showData($val['shop_name'])); ?></a>
                                </div>
                                <div class="c-submission__icon">
                                    <i class="fa-heart c-submission__fav js-click-animation <?= ((!empty($u_id)) && isFavorite($val['id'], $u_id)) ? 'fas is-active' : 'far'; ?>" data-shopid="<?= sanitize($val['id']); ?>"></i>
                                    <i class="fa-heart c-submission__fav2 js-click-animation2 <?= ((!empty($u_id)) && isFavorite($val['id'], $u_id)) ? 'far is-active' : 'fas'; ?>"></i>
                                </div>
                            </div>
                            <div class="c-card__body">
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-shopping-bag"></i>&nbsp;商品</p>
                                    <p class="c-card__detail js-card-text">
                                    <?php foreach($val['products'] as $products => $product){ ?>
                                        <?= sanitize($product['p_name']); ?>
                                        <?= sanitize($product['p_value']); ?>円
                                        <?= sanitize($product['p_number']); ?>
                                    <?php } ?>
                                    </p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-file-alt"></i>&nbsp;詳細</p>
                                    <p class="c-card__detail js-card-text"><?= sanitize(showData($val['social_profile'])); ?></p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-map-marker-alt"></i>&nbsp;住所</p>
                                    <p class="c-card__detail js-card-text"><?= sanitize(showData($val['city_name'].$val['street'].$val['building'])); ?></p>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <!-- ページング -->
                    <?php echo pagination($currentPageNum, $totalPageNum); ?>
                </div>
            </section><!-- /店舗一覧 -->
            
        </div>
        <!-- サイドバー -->
        <?php include('sidebar_favo.php'); ?>
    </main>

    <!-- フッター -->
    <?php include('footer.php'); ?>
</body>
</html>