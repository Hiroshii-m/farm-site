<?php
// 予想時間:8h
// かかった時間：2h
// できれば、google map自動生成をしたい。もし、自動生成でずれていたら、自分で修正できるようにiframeをいれてもらう。

// 共通ファイルの読み込み
require_once('function.php');

debug('==============================================');
debug('店舗詳細画面');
debug('==============================================');

// 店舗idを格納
$s_id = (!empty($_GET['shop_id'])) ? $_GET['shop_id'] : '';
$favoNum = getFavoCount($s_id);
// 店舗情報を取得
$dbFormData = (!empty($s_id)) ? getShopOne($s_id) : '';
// メッセージ情報を取得
$comments = (!empty($dbFormData)) ? getComments($s_id) : '';
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
// debug(print_r($comments, true));

if(!empty($_POST)) {
    // ユーザーであった場合、ユーザーidを格納
    $user_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
    $msg = (!empty($_POST['msg'])) ? $_POST['msg'] : '';

    // 空白かどうか
    validRequired($msg, 'msg');
    // ログインしていない場合
    if(empty($u_id)) {
        header("Location:login.php");
        $err_msg['common'] = MSG::DOLOGIN;
        exit;
    }
    if(empty($err_msg)) {
        try {
            $dbh = dbConnect();
            $sql = 'INSERT INTO `comments`(`send_date`, `send_id`, `shop_id`, `msg`, `create_date`) VALUES (:send_date, :send_id, :shop_id, :msg, :create_date)';
            $data = array(':send_date' => date('Y-m-d H:i:s'), ':send_id' => $u_id, ':shop_id' => $dbFormData['id'], ':msg' => $msg, ':create_date' => date('Y-m-d'));
            $stmt = queryPost($dbh, $sql, $data);

            if(!empty($stmt)) {
                $_POST = array();
                header("Location:".$_SERVER['PHP_SELF'].appendGetParam());
            }

        } catch ( Exception $e ) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG::UNEXPECTED;
        }
    }
}

?>

