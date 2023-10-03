<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/form.css">
        <title><?=$title?></title>
        <script>
            function checkInput(myform){
                if(myform.user_id.value.length <= 0){
                    alert("아이디를 입력하세요.");
                    myform.user_name.focus();
                    return false;
                }
                if(myform.user_password.value.length <= 0){
                    alert("비밀번호를 입력하세요.");
                    myform.user_password.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>
        <form action="/member/login" method="post" onSubmit="return checkInput(this)">
            <input class="login" type="text" name="user_id" id="user_id" value="" placeholder="아이디"><br>
            <input class="login" type="password" name="user_password" id="user_password" placeholder="비밀번호"><br><br>
            <input id="but" type=submit value='로그인'>
        </form>
    </body>
</html>