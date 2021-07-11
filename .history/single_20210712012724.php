<?php

// 共通ファイルの読み込み
require_once('function.php');

debug('==============================================');
debug('店舗詳細画面');
debug('==============================================');

// 都道府県データ
$prefecture = array(
    '1'=>'北海道',
    '2'=>'青森県',
    '3'=>'岩手県',
    '4'=>'宮城県',
    '5'=>'秋田県',
    '6'=>'山形県',
    '7'=>'福島県',
    '8'=>'茨城県',
    '9'=>'栃木県',
    '10'=>'群馬県',
    '11'=>'埼玉県',
    '12'=>'千葉県',
    '13'=>'東京都',
    '14'=>'神奈川県',
    '15'=>'新潟県',
    '16'=>'富山県',
    '17'=>'石川県',
    '18'=>'福井県',
    '19'=>'山梨県',
    '20'=>'長野県',
    '31'=>'鳥取県',
    '32'=>'島根県',
    '33'=>'岡山県',
    '34'=>'広島県',
    '35'=>'山口県',
    '36'=>'徳島県',
    '37'=>'香川県',
    '38'=>'愛媛県',
    '39'=>'高知県',
    '21'=>'岐阜県',
    '22'=>'静岡県',
    '23'=>'愛知県',
    '24'=>'三重県',
    '25'=>'滋賀県',
    '26'=>'京都府',
    '27'=>'大阪府',
    '28'=>'兵庫県',
    '29'=>'奈良県',
    '30'=>'和歌山県',
    '40'=>'福岡県',
    '41'=>'佐賀県',
    '42'=>'長崎県',
    '43'=>'熊本県',
    '44'=>'大分県',
    '45'=>'宮崎県',
    '46'=>'鹿児島県',
    '47'=>'沖縄県'
);

