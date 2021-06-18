{
    "use strict";

    //-----------------------------------------------------------
    //  コンフォーム
    //-----------------------------------------------------------
    function deleteConfirm()
    {
        if(window.confirm('登録情報を削除します。よろしいですか？')) // 確認ダイアログを表示
        {
            return true; // 「OK」時は送信を実行
        }
        else // 「キャンセル」時の処理
        {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }

}
