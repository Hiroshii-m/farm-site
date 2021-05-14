<?php
// ログインしているユーザーである場合、変数を格納
$u_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
$favoriteShop = getFavoShop($u_id);
?>
<?php if(!empty($u_id) && !empty($favoriteShop['data'])): ?>
<!-- サイドバー -->
<section id="l-sidebar">
    <aside class="c-sidebar">
        <h2 class="c-sidebar__tit">お気に入りの販売所</h2>
        <ul class="c-sidebar__body">
            <?php foreach($favoriteShop['data'] as $key => $val): ?>
            <li class="c-sidebar__list">
                <a href="single.php?s_id=<?= sanitize($val['shop_id']); ?>" class="c-sidebar__text"><?= sanitize($val['shop_name']); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </aside>
</section><!-- /サイドバー -->
<?php endif; ?>