window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $favs1 = document.querySelectorAll(".js-click-animation");
    var $favs2 = document.querySelectorAll(".js-click-animation2");
    // ********************************************************
    // 関数
    // ********************************************************

    // ********************************************************
    // 処理内容
    // ********************************************************
    $favs1.forEach(function($fav, index) {
        $fav.addEventListener("click", function() {
            $fav.classList.toggle('far');
            $fav.classList.toggle('fas');
            $fav.classList.toggle('is-active');
            $favs2[index].classList.toggle('is-active');
        });
    });
});