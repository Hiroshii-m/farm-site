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
// 表示件数
$listSpan = 10;
// 現在のレコードの先頭を算出
$currentMinNum = (($currentPageNum-1) * $listSpan);
// DBからデータを取得
$dbShopData = getShopMatch($currentMinNum, $p_id, $city_id, $category_id);
debug('取得した店舗情報');
debug(print_r($dbShopData, true));
// 検索クリアが押された場合
if(!empty($_GET['clear'])) {
    $_GET['city_id'] = '';
    $_GET['category_id'] = '';
    $_GET['clear'] = '';
}

?>
<?php
$headTitle = '検索画面';
require('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php require('header.php'); ?>

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">

            <!-- パンクズリスト -->
            <div class="c-pankuzu">
                <a href="" class="u-prev p-article__prev">TOP</a><span>&nbsp;&gt;</span>
                <a href="" class="u-prev p-article__prev">検索画面</a><span>&nbsp;&gt;</span>
                <span href="" class="u-prev p-article__prev">店舗詳細ページ</span>
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
                                <?php if(!empty($cityInfo)){ ?>
                                    <?php foreach($cityInfo as $key => $val): ?>
                                    <option value="<?= sanitize(showData($val['id'])); ?>" <?= (getFormData('city_id', true) === $val['id']) ? 'selected' : ''; ?>><?= sanitize(showData($val['city_name'])); ?></option>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__area">
                            <select class="p-search__select" name="category_id" id="">
                                <option value="">カテゴリー</option>
                                <?php if(!empty($category)){ ?>
                                    <?php foreach($category as $key => $val): ?>
                                    <option value="<?= sanitize(showData($val['id'])); ?>" <?= (getFormData('category_id', true) === $val['id']) ? 'selected' : ''; ?>><?= sanitize(showData($val['category_name'])); ?></option>
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
                            <span class="p-shopList__tag u-tag-accent">野菜</span>
                            <span class="p-shopList__tag u-tag-sub">苫小牧市</span>
                        </div>
                    </h2>
                    <ul class="p-shopList__body">
                    <?php if(empty($dbShopData)) { ?>
                        検索情報はありませんでした。
                    <?php } else { ?>
                        <?php foreach($dbShopData as $key => $val): ?>
                        <li class="c-card">
                            <div class="c-card__head">
                                <div class="c-card__img">
                                    <img src="images/pic2.jpeg" alt="">
                                </div>
                                <div class="c-card__summary">
                                    <p class="c-card__category">野菜</p>
                                    <a class="c-card__title">店舗名だよん店舗名だよん</a>
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
                                    <p class="c-card__detail">ピーマン育てて、1万年。研究に研究を重ねた絶品の品です。</p>
                                </div>
                                <div class="c-card__item">
                                    <p class="c-card__row"><i class="fas fa-map-marker-alt"></i>&nbsp;住所</p>
                                    <p class="c-card__detail">那覇市なんたらなんたら町11-22</p>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php } ?>
                    </ul>
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
        <?php require('sidebar_favo.php'); ?>
    </main>
    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>

    <!-- フッター -->
    <?php require('footer.php'); ?>
</body>
</html>