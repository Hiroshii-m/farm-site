<div class="u-upArrow">
    <i class="fas fa-chevron-circle-up js-goTop"></i>
</div>
 <!-- フッター -->
 <footer id="l-footer" class="js-footer">
    <div class="c-footer">
        <div class="c-footer__share">
            <p class="c-footer__text">SNSでシェアしよう</p>
            <ul class="c-footer__sns u-flex">
                <li class="c-footer__icon">
                    <a href="https://twitter.com/intent/tweet?text=「農産物販売所」&url=「<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>」&related=「ツイッターアカウント名」" target="_blank" rel="nofollow"><i class="fab fa-twitter"></i></a>
                </li>
                <li class="c-footer__icon">
                    <a href="http://www.facebook.com/share.php?u=<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" ><i class="fab fa-facebook-square"></i></a>
                </li>
                <li class="c-footer__icon">
                    <a href="http://line.me/R/msg/text/?「農産物販売所」「<?= (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; ?><?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>」" target="_blank" rel="nofollow"><i class="fab fa-line"></i></a>
                </li>
            </ul>
        </div>
        <div class="c-footer__logo">
            <div class="c-footer__img"><img src="./images/ilust2.png" alt=""></div>
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
<script src="node_modules/jquery/dist/jquery.js"></script>
<!-- 共通ファイル -->
<script src="js/app.js"></script>