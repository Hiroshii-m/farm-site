window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $headerNav = document.querySelector('.js-header-nav'),
        $headerList = document.querySelector('.js-header-list'),
        $spMenuTarget,
        $favorites,
        $favorites2,
        likeShopId,
        $showMsg,
        $goTop,
        $cardTexts;

        $spMenuTarget = document.querySelector('.js-sp-menu-target') || null;
        $favorites = document.querySelectorAll(".js-click-animation") || null;
        $favorites2 = document.querySelectorAll(".js-click-animation2") || null;
        $showMsg = document.querySelector(".js-show-msg") || null;
        $goTop = document.querySelector(".js-goTop") || null;
        $cardTexts = document.querySelectorAll(".js-card-text") || null;
    // ********************************************************
    // 関数
    // ********************************************************
    
    // ********************************************************
    // 処理内容
    // ********************************************************
    // cardText内を42文字いないに調整する
    if($cardTexts !== null) {
        $cardTexts.forEach(function(cardText){
            var length = 42;
            if(length < cardText.textContent.length){
                cardText.textContent = cardText.textContent.substring(0, length-2) + ' ...';
            }
        });
    }
    // js-goTopボタンを押した場合、トップへ移動する
    if($goTop !== null) {
        $goTop.addEventListener("click", function() {
            scrollTo(0, 0);
        });
    }
    // フラッシュメッセージの動き
    if($showMsg !== null) {
        if($showMsg.textContent.replace(/^[\s　]+|[\s　]+$/g, "").length) {
            setTimeout(function(){ $showMsg.classList.add('active'); }, 10);
            setTimeout(function(){ $showMsg.classList.remove('active'); }, 4000);
        }
    }
    // if
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
            $fav.addEventListener("click", function() {
                likeShopId = $fav.dataset.shopid || null;
                // var xhr = new XMLHttpRequest();
                // var fd = new FormData();
                
                // xhr.open("POST", "../favorite.php", true);
                // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                // fd.set('shopId', likeShopId);
                // xhr.addEventListener('readystatechange', function() {
                //     if((xhr.readyState === 4) && (xhr.status === 200)) {
                //         // styleを変える
                //         $fav.classList.toggle('far');
                //         $fav.classList.toggle('fas');
                //         $fav.classList.toggle('is-active');
                //         $favorites2[index].classList.toggle('is-active');
                //         xhr.send(fd);
                //     }
                // });
                $.ajax({
                    type: "POST",
                    url: "../favorite.php",
                    data: { shopid: likeShopId }
                }).done( function ( data ){
                    $fav.classList.toggle('far');
                    $fav.classList.toggle('fas');
                    $fav.classList.toggle('is-active');
                    $favorites2[index].classList.toggle('is-active');
                }).fail(function ( msg ){
                    console.log('fail');
                });
            });
        })
    }
});