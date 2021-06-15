{
    "use strict";

    //-----------------------------------------------------------
    //  チェックボックスに関する関数
    //-----------------------------------------------------------
    // #「すべて選択」で全てのチェックボックスにチェックが付く
    function ALLChecked(all){
        const checksName = all.name.replace('_all','[]');
        const checks = document.forms['seach'].elements[checksName];

        for (let i = 0; i < checks.length; i++)
        {
            checks[i].checked = all.checked;
        }
    }

    // #「すべて選択」で全てのチェックボックスにチェックが付く
    function DisCheck(check)
    {
        const allName = check.name.replace('[]','_all');
        const all = document.forms['seach'].elements[allName];
        const checks = document.forms['seach'].elements[check.name];

        var checkCount = 0;
        for (let i = 0; i < checks.length; i++) {
            if(checks[i].checked)
            {
                checkCount ++;
                if(checkCount===checks.length){all.checked = true;}
            }
            else
            {
                all.checked = false;
            }
        }
    }


}
