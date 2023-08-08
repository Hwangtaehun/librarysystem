<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
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
<body class="center">
    <header>
        <h1> <?=$title?></h1>
    </header>
    <form action="./php/loginout.php" method="post" onSubmit="return checkInput(this)">
        <label for = "user_id">아이디</label>
        <input type="text" name="user_id" id="user_id" value=""><br>
        <label for = "user_password">비밀번호</label>
        <input type="password" name="user_password" id="user_password"><br><br>
        <input type=submit value='로그인'>
    </form>
    <a href="./php/member.php?title=회원가입">회원가입</a>
</body>
</html>

<!-- <!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body class="center">
        <header>
            <h1> <?=$title?></h1>
        </header>
        <form action="./php/loginout.php" method="post" onSubmit="return checkInput(this)">
            <label for = "user_id">아이디</label>
            <input type="text" name="user_id" id="user_id" value=""><br>
            <label for = "user_password">비밀번호</label>
            <input type="password" name="user_password" id="user_password"><br><br>
            <input type=submit value='로그인'>
        </form>
        <a href="./php/member.php?title=회원가입">회원가입</a>
    </body>
</html> -->