<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/form-noaside.css">
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
        <div class = "auth_page">
            <h1><?=$title?></h1>
            <form class = "auth_input" action="/member/login" method="post" onSubmit="return checkInput(this)">
                <input class="form-control" type="text" name="user_id" id="user_id" value="" placeholder="아이디">
                <input class="form-control" type="password" name="user_password" id="user_password" placeholder="비밀번호">
                <input type="submit" class="btn btn-outline-primary" value='로그인'>
            </form>
        </div>
    </body>
</html>