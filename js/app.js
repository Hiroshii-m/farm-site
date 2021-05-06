window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $headerNav = document.querySelector('.js-header-nav'),
        $headerList = document.querySelector('.js-header-list'),
        $spMenuTarget = document.querySelector('.js-sp-menu-target'),
        $favorites,
        $favorites2,
        likeShopId;

        $favorites = document.querySelectorAll(".js-click-animation") || null;
        $favorites2 = document.querySelectorAll(".js-click-animation2") || null;

    // ********************************************************
    // 関数
    // ********************************************************
    
    // ********************************************************
    // 処理内容
    // ********************************************************
    window.addEventListener("scroll", function() {
        if($spMenuTarget.offsetTop < window.scrollY) {
            $headerNav.classList.add('active');
            $headerList.classList.add('active');
        } else {
            $headerNav.classList.remove('active');
            $headerList.classList.remove('active');
        }
    });
    // お気に入りアイコンが押された場合
    if($favorites !== undefined && $favorites !== null) {
        $favorites.forEach(function($fav, index) {
            likeShopId = $fav.dataset.shopid || null;
            $fav.addEventListener("click", function() {
               
                var xhr = new XMLHttpRequest();
                var fd = new FormData();
                xhr.open("POST", "favorite.php");
                fd.set('shopId', likeShopId);
                xhr.addEventListener('readystatechange', function() {
                    if((xhr.readyState === 4) && (xhr.status === 200)) {
                        // styleを変える
                        $fav.classList.toggle('far');
                        $fav.classList.toggle('fas');
                        $fav.classList.toggle('is-active');
                        $favorites2[index].classList.toggle('is-active');
                    }
                });
                xhr.send(fd);
            });
        })
    }
});