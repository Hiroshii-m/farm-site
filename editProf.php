<?php
// 予想時間（プロフィール編集画面）：3h
// かかった時間：3h58mi
// 予想時間（機能面）:3h
// かかった時間：20mi

// 共通ファイルの読み込み
require('function.php');
// ログイン認証ファイル読み込み
require('auth.php');

debug('==============================================');
debug('プロフィール編集画面');
debug('==============================================');

$u_id = $_SESSION['user_id'];
$userData = getUser($u_id);
debug('取得した情報'. print_r($userData, true));

// POSTチェック

?>

<?php
$headTitle = 'プロフィール編集';
require('head.php');
?>
<body>
    <!-- ヘッダー -->
    <?php
    require('header.php');
    ?>

    <main id="l-main">
        <form action="post" class="c-form js-sp-menu-target">
            <h2 class="c-form__title">プロフィール編集</h2>
            <div class="u-err-msg">
                
            </div>
            <label class="c-form__label" for="">
                プロフィール表示名
                <input class="c-form__input" type="text" name="" value="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                Email
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                氏名（漢字）
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide2" type="text" name="" placeholder="姓">
                    <input class="c-form__input c-form__divide2" type="text" name="" placeholder="名">
                </div>
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                氏名（カナ）
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide2" type="text" name="" placeholder="セイ">
                    <input class="c-form__input c-form__divide2" type="text" name="" placeholder="メイ">
                </div>
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                生年月日
                <div class="u-flex-between">
                    <input class="c-form__input c-form__divide3" type="number" min="1900" max="2014" name="" placeholder="年">
                    <input class="c-form__input c-form__divide3" type="number" min="1" max="12" name="" placeholder="月">
                    <input class="c-form__input c-form__divide3" type="number" min="1" max="31" name="" placeholder="日">
                </div>
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                郵便番号（ハイフンなし）
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                住所（都道府県）
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                住所（市区町村）
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                住所（番地）
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                住所（建物名）＊任意
                <input class="c-form__input" type="text" name="">
                <div class="u-err-msg">
                    
                </div>
            </label>
            <label class="c-form__label" for="">
                TOP画像
                <label class="c-form__areaDrop u-margin-top-5 js-area-drop">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                    <input class="c-form__file js-file-input" type="file" name="">
                    <img class="u-display-non c-form__img" alt="">
                    <p class="c-form__areaText">ドラッグ&ドロップ</p>
                </label>
                <div class="u-err-msg">
                    
                </div>
            </label>
            
            <input class="c-form__submit" type="submit" value="送信">
        </form>
    </main>
    
    <!-- フッター -->
    <?php require('footer.php'); ?>
    <!-- 共通ファイル -->
    <script src="js/app.js"></script>
    <!-- プロフィール編集画面のjsファイル -->
    <script src="js/app_editProf.js"></script>
</body>
</html>