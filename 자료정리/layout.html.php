<!doctype html>
<html>
    <head>
        <meta charset = "utf-8">
        <link rel="stylesheet" href="../css/form.css">
        <title><?=$title?></title>
        <script>
            var state = 0;
            <?php
            if(isset($_SESSION['mem_state'])) {
                $state = $_SESSION['mem_state'];
                echo 'state = '.$state;
            }
            ?>

            if(state == 1){
                var menus = [
                {
                    menu: "책",
                    title: "책관리",
                    url: "/book/list",
                },
                {
                    menu: "책",
                    title: "책추가",
                    url: "/book/addupdate",
                },
                {
                    menu: "종류",
                    title: "종류관리",
                    url: "/kind/list",
                },
                {
                    menu: "종류",
                    title: "종류추가",
                    url: "/kind/addupdate",
                },
                {
                    menu: "도서관",
                    title: "도서관관리",
                    url: "/lib/list",
                },
                {
                    menu: "도서관",
                    title: "도서관추가",
                    url: "/lib/addupdate",
                },
                {
                    menu: "자료",
                    title: "자료관리",
                    url: "/mat/list",
                },
                {
                    menu: "자료",
                    title: "자료추가",
                    url: "/mat/addupdate",
                },
                {
                    menu: "대출 및 반납",
                    title: "대출관리",
                    url: "/len/list",
                },
                {
                    menu: "대출 및 반납",
                    title: "대출추가",
                    url: "/len/addupdate",
                },
                {
                    menu: "대출 및 반납",
                    title: "반납추가",
                    url: "/len/returnLent",
                },
                {
                    menu: "상호대차",
                    title: "상호대차관리",
                    url: "/del/list",
                },
                {
                    menu: "상호대차",
                    title: "상호대차도착일추가",
                    url: "/del/addlist",
                },
                {
                    menu: "상호대차",
                    title: "상호대차완료내역",
                    url: "/del/completelist",
                },
                {
                    menu: "기타",
                    title: "예약관리",
                    url: "/res/list",
                },
                {
                    menu: "기타",
                    title: "대출장소관리",
                    url: "/etc/plalist",
                },
                {
                    menu: "기타",
                    title: "예약관리",
                    url: "/etc/duelist",
                }
            ]  
            }
            else{
                var mem_no;
                <?php
                if(isset($_SESSION['mem_no'])){
                    $mem_no = $_SESSION['mem_no'];
                    echo 'mem_no = '.$mem_no;
                }
                ?>
                var menus = [
                    {
                    menu: "내서재",
                    title: "대출중도서",
                    url: "/len/memLent",
                    },
                    {
                    menu: "내서재",
                    title: "모든대출내역",
                    url: "/len/memAllLent",
                    },
                    {
                    menu: "내서재",
                    title: "예약내역",
                    url: "/res/list",
                    },
                    {
                    menu: "내서재",
                    title: "상호대차내역",
                    url: "/del/list",
                    },
                    {
                    menu: "마이페이지",
                    title: "회원정보수정",
                    url: "/member/addupdate?mem_no=" + mem_no,
                    },
                    {
                    menu: "마이페이지",
                    title: "회원탈퇴",
                    url: "/member/memdel?mem_no=" + mem_no,
                    }
                ]
            }

            function filter_title(menu){
                let temp = Array();
                for(let i = 0; i < menus.length; i++){
                    if(menus[i].menu === menu){
                        temp.push(i);
                    }
                }
                return temp;
            }
            
            function filter_url(menu){
                let temp = Array();
                for (let i = 0; i < menus.length; i++) {
                    if(menus[i].menu === menu){
                        temp.push(i);
                    }
                }
                return temp;
            }

            <?php
            $menu = explode(' ', $title);
            echo "var menu = $menu;";
            ?>
        </script>
    </head>
    <body>
        <header>
            <h1><?=$title?></h1>
        </header>
        <nav>
            <ul>
               <?php
                $bool = true;
                if(isset($_GET['pop'])){
                    $bool = false;
                }
                if($bool){
                    $state = $_SESSION['mem_state'];
                    echo '<li><a href="/">홈</a><li>';
                    if($state == 1){
                        echo '<li><a>책</a><ul><li><a href="/book/list">책관리</a></li><li><a href="/book/addupdate">책추가</a></li></ul></li>';
                        echo '<li><a>종류</a><ul><li><a href="/kind/list">종류관리</a></li><li><a href="/kind/addupdate">종류추가</a></li></ul></li>';
                        echo '<li><a>도서관</a><ul><li><a href="/lib/list">도서관관리</a></li><li><a href="/lib/addupdate">도서관추가</a></li></ul></li>';
                        echo '<li><a>자료</a><ul><li><a href="/mat/list">자료관리</a></li><li><a href="/mat/addupdate">자료추가</a></li></ul></li>';
                        echo '<li><a href="/member/list">회원</a></li>';
                        echo '<li><a>대출 및 반납</a><ul><li><a href="/len/list">대출관리</a></li><li><a href="/len/addupdate">대출추가</a></li><li><a href="/len/returnLent">반납추가</a></li></ul></li>';
                        echo '<li><a>상호대차</a><ul><li><a href="/del/list">상호대차관리</a></li><li><a href="/del/addlist">상호대차도착일추가</a></li><li><a href="/del/completelist">상호대차완료내역</a></li></ul></li>';
                        echo '<li><a>기타</a><ul><li><a href="/res/list">예약관리</a></li><li><a href="/etc/plalist">대출장소관리</a></li><li><a href="/etc/duelist">연체관리</a></li></ul></li>';
                    }
                    else{
                        $mem_no = $_SESSION['mem_no'];
                        echo '<li><a href="/mat/list">자료 검색</a><li>';
                        echo '<li><a>내서재</a><ul><li><a href="/len/memLent">대출중도서</a></li><li><a href="/len/memAllLent">모든대출내역</a></li><li><a href="/res/list">예약내역</a></li><li><a href="/del/list">상호대차내역</a></li></ul></li>';
                        echo '<li><a>마이페이지</a><ul><li><a href="/member/addupdate?mem_no='.$mem_no.'">회원정보수정</a></li><li><a href="/member/memdel?mem_no='.$mem_no.'">회원탈퇴</a></li></ul></li>';
                    }
                    echo '<li><a href="/member/logout">로그아웃</a></li>';
                }
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