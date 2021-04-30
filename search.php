<?php
// 予想時間:6h
// かかった時間：21mi

// 共通ファイルの読み込み
require_once('function.php');

debug('==============================================');
debug('検索画面');
debug('==============================================');

// GETパラメータを取得
// ================================
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
$currentPageNum = 1;
$city_id = (!empty($_GET['city_id'])) ? $_GET['city_id'] : '';
$category_id = (!empty($_GET['category_id'])) ? $_GET['category_id'] : '';
if(empty($p_id) && is_numeric($p_id)) {
    header("Location:index.php");
}
// 処理内容
// =================================
// 都道府県idから市区町村idと名前を取得
$cityInfo = (!empty($p_id)) ? getCityInfo($p_id) : '';
// カテゴリー情報を取得
$category = getCategory();
// debug(print_r($cityInfo, true));
// 表示件数
$listSpan = 10;
// 現在のレコードの先頭を算出
$currentMinNum = (($currentPageNum-1) * $listSpan);
// DBからデータを取得
$dbShopData = getShopMatch($currentMinNum, $p_id, $city_id, $category_id);
// 検索クリアが押された場合
if(!empty($_GET['clear'])) {
    $_GET['city_id'] = '';
    $_GET['category_id'] = '';
}
// debug($_GET['clear'])

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
                        <input type="text" class="p-search__input" placeholder="キーワード[例：キャベツ、店名、穀物]">
                        <h2 class="p-search__title">条件を絞る</h2>
                        <div class="p-search__area">
                            <select class="p-search__select" name="city_id" id="">
                                <option value="">エリア</option>
                                <?php if(!empty(array_filter($category))){ ?>
                                    <?php foreach($cityInfo as $key => $val): ?>
                                        <option value="<?= $key; ?>" <?= (is_numeric($_GET['city_id']) && (int)$_GET['city_id'] === $key) ? 'selected' : ''; ?>><?= sanitize(showData($val['city_name'])); ?></option>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__area">
                            <select class="p-search__select" name="category_id" id="">
                                <option value="">カテゴリー</option>
                                <?php if(!empty(array_filter($category))){ ?>
                                    <?php foreach($category as $key => $val): ?>
                                        <option value="<?= $key; ?>" <?= (is_numeric($_GET['category_id']) && (int)$_GET['category_id'] === $key) ? 'selected' : ''; ?>><?= sanitize(showData($val['category_name'])); ?></option>
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
                        <p class="p-shopList__showNum">1~10件表示/合計<?= (!empty($dbShopData['total'])) ? $dbShopData['total'] : '0'; ?>件ヒット</p>
                        <div class="p-shopList__terms">
                            <?php if(is_numeric($_GET['city_id'])){ ?>
                                <span class="p-shopList__tag u-tag-sub"><?= sanitize($cityInfo[$_GET['city_id']]['city_name']); ?></span>
                            <?php } ?>
                            <?php if(is_numeric($_GET['category_id'])){ ?>
                                <span class="p-shopList__tag u-tag-accent"><?= sanitize($category[$_GET['category_id']]['category_name']); ?></span>
                            <?php } ?>
                        </div>
                    </h2>
                    <?php if(!empty($dbShopData)) { ?>
                    <ul class="p-shopList__body">
                        <?php foreach($dbShopData['data'] as $key => $val): ?>
                        <li class="c-card">
                            <div class="c-card__head">
                                <div class="c-card__img">
                                    <img src="<?= sanitize(showData($val['shop_img1'])); ?>" alt="">
                                </div>
                                <div class="c-card__summary">
                                    <p class="c-card__category">野菜</p>
                                    <a href="single.php<?= appendGetParam().'&shop_id='.sanitize($val['id']); ?>" class="c-card__title"><?= sanitize(showData($val['shop_name'])); ?></a>
                                </div>
                                <i class="far fa-heart c-card__icon"></i>
                            </div>
                            <div class="c-card__body">
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-shopping-bag"></i>&nbsp;商品</p>
                                    <p class="c-card__detail">米1g 100円、白菜 100円、ピーマン100円</p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-file-alt"></i>&nbsp;詳細</p>
                                    <p class="c-card__detail"><?= sanitize(showData($val['social_profile'])); ?></p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-map-marker-alt"></i>&nbsp;住所</p>
                                    <p class="c-card__detail"><?= sanitize(showData($cityInfo[$_GET['city_id']]['city_name'].$val['street'].$val['building'])); ?></p>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php } ?>
                    <!-- ページング -->
                    <div id="l-pagination" class="">
                        <ul class="c-pagination u-flex-between">
                            <li class=""><a class="c-pagination__item" href="">&lt;</a></li>
                            <li class=""><a class="c-pagination__item" href="">1</a></li>
                            <li class=""><a class="c-pagination__item" href="">2</a></li>
                            <li class=""><a class="c-pagination__item active" href="">3</a></li>
                            <li class=""><a class="c-pagination__item" href="">4</a></li>
                            <li class=""><a class="c-pagination__item" href="">5</a></li>
                            <li class=""><a class="c-pagination__item" href="">&gt;</a></li>
                        </ul>
                    </div><!-- /ページング -->
                </div>
            </section><!-- /店舗一覧 -->
            
        </div>
        <!-- サイドバー -->
        <?php include('sidebar_favo.php'); ?>
    </main>
    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>

    <!-- フッター -->
    <?php include_once('footer.php'); ?>
</body>
</html>