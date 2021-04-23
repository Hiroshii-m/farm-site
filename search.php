<?php
// 予想時間:6h
// かかった時間：21mi

// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('検索画面');
debug('==============================================');

// GETパラメータを取得
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';

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
                    <form class="p-search__shop">
                        <input type="text" class="p-search__input" placeholder="キーワード[例：キャベツ、店名、穀物]">
                        <button class="p-search__nameBtn u-miniBtn" type="submit">検索</button>
                    </form>
                    <h2 class="p-search__title">こだわり検索</h2>
                    <form action="" class="p-search__option">
                        <div class="p-search__area">
                            <select class="p-search__select" name="" id="">
                                <option value="">エリア</option>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__area">
                            <select class="p-search__select" name="" id="">
                                <option value="">カテゴリー</option>
                            </select>
                            <i class="fas fa-chevron-down p-search__arrow"></i>
                        </div>
                        <div class="p-search__submit">
                            <button class="p-search__commit u-miniBtn">こだわり検索する</button>
                            <button class="p-search__clear u-miniBtn">全てクリア</button>
                        </div>
                    </form>
                </div>
            </section><!-- /検索ボックス -->
        
            <!-- 店舗一覧 -->
            <section id="l-shopList" class="">
                <div class="p-shopList">
                    <h2 class="p-shopList__heading">
                        <p class="p-shopList__title">店舗一覧</p>
                        <p class="p-shopList__showNum">1~20件表示</p>
                        <div class="p-shopList__terms">
                            <span class="p-shopList__tag u-tag-accent">野菜</span>
                            <span class="p-shopList__tag u-tag-sub">苫小牧市</span>
                        </div>
                    </h2>
                    <ul class="p-shopList__body">
                        <li class="c-card">
                            <div class="c-card__head">
                                <div class="c-card__person">
                                    <div class="c-card__img">
                                        <img src="images/pic2.jpeg" alt="">
                                    </div>
                                    <p class="c-card__author">北海の農家</p>
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