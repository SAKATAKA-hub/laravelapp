{
    "use strict";
    //-----------------------------------------------------------
    // 添付画像の読み込み
    // <input type="file" id="myImage" accept="image/*" onchange="setImage(this);" onclick="this.value = '';">
    // <img id="preview">
    //-----------------------------------------------------------
    function setImage(target) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("preview").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(target.files[0]);
    };


}
