window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $areaDrops = document.querySelectorAll(".js-area-drop");
    var $fileInputs = document.querySelectorAll(".js-file-input");
    var $avatarImgs = document.querySelectorAll(".js-avatar-img");

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
    // 画像がなければ、imgタグを非表示
    $avatarImgs.forEach(function($img) {
        if(!$img.getAttribute('src')) {
            $img.classList.add("u-display-none");
        }else{
            $img.classList.remove("u-display-none");
        }
    });
    // 画像プレビューの処理
    $areaDrops.forEach(function($areaDrop) {
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
    });
    $fileInputs.forEach(function($fileInput) {
        $fileInput.addEventListener("change", function() {
            $areaDrops.forEach(function($areaDrop) {
                $areaDrop.classList.remove("active");
            });
            var file = this.files[0],
                $img = this.nextElementSibling,
                $text = $img.nextElementSibling,
                fileReader = new FileReader();
    
            fileReader.onload = function(event) {
                $img.setAttribute("src", event.target.result);
                $img.classList.remove("u-display-none");
                $text.classList.add("u-display-none");
            }
        
            fileReader.readAsDataURL(file);
        });
    });
});