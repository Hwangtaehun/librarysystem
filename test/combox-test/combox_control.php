<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            $u_hundred = $_POST['hundred'];
            $v_hundred = (int)$u_hundred * 100;

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>combox: $v_hundred</p>";
        ?>
    </body>
</html>