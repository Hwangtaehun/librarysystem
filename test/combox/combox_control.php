<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            $u_combox = $_POST['combox'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>combox: $u_combox</p>";
        ?>
    </body>
</html>