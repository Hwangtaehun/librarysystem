<!doctype html>
<html>
    <head>
        <meta charset = "utf-8">
        <link rel="stylesheet" href="css/form.css">
        <title><?=$title?></title>
    </head>
    <body>
        <header>
            <h1><?=$title?></h1>
        </header>
        <nav>
            <ul>
               <?php
               $state = $_SESSION['mem_state'];
               if($state == 1){
                echo '<li><a href="php/index.php">홈</a><li>';
                echo '<li><a href="php/book.php">책</a><li>';
                echo '<li><a href="php/kind.php">종류</a><li>';
                echo '<li><a href="php/library.php">도서관</a><li>';
                echo '<li><a href="php/material.php">자료</a><li>';
                echo '<li><a href="php/member.php">회원</a><li>';
                echo '<li><a href="php/lent.php">대출 및 반납</a><li>';
                echo '<li><a href="php/delivery.php">상호대차</a><li>';
                echo '<li><a href="php/etc.php">기타</a><li>';
               }
               else{
                echo '<li><a href="php/index.php">홈</a><li>';
                echo '<li><a href="php/material.php">자료 검색</a><li>';
                echo '<li><a href="php/book.php">내서재</a><li>';
                echo '<li><a href="php/member.php">마이페이지</a><li>';
               }
               echo '<li id="out"><a href="php/loginout.php">로그아웃</a></li>';
               ?>
            </ul>
        </nav>
        <main>
            <?= $outString ?>
        </main>
        <footer>
            <h4>세종 컴퓨터 학원 충북 청주시 사창동</h4>
        </footer>
    </body>
</html>