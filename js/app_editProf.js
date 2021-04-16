window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $areaDrop = document.querySelector(".js-area-drop");
    var $fileInput = document.querySelector(".js-file-input");

    // ********************************************************
    // 関数
    // ********************************************************
    
    // ********************************************************
    // 処理内容
    // ********************************************************
    // ページ遷移を防ぐ　画像プレビューまでキャンセルしてしまうので、画像プレビューだけ、イベントできるようにしないといけない。==TODO==
    // window.ondrop = function(e) {
    //     e.preventDefault();
    // }
    // window.ondragover = function(e) {
    //     e.preventDefault();
    // }
    // 画像プレビューの処理
    $areaDrop.addEventListener("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.classList.add("active");
    });
    $areaDrop.addEventListener("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.classList.remove("active");
    });
    $fileInput.addEventListener("change", function() {
        $areaDrop.classList.remove("active");
        var file = this.files[0],
            $input = this,
            $img = this.nextElementSibling,
            $text = $img.nextElementSibling,
            fileReader = new FileReader();

        fileReader.onload = function(event) {
            $img.setAttribute("src", event.target.result);
            $img.classList.remove("u-display-none");
            $input.classList.add("u-display-none");
            $text.classList.add("u-display-none");
        }

        fileReader.readAsDataURL(file);
    });
});