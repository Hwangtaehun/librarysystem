<!DOCTYPE html>
<html lang="ko">
 <head>
  <meta charset="utf-8">
  <title>로그인 화면</title>
  <link rel = "stylesheet" href="..\css\form.css" />
 </head>
 <body>
  <h2>Form Tag 입력 확인(PHP 함수사용)</h2>
  <form action="sj3052.php" method="post">
    <label for = "user_name">이름 : </label>
    <input type = "text" name = "user_name" id = "user_name" value = "">
        
    <label for = "user_password">비밀번호 : </label>
    <input type = "password" name = "user_password" id = "user_password" value="">
        
    <input type = submit value = '입력'>
    <input type = reset value = '지우기'>
  </form>
 </body>
</html>