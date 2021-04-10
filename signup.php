<?php

// ================================================
// ログ
// ================================================
ini_set('log_errors', 'on');
ini_set('error_log', 'error.log');

// ================================================
// デバッグ
// ================================================
$debug_flg = true;
function debug($str) {
    global $debug_flg;
    if(!empty($debug_flg)){
        error_log('デバッグ:'.$str);
    }
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>vegetable place</title>
</head>
<body>
    <!-- ヘッダー -->
    <header id="l-header" class="u-bgColor">
        <div class="c-header">
            <a class="c-header__logo u-flex">
                <div class="c-header__img">
                    <img src="images/ilust1.png" alt="">
                </div>
                <h3>農産物販売所</h3>
            </a>
            <nav class="c-header__nav">
                <ul class="c-header__list u-flex">
                    <li class="c-header__item">
                        <a href="" class="c-header__text">ホーム</a>
                    </li>
                    <li class="c-header__item">
                        <a href="" class="c-header__text">ログイン</a>
                    </li>
                    <li class="c-header__item">
                        <a href="" class="c-header__text">ユーザー登録</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header><!-- /ヘッダー -->

    <main id="l-main">
        <form action="post" class="c-form">
            <h2 class="c-form__title">新規登録</h2>
            <div class="u-err-msg">
                全体のエラー
            </div>
            <label class="c-form__label" for="">
                Email
                <input class="c-form__input" type="text" name="email" value="">
                <div class="u-err-msg">
                    Emailのエラー
                </div>
            </label>
            <label class="c-form__label" for="">
                パスワード
                <input class="c-form__input" type="password" name="pass">
                <div class="u-err-msg">
                    パスワードのエラー
                </div>
            </label>
            <input class="c-form__submit" type="submit" value="送信">
        </form>
    </main>
    
    <!-- フッター -->
    <footer id="l-footer" class="js-footer">
        <div class="c-footer">
            <div class="c-footer__share">
                <p class="c-footer__text">SNSでシェアしよう</p>
                <ul class="c-footer__sns u-flex">
                    <li class="c-footer__icon">
                        <a href=""><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="c-footer__icon">
                        <a href=""><i class="fab fa-facebook-square"></i></a>
                    </li>
                    <li class="c-footer__icon">
                        <a href=""><i class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
            <div class="c-footer__logo">
                <div class="c-footer__img"><img src="./images/ilust1.png" alt=""></div>
                <p class="c-footer__name">農作物販売所</p>
            </div>
            <ul class="c-footer__info u-flex">
                <li class="c-footer__list">
                    <a href="">このサイトについて</a>
                </li>
                <li class="c-footer__list">
                    <a href="">利用規約</a>
                </li>
                <li class="c-footer__list">
                    <a href="">プライバシーポリシー</a>
                </li>
                <li class="c-footer__list">
                    <a href="">情報セキュリティ基本方針</a>
                </li>
                <li class="c-footer__list">
                    <a href="">お問い合わせ</a>
                </li>
            </ul>
        </div>
    </footer><!-- /フッター -->
</body>
</html>