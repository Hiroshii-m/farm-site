<?php
// 予想時間:4h
// かかった時間：1h24mi

// 共通ファイルの読み込み
require('function.php');

debug('==============================================');
debug('TOP画面');
debug('==============================================');

// 地方別都道府県の配列生成
$north = array(
    '1'=>'北海道',
    '2'=>'青森県',
    '3'=>'岩手県',
    '4'=>'宮城県',
    '5'=>'秋田県',
    '6'=>'山形県',
    '7'=>'福島県'
);
$kantou = array(
    '8'=>'茨城県',
    '9'=>'栃木県',
    '10'=>'群馬県',
    '11'=>'埼玉県',
    '12'=>'千葉県',
    '13'=>'東京都',
    '14'=>'神奈川県'
);
$hokuriku = array(
    '15'=>'新潟県',
    '16'=>'富山県',
    '17'=>'石川県',
    '18'=>'福井県',
    '19'=>'山梨県',
    '20'=>'長野県'
);
$chugoku = array(
    '31'=>'鳥取県',
    '32'=>'島根県',
    '33'=>'岡山県',
    '34'=>'広島県',
    '35'=>'山口県',
    '36'=>'徳島県',
    '37'=>'香川県',
    '38'=>'愛媛県',
    '39'=>'高知県'
);
$tokai = array(
    '21'=>'岐阜県',
    '22'=>'静岡県',
    '23'=>'愛知県',
    '24'=>'三重県'
);
$kansai = array(
    '25'=>'滋賀県',
    '26'=>'京都府',
    '27'=>'大阪府',
    '28'=>'兵庫県',
    '29'=>'奈良県',
    '30'=>'和歌山県'
);
$kyusyu = array(
    '40'=>'福岡県',
    '41'=>'佐賀県',
    '42'=>'長崎県',
    '43'=>'熊本県',
    '44'=>'大分県',
    '45'=>'宮崎県',
    '46'=>'鹿児島県',
    '47'=>'沖縄県'
);
// 登録された販売所を取得
$shopData[] = (!empty(getShopList())) ? getShopList() : '';

?>

<?php
$headTitle = 'TOP';
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

            <!-- 地域 -->
            <section id="l-region" class="u-bgColor">
                <div class="p-region c-container">
                    <h2 class="p-region__tit">販売所を探す</h2>
                    <div class="p-region__top">
                        <div class="p-region__box">
                            <h3 class="p-region__block">北海道・東北</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($north as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="p-region__bottom u-flex">
                        <div class="p-region__box">
                            <h3 class="p-region__block">中国・四国</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($chugoku as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="p-region__box">
                            <h3 class="p-region__block">甲信越・北陸</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($hokuriku as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="p-region__box">
                            <h3 class="p-region__block">関東</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($kantou as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="p-region__bottom u-flex">
                        <div class="p-region__box">
                            <h3 class="p-region__block">九州・沖縄</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($kyusyu as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="p-region__box">
                            <h3 class="p-region__block">関西</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($kansai as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="p-region__box">
                            <h3 class="p-region__block">東海</h3>
                            <ul class="p-region__prefecture u-flex">
                                <?php foreach($tokai as $key => $val): ?>
                                <li class="p-region__item">
                                    <a href="search.php?p_id=<?= $key; ?>"><?= $val; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section><!-- /地域 -->

            <!-- 最近登録された販売所 -->
            <section id="l-sale">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">最近登録された販売所</h2>
                    <ul class="c-submission__body">
                        <?php foreach($shopData as $key => $val): ?>
                        <li class="c-submission__item">
                            <div class="c-submission__visual">
                                <div class="c-submission__img"><img src="<?= sanitize(showImg($val['shop_img'])); ?>" alt=""></div>
                                <p class="c-submission__author"><?= sanitize(showData($val['screen_name'])); ?></p>
                            </div>
                            <div class="c-submission__content">
                                <a href="single.php?s_id=<?= sanitize(showData($val['id'])); ?>" class="c-submission__tit"><?= sanitize(showData($val['shop_name'])); ?></a>
                                <div class="c-submission__detail">
                                    <?= sanitize(showData($val['social_profile'])); ?>
                                </div>
                            </div>
                            <div class="c-submission__icon">
                                <i class="far fa-heart c-submission__fav js-click-animation"></i>
                                <i class="fas fa-heart c-submission__fav2 js-click-animation2"></i>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <button class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</button>
                </div>
            </section><!-- /最近登録された販売所 -->
            
            <!-- 最近の投稿 -->
            <section id="l-blog">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">最近の投稿</h2>
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
                                <i class="far fa-heart"></i>
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
                                <i class="far fa-heart"></i>
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
                                <i class="far fa-heart"></i>
                            </div>
                        </li>
                    </ul>
                    <button class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</button>
                </div>
            </section><!-- /最近の投稿 -->

        </div>
        <!-- サイドバー -->
        <?php require('sidebar_favo.php'); ?>
    </main>


    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>
    <!-- フッター -->
    <?php require('footer.php'); ?>
    <!-- 共通ファイル -->
    <script src="js/app_icon.js"></script>
</body>
</html>