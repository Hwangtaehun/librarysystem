<!DOCTYPE html>
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
</html>