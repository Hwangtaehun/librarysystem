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
            $u_ten = $_POST['ten'];
            $u_one = $_POST['one'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>hundred_combox: $u_hundred<br>";
            echo "ten combox: $u_ten<br>";
            echo "one combox: $u_one<br></p>";
        ?>
    </body>
</html>