<?php
$headTitle = '店舗詳細ページ';
include_once('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php include_once('header.php'); ?>

    <main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">
            <!-- 記事 -->
            <section id="l-article" class="">
                <div class="c-container p-article">

                    <!-- パンクズリスト -->
                    <div class="c-pankuzu">
                        <a href="" class="u-prev p-article__prev">TOP</a><span>&nbsp;&gt;</span>
                        <a href="" class="u-prev p-article__prev">検索画面</a><span>&nbsp;&gt;</span>
                        <span href="" class="u-prev p-article__prev">店舗詳細ページ</span>
                    </div><!-- /パンクズリスト -->

                    <article class="p-article__content">
                        <div class="p-article__top">
                            <p class="p-article__category">穀物</p>
                            <div class="p-article__favorite">
                                <p>
                                    お気に入り：<?= sanitize($favoNum); ?>件&nbsp;
                                </p>
                            </div>
                        </div>
                        <div class="p-article__inner">
                            <div class="p-article__head u-flex-between">
                                <h2 class="p-article__shopName"><?= sanitize(getFormData('shop_name')); ?></h2>
                                <div class="c-submission__icon">
                                <div class="c-submission__icon">
                                <i class="fa-heart c-submission__fav js-click-animation <?= ((!empty($u_id)) && isFavorite(getFormData('id'), $u_id)) ? 'fas is-active' : 'far'; ?>" data-shopid="<?= sanitize(getFormData('id')); ?>"></i>
                                <i class="fa-heart c-submission__fav2 js-click-animation2 <?= ((!empty($u_id)) && isFavorite(getFormData('id'), $u_id)) ? 'far is-active' : 'fas'; ?>"></i>
                                </div>
                            </div>
                            </div>
                            <div class="p-article__images">
                                <div class="p-article__caption">
                                    <img src="<?= sanitize(showImg(getFormData('shop_img1'))); ?>" alt="">
                                </div>
                                <div class="p-article__thumnails">
                                    <div class="p-article__img"><img src="<?= sanitize(showImg(getFormData('shop_img1'))); ?>" alt=""></div>
                                    <div class="p-article__img"><img src="<?= sanitize(showImg(getFormData('shop_img2'))); ?>" alt=""></div>
                                    <div class="p-article__img"><img src="<?= sanitize(showImg(getFormData('shop_img3'))); ?>" alt=""></div>
                                </div>
                            </div>
                            
                            <!-- 初め -->
                            <section id="" class="p-article__body">
                                <div class="p-article__menu">
                                    <div class="p-article__tab">
                                        <input id="products" class="p-article__input u-display-none js-menu-product js-menu" type="radio" name="tab-item" value="" checked>
                                        <label class="p-article__label" for="products">商品情報</label>
                                    </div>
                                    <div class="p-article__tab">
                                        <input id="shop" class="p-article__input u-display-none js-menu-explain js-menu" type="radio" name="tab-item" value="">
                                        <label class="p-article__label" for="shop">店舗情報</label>
                                    </div>
                                    <div class="p-article__tab">
                                        <input id="blog" class="p-article__input u-display-none js-menu-blog js-menu" type="radio" name="tab-item" value="">
                                        <label class="p-article__label" for="blog">ブログ</label>
                                    </div>
                                    <div class="p-article__tab">
                                        <input id="access" class="p-article__input u-display-none js-menu-access js-menu" type="radio" name="tab-item" value="">
                                        <label class="p-article__label" for="access">アクセス</label>
                                    </div>
                                    <div class="p-article__tab">
                                        <input id="comment" class="p-article__input u-display-none js-menu-comment js-menu" type="radio" name="tab-item" value="">
                                        <label class="p-article__label" for="comment">コメント</label>
                                    </div>
                                </div>
                                <div class="p-article__data">
                                    
                                    <!-- 製品情報 -->
                                    <section id="l-product" class="u-display-none js-article-product">
                                        <ul class="p-product">
                                            <p>＜穀物＞</p>
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
                                                </details>
                                            </li>
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
                                                            <p>＜カテゴリ＞</p>
                                                            <p>野菜</p>
                                                            <p>＜収穫時期・販売時期＞</p>
                                                            <p>4月〜7月</p>
                                                            <p>＜説明＞</p>
                                                            <p>無農薬</p>
                                                        </div>
                                                    </div>
                                                </details>
                                            </li>
                                        </ul>
                                    </section><!-- /製品情報 -->
                                    <!-- 店舗情報 -->
                                    <section id="l-explain" class="u-display-none js-article-explain">
                                        <div class="p-explain">
                                            <p class="p-explain__title u-padding-10 u-font-weight-bold">＜販売所の説明＞</p>
                                            <div><?= sanitize(getFormData('social_profile')); ?></div>
                                            <p class="p-explain__title u-padding-10 u-font-weight-bold">＜電話番号＞</p>
                                            <p><?= sanitize(getFormData('tel')); ?></p>
                                        </div>
                                    </section><!-- /店舗情報 -->
                                    
                                    <!-- ブログ -->
                                    <section id="l-shopBlog" class="u-display-none js-article-blog">
                                        <div class="p-shopBlog">
                                            <div class="p-shopBlog__body">
                                                <h3 class="p-shopBlog__title">誰でもオシャレな農業生活を実現する</h3>
                                                <p class="p-shopBlog__time"><i class="far fa-clock"></i>2021/4/10&ensp;<i class="fas fa-sync-alt"></i>2021/4/11</p>
                                                <div class="p-shopBlog__img"><img src="images/pic2.jpeg" alt=""></div>
                                                <div class="p-shopBlog__content">オシャレなブログの方が稼げると断言しても過言ではありません。私はブログ歴5年、現在はブログで独立して法人の代表も務めているので、多くの人にブログのアドバイスを求められるのですが、この事実を伝えるとみんな驚き不安そうな顔をします。</div>
                                            </div>
                                        </div>
                                    </section>
    
                                    <!-- アクセス -->
                                    <section id="l-access" class="u-display-none js-article-access">
                                        <div class="p-access">
                                            <div class="p-access__map">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26132.349305661788!2d135.7192719!3d35.04314444999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6001a820c0eb46bd%3A0xee4272b1c22645f!2z6YeR6Zaj5a-6!5e0!3m2!1sja!2sjp!4v1617712311517!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div>
                                        </div>
                                    </section><!-- /アクセス -->
    
                                    <!-- コメント -->
                                    <section id="l-comment" class="u-display-none js-article-comment">
                                        <div class="p-comment">
                                        <div class="p-comment__wrap">
                                                <div class="p-comment__body">
                                                    <?php if(!empty($comments)): ?>
                                                        <?php foreach($comments as $key => $val){ ?>
                                                        <?php if($dbFormData['user_id'] === $comments[$key]['send_id']): ?>
                                                        <div class="p-comment__to u-flex u-padding-10">
                                                            <div>
                                                                <figure class="p-comment__icon">
                                                                    <img src="<?= showImg($comments[$key]['avatar_image_path']); ?>" alt="">
                                                                </figure>
                                                                <p class="p-comment__username"><?= showData($comments[$key]['screen_name']); ?></p>
                                                            </div>
                                                            <div class="p-comment__balloon">
                                                                <div class="p-comment__msg p-comment__msgTo">
                                                                    <?= showData($comments[$key]['msg']); ?>
                                                                </div>
                                                                <p class="p-comment__time"><?= date('Y年m月d日 H:i', strtotime($comments[$key]['send_date'])); ?></p>
                                                            </div>
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="p-comment__from u-flex u-padding-10">
                                                            <div class="p-comment__balloon u-flex-end">
                                                                <p class="p-comment__time"><?= date('Y年m月d日 H:i', strtotime($comments[$key]['send_date'])); ?></p>
                                                                <div class="p-comment__msg p-comment__msgFrom">
                                                                    <?= showData($comments[$key]['msg']); ?>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <figure class="p-comment__icon">
                                                                    <img src="images/pic6.jpeg" alt="">
                                                                </figure>
                                                                <p class="p-comment__username"><?= showData($comments[$key]['screen_name']); ?></p>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php } ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <form class="p-comment__form" method="post">
                                                <textarea name="msg" type="text" class="p-comment__textarea"></textarea>
                                                <button class="p-comment__submit" type="submit"><i class="fas fa-paper-plane"></i></button>
                                            </form>
                                        </div>
                                    </section><!-- /コメント -->

                                </div>

                            </section><!-- /終わり -->

                        </div>
                    </article>
                </div>
            </section>
            <!-- /記事 -->
        
        </div>

        <!-- サイドバー -->
        <?php include('sidebar_favo.php'); ?>

    </main>
    <div class="u-upArrow">
        <i class="fas fa-chevron-circle-up js-goTop"></i>
    </div>
    <!-- フッター -->
    <?php include_once('footer.php'); ?>
    <script src="js/single.js"></script>
    <script src="js/app_icon.js"></script>
</body>
</html>