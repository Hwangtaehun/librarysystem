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
            $u_ten = $_POST['ten'];
            $v_ten = (int)$u_ten * 10;
            $u_one = $_POST['one'];
            $v_one = (int)$u_one;

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>hundred_combox: $v_hundred";
            echo "ten combox: $v_ten";
            echo "one combox: $v_one";
            echo "total: $v_hundred + $v_ten + $v_one</p>";
        ?>
    </body>
</html>