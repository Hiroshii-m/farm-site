window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $modal = document.querySelector('.js-modal'),
        $modal_body = document.querySelector('.js-modal-body'),
        $delete_product = document.querySelectorAll('.js-delete-product'),
        $modal_close = document.querySelector('.js-modal-close'),
        $modal_no = document.querySelector('.js-modal-no'),
        $modal_value = document.querySelector('.js-modal-value');

    // ********************************************************
    // 関数
    // ********************************************************
    
    // ********************************************************
    // 処理内容
    // ********************************************************
    $delete_product.forEach(function($del, index) {
        $del.addEventListener("click", function() {
            $modal.classList.add('open');
            $modal_body.classList.add('open');
            var del_id = $del.getAttribute("value");
            $modal_value.value = del_id;
        });
    });
    $modal_close.addEventListener("click", function() {
        $modal.classList.remove('open');
        $modal_body.classList.remove('open');
    });
    $modal_no.addEventListener("click", function() {
        $modal.classList.remove('open');
        $modal_body.classList.remove('open');
    });
    $modal.addEventListener("click", function(e) {
        $modal.classList.remove('open');
        $modal_body.classList.remove('open');
    });
    $modal_body.addEventListener("click", function(e) {
        e.stopPropagation();
    });
});