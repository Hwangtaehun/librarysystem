<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            $p_url = $_POST['not_pop_url'];
            $b_url = $_POST['not_ban_url'];
            $context = $_POST['not_detail'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>not_ban_url: $b_url<br>";
            echo "not_pop_url: $p_url<br>";
            echo "context: $context<br></p>";

            var_dump($_FILES);
            $tempFile1 = $_FILES['not_pop_url']['tmp_name'];
            $tempFile2 = $_FILES['not_ban_url']['tmp_name'];
            echo "<p>tempFile1 = $tempFile1<br>";
            echo "tempFile2 = $tempFle2<br></p>"
        ?>
    </body>
</html>