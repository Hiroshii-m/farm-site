<section id="l-sidebar">
    <aside class="c-sidebar">
        <h2 class="c-sidebar__tit">メニュー</h2>
        <ul class="c-sidebar__body">
            <li class="c-sidebar__list">
                <a href="editProf.php" class="c-sidebar__text">プロフィール編集</a>
            </li>
            <?php if(empty($s_id)){ ?>
                <li class="c-sidebar__list">
                    <a href="registShop.php" class="c-sidebar__text">加盟店登録</a>
                </li>
            <?php }else{ ?>
                <li class="c-sidebar__list">
                    <a href="editShop.php" class="c-sidebar__text">加盟店編集</a>
                </li>
            <?php } ?>
            <li class="c-sidebar__list">
                <a href="registProduct.php" class="c-sidebar__text">商品登録</a>
            </li>
            <li class="c-sidebar__list">
                <a href="registBlog.php" class="c-sidebar__text">記事を作成</a>
            </li>
            <li class="c-sidebar__list">
                <a href="editMailPass.php" class="c-sidebar__text">メールアドレス・パスワードを変更する</a>
            </li>
            <li class="c-sidebar__list">
                <a href="withdraw.php" class="c-sidebar__text">退会</a>
            </li>
        </ul>
    </aside>
</section><!-- /サイドバー -->