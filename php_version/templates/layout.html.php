<!doctype html>
<html>
    <head>
        <meta charset = "utf-8">
        <link rel="stylesheet" href="../css/form.css">
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
               echo '<li><a href="/">홈</a><li>';
               if($state == 1){
                echo '<li><a>책</a><ul><li><a href="/book/list">책관리</a></li><li><a href="/book/addupdate">책추가</a></li></ul></li>';
                echo '<li><a>종류</a><ul><li><a href="/kind/list">종류관리</a></li><li><a href="/kind/addupdate">종류추가</a></li></ul></li>';
                echo '<li><a>도서관</a><ul><li><a href="/lib/list">도서관관리</a></li><li><a href="/lib/addupdate">도서관추가</a></li></ul></li>';
                echo '<li><a>자료</a><ul><li><a href="/mat/list">자료관리</a></li><li><a href="#">자료추가</a></li></ul></li>';
                echo '<li><a href="/member/list">회원</a></li>';
                echo '<li><a>대출 및 반납</a><ul><li><a href="#">대출관리</a></li><li><a href="#">대출추가</a></li><li><a href="#">반납추가</a></li></ul></li>';
                echo '<li><a>상호대차</a><ul><li><a href="#">상호대차관리</a></li><li><a href="#">상호대차도착일추가</a></li><li><a href="#">상호대차완료내역</a></li></ul></li>';
                echo '<li><a>기타</a><ul><li><a href="#">예약관리</a></li><li><a href="#">대출장소관리</a></li><li><a href="#">연체관리</a></li></ul></li>';
               }
               else{
                $mem_no = $_SESSION['mem_no'];
                echo '<li><a href="/mat/list">자료 검색</a><li>';
                echo '<li><a>내서재</a><ul><li><a href="#">대출중도서</a></li><li><a href="#">모든대출내역</a></li><li><a href="#">예약내역</a></li><li><a href="#">상호대차내역</a></li></ul></li>';
                echo '<li><a>마이페이지</a><ul><li><a href="/member/addupdate?mem_no='.$mem_no.'">회원정보수정</a></li><li><a href="/member/memdel?mem_no='.$mem_no.'">회원탈퇴</a></li></ul></li>';
               }
               echo '<li><a href="/member/logout">로그아웃</a></li>';
               ?>
            </ul>
        </nav>
        <main>
            <?= $outString ?>
        </main>
        <footer>
            <h4>청주 도서관 관리</h4>
        </footer>
    </body>
</html>