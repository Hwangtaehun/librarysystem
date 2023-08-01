<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            $u_super = $_POST['super'];
            $u_base = $_POST['base'];
            $u_sub = $_POST['sup'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>대분류: $u_super<br>";
            echo "중분류: $u_base<br>";
            echo "소분류: $u_sub<br></p>";
        ?>
    </body>
</html>