// 店舗idを格納
$s_id = (!empty($_GET['shop_id'])) ? $_GET['shop_id'] : '';
$favoNum = getFavoCount($s_id);
// 店舗情報を取得
$dbFormData = (!empty($s_id)) ? getShopOne($s_id) : '';
debug(print_r($dbFormData, true));
// 商品を取得
$productData = (!empty($s_id)) ? getProduct($s_id) : '';
// メッセージ情報を取得
$comments = (!empty($dbFormData)) ? getComments($s_id) : '';
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
// ブログ情報を取得
$blogs = getBlogList($s_id);
// 市区町村データ取得
$cityInfo = (!empty($p_id)) ? getCityInfo($p_id) : array();
// 住所を取得
$access = '';
getFormData('city_name').getFormData('street').getFormData('building');
if(!empty($dbFormData['prefecture_id'])){
    $access = $prefecture[$dbFormData['prefecture_id']];
    if(!empty($dbFormData['city_id'])){
        $access = $access.$cityInfo['city_id'].$dbFormData['street'].$dbFormData['building'];
    }
}

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
                        <a href="index.php<?= (!empty(appendGetParam())) ? appendGetParam(array('p_id', 'shop_id')) : ''; ?>" class="u-prev p-article__prev">TOP</a><span>&nbsp;&gt;</span>
                        <a href="search.php<?= (!empty(appendGetParam())) ? appendGetParam(array('shop_id')) : ''; ?>" class="u-prev p-article__prev">検索画面</a><span>&nbsp;&gt;</span>
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
                            <div class="p-article__sns">
                                <a class="p-article__fab" href="https://twitter.com/intent/tweet?text=「<?= sanitize(getFormData('shop_name')); ?>」&url=「<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>」" target="_blank" rel="nofollow"><i class="fab fa-twitter"></i></a>
                                <a class="p-article__fab" href="http://www.facebook.com/share.php?u=<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" ><i class="fab fa-facebook-square"></i></a>
                                <a class="p-article__fab" href="http://line.me/R/msg/text/?「<?= sanitize(getFormData('shop_name')); ?>」「<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>」" target="_blank" rel="nofollow"><i class="fab fa-line"></i></a>
                            </div>
                            <div class="p-article__head u-flex-between">
                                <h2 class="p-article__shopName"><?= sanitize(getFormData('shop_name')) ?></h2>
                                <div class="c-submission__icon">
                                    <i class="fa-heart c-submission__fav js-click-animation <?= ((!empty($u_id)) && isFavorite(getFormData('id'), $u_id)) ? 'fas is-active' : 'far'; ?>" data-shopid="<?= sanitize(getFormData('id')); ?>"></i>
                                    <i class="fa-heart c-submission__fav2 js-click-animation2 <?= ((!empty($u_id)) && isFavorite(getFormData('id'), $u_id)) ? 'far is-active' : 'fas'; ?>"></i>
                                </div>
                            </div>
                            <div class="p-article__images">
                                <div class="p-article__caption">
                                    <img class="js-main-img" src="<?= sanitize(showImg(getFormData('shop_img1'))); ?>" alt="">
                                </div>
                                <div class="p-article__thumnails">
                                    <div class="p-article__img"><img class="js-sub-img" src="<?= sanitize(showImg(getFormData('shop_img1'))); ?>" alt=""></div>
                                    <div class="p-article__img"><img class="js-sub-img" src="<?= sanitize(showImg(getFormData('shop_img2'))); ?>" alt=""></div>
                                    <div class="p-article__img"><img class="js-sub-img" src="<?= sanitize(showImg(getFormData('shop_img3'))); ?>" alt=""></div>
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
                                        <?php if(!empty($productData)){ ?>
                                            <?php foreach($productData as $key => $val): ?>
                                            <li class="p-product__list">
                                                <details open>
                                                    <summary class="p-product__summary">
                                                        <span class="p-product__point ">【<i class="fas fa-shopping-bag u-padding-1"></i>商品名】</span><?= showData($val['p_name']); ?>
                                                        <span class="p-product__point ">【<i class="fas fa-yen-sign u-padding-1"></i>値段】</span><?= $val['p_value']; ?>円
                                                        <span class="p-product__point ">【<i class="fas fa-balance-scale u-padding-1"></i>数量・質量】</span><?= $val['p_number']; ?>
                                                    </summary>
                                                    <div class="p-product__info u-flex">
                                                        <div class="p-product__img">
                                                            <img src="<?= showImg($val['p_img']); ?>" alt="">
                                                        </div>
                                                        <div class="p-product__explain">
                                                            <p class="u-font-weight-bold">＜カテゴリ＞</p>
                                                            <p><?= $val['category_name']; ?></p>
                                                            <p class="u-font-weight-bold">＜収穫時期・販売時期＞</p>
                                                            <p><?= $val['term']; ?></p>
                                                            <p class="u-font-weight-bold">＜説明＞</p>
                                                            <p><?= $val['p_detail']; ?></p>
                                                        </div>
                                                    </div>
                                                </details>
                                            </li>
                                            <?php endforeach; ?>
                                            <?php }else{ ?>
                                                <p>商品情報はありません。</p>
                                            <?php } ?>
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
                                                <?php if(!empty($blogs['data'])){ ?>
                                                    <?php foreach($blogs['data'] as $key => $val){ ?>
                                                <h3 class="p-shopBlog__title"><?= sanitize($val['title']); ?></h3>
                                                <p class="p-shopBlog__time"><i class="far fa-clock"></i><?= sanitize(date('Y/m/d', strtotime($val['create_date']))); ?>&ensp;<i class="fas fa-sync-alt"></i><?= sanitize(date('Y/m/d', strtotime($val['update_date']))); ?></p>
                                                <?php if(!empty($val['img'])){ ?>
                                                <div class="p-shopBlog__img"><img src="<?= showImg($val['img']); ?>" alt=""></div>
                                                <?php } ?>
                                                <div class="p-shopBlog__content"><?= sanitize($val['content']); ?></div>
                                                        <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </section>
    
                                    <!-- アクセス -->
                                    <section id="l-access" class="u-display-none js-article-access">
                                        <div class="p-access">
                                            <div class="p-access__map">
                                                <p class="p-explain__title u-padding-10 u-font-weight-bold">＜住所＞</p>
                                                <p class="u-padding-10"><?= (!empty($dbFormData['prefecture_id'])) ? $prefecture[$dbFormData['prefecture_id']] : '';getFormData('city_name').getFormData('street').getFormData('building'); ?></p>
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
    <!-- フッター -->
    <?php include('footer.php'); ?>
    <script src="js/single.js"></script>
</body>
</html>