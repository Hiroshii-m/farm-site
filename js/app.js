window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    
    // single.htmlで使用
    // =================================
    // メニュー
    $menuAll = document.querySelectorAll('.js-menu');
    $menuProduct = document.querySelector('.js-menu-product');
    $menuExplain = document.querySelector('.js-menu-explain');
    $menuBlog = document.querySelector('.js-menu-blog');
    $menuAccess = document.querySelector('.js-menu-access');
    $menuComment = document.querySelector('.js-menu-comment');
    // コンテンツ
    $articleProduct = document.querySelector('.js-article-product');
    $articleExplain = document.querySelector('.js-article-explain');
    $articleBlog = document.querySelector('.js-article-blog');
    $articleAccess = document.querySelector('.js-article-access');
    $articleComment = document.querySelector('.js-article-comment');

    // ********************************************************
    // 関数
    // ********************************************************
    // メニューが押されたら、一つだけ表示
    function checkMenu(menuTab, menuTarget) {
        if(menuTab.checked === true) {
            menuTarget.classList.remove('u-display-none');
        }else{
            menuTarget.classList.add('u-display-none');
        }
    }
    // ********************************************************
    // 処理内容
    // ********************************************************
    checkMenu($menuProduct, $articleProduct);
    checkMenu($menuComment, $articleComment);
    $menuAll.forEach(function($tab) {
        $tab.addEventListener('click', function() {
            checkMenu($menuProduct, $articleProduct);
            checkMenu($menuExplain, $articleExplain);
            checkMenu($menuBlog, $articleBlog);
            checkMenu($menuAccess, $articleAccess);
            checkMenu($menuComment, $articleComment);
        });
    });
});