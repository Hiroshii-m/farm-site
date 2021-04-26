<?php

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('マイページ画面');
debug('==============================================');

// ユーザーIDを格納
$u_id = $_SESSION['user_id'];
// 店舗登録状態
$regist_flg = getRegist($u_id);

?>
<?php
$headTitle = 'マイページ';
require('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php require('header.php'); ?>
    
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

            <!-- 登録した商品 -->
            <section id="l-blog">
                <div class="c-container c-submission">
                    <h2 class="c-container__tit">登録した商品</h2>
                    <ul class="c-submission__body">
                        <li class="p-product__list">
                            <details open>
                                <summary class="p-product__summary">
                                    <span class="p-product__point ">【<i class="fas fa-shopping-bag u-padding-1"></i>商品名】</span>聖護院青長節成キュウリ
                                    <span class="p-product__point ">【<i class="fas fa-yen-sign u-padding-1"></i>値段】</span>500円
                                    <span class="p-product__point ">【<i class="fas fa-balance-scale u-padding-1"></i>数量・質量】</span>10本
                                </summary>
                                <div class="p-product__info u-flex">
                                    <div class="p-product__img">
                                        <img src="images/pic3.jpeg" alt="">
                                    </div>
                                    <div class="p-product__explain">
                                        <p class="u-font-weight-bold">＜カテゴリ＞</p>
                                        <p>野菜</p>
                                        <p class="u-font-weight-bold">＜収穫時期・販売時期＞</p>
                                        <p>4月〜7月</p>
                                        <p class="u-font-weight-bold">＜説明＞</p>
                                        <p>無農薬</p>
                                    </div>
                                </div>
                                <a class="p-product__btn" href="">編集する</a>
                            </details>
                        </li>
                    </ul>
                    <button class="c-container__btn u-btn u-btn-border-shadow u-btn-border-shadow--color">もっと見る</button>
                </div>
            </section><!-- /登録した商品 -->

        </div>
        <!-- サイドバー -->
        <?php require('sidebar_mypage.php'); ?>
    </main>


    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>
    <!-- フッター -->
    <?php require('footer.php'); ?>
    <!-- 個別のjsファイル -->
    <script src="js/app_icon.js"></script>
</body>
</html>