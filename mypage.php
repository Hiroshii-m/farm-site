<?php

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('マイページ画面');
debug('==============================================');

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
            </section><!-- /最近の投稿 -->

        </div>
        <!-- サイドバー -->
        <section id="l-sidebar">
            <aside class="c-sidebar">
                <h2 class="c-sidebar__tit">メニュー</h2>
                <ul class="c-sidebar__body">
                    <li class="c-sidebar__list">
                        <a href="" class="c-sidebar__text">プロフィール編集</a>
                    </li>
                    <li class="c-sidebar__list">
                        <a href="" class="c-sidebar__text">加盟店登録</a>
                    </li>
                    <li class="c-sidebar__list">
                        <a href="" class="c-sidebar__text">商品登録</a>
                    </li>
                    <li class="c-sidebar__list">
                        <a href="logout.php" class="c-sidebar__text">ログアウト</a>
                    </li>
                    <li class="c-sidebar__list">
                        <a href="withdraw.php" class="c-sidebar__text">退会</a>
                    </li>
                </ul>
            </aside>
        </section><!-- /サイドバー -->
    </main>


    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up"></i>
    </div>
    <!-- フッター -->
    <?php require('footer.php'); ?>
    <!-- 共通ファイル -->
    <script src="js/app.js"></script>
    <!-- 個別のjsファイル -->
    <script src="js/mypage.js"></script>
</body>
</html>