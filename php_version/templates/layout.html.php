<!doctype html>
<html>
    <head>
        <meta charset = "utf-8">
        <link rel="stylesheet" href="../css/form.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title><?=$title?></title>
        <script>
        <?php
        function makehtml($menu, $menus){
            $m_script = '';
            for ($i=0; $i < sizeof($menus[$menu]) ; $i++) { 
                $m_url = $menus[$menu][$i][1];
                $m_title = $menus[$menu][$i][0];
                $m_script .= "<li><a class='dropdown-item' href='$m_url'>$m_title</a></li>";
            }
            return $m_script;
        }
        ?>
        </script>
    </head>
    <?php
    if(isset($_GET['pop'])){
        $bool = false;
        $state = 3;
    }
    else{
        $bool = true;
        $state = 3;

        if($title == '대출 장소 현황'){
            $menu = '기타';
        } 
        else{
            $menu_arr = explode(' ', $title);
            if(sizeof($menu_arr) == 1){
                if($menu_arr[0] == '로그인'){
                    $menu = '마이페이지';
                }
                else{
                    $menu = '내서재';
                }
            }
            else{
                $menu = $menu_arr[0];
            }
        }          

        if(isset($_SESSION['mem_state'])) {
            $state = $_SESSION['mem_state'];
        }

        if($state != 1){
            if($title ==  '회원 수정'){
                $menu = '마이페이지';
            }
        }

        if($menu == '반납'){
            $menu = '대출';
        }
        else if($menu == '예약' || $menu == '연체'){
            $menu = '기타';
        }
        
            
        if($state == 1){
            $menus['책'][0][0] = '책관리';
            $menus['책'][0][1] = '/book/list';
            $menus['책'][1][0] = '책추가';
            $menus['책'][1][1] = '/book/addupdate';
            $menus['종류'][0][0] = '종류관리';
            $menus['종류'][0][1] = '/kind/list';
            $menus['종류'][1][0] = '종류추가';
            $menus['종류'][1][1] = '/kind/addupdate';
            $menus['도서관'][0][0] = '도서관관리';
            $menus['도서관'][0][1] = '/lib/list';
            $menus['도서관'][1][0] = '도서관추가';
            $menus['도서관'][1][1] = '/lib/addupdate';
            $menus['자료'][0][0] = '자료관리';
            $menus['자료'][0][1] = '/mat/list';
            $menus['자료'][1][0] = '자료추가';
            $menus['자료'][1][1] = '/mat/addupdate';
            $menus['대출'][0][0] = '대출관리';
            $menus['대출'][0][1] = '/len/list';
            $menus['대출'][1][0] = '대출추가';
            $menus['대출'][1][1] = '/len/addupdate';
            $menus['대출'][2][0] = '반납추가';
            $menus['대출'][2][1] = '/len/returnLent';
            $menus['상호대차'][0][0] = '상호대차관리';
            $menus['상호대차'][0][1] = '/del/list';
            $menus['상호대차'][1][0] = '상호대차도착일추가';
            $menus['상호대차'][1][1] = '/del/addlist';
            $menus['상호대차'][2][0] = '상호대차완료내역';
            $menus['상호대차'][2][1] = '/del/completelist';
            $menus['기타'][0][0] = '예약관리';
            $menus['기타'][0][1] = '/res/list';
            $menus['기타'][1][0] = '대출장소관리';
            $menus['기타'][1][1] = '/etc/plalist';
            $menus['기타'][1][0] = '연체관리';
            $menus['기타'][1][1] = '/etc/duelist';
        }
        else{
            $menus['내서재'][0][0] = '대출중도서';
            $menus['내서재'][1][0] = '모든대출내역';
            $menus['내서재'][2][0] = '예약내역';
            $menus['내서재'][3][0] = '상호대차내역';
            $menus['마이페이지'][0][0] = '회원정보수정';
            $menus['마이페이지'][1][0] = '회원탈퇴';
            if(isset($_SESSION['mem_no'])){
                $mem_no = $_SESSION['mem_no'];
                $menus['내서재'][0][1] = '/len/memLent';                
                $menus['내서재'][1][1] = '/len/memAllLent';                
                $menus['내서재'][2][1] = '/res/list';                
                $menus['내서재'][3][1] = '/del/list';                
                $menus['마이페이지'][0][1] = '/member/addupdate?mem_no='.$mem_no;               
                $menus['마이페이지'][1][1] = '/member/memdel?mem_no='.$mem_no;
            }
            else{
                $menus['내서재'][0][1] = '/member/logalert';                
                $menus['내서재'][1][1] = '/member/logalert';                
                $menus['내서재'][2][1] = '/member/logalert';               
                $menus['내서재'][3][1] = '/member/logalert';                
                $menus['마이페이지'][0][1] = '/member/logalert';               
                $menus['마이페이지'][1][1] = '/member/logalert';
            }
        }
    }
    ?>
    <body>
        <?php if(!isset($_GET['pop'])){ ?>
        <div class="link">
        <?php
        if(!isset($_SESSION['mem_state'])){
            echo '<li><a href="/member/login">로그인</a></li>';
            echo '<li><a href="/member/addupdate">회원가입</a></li>';
        }
        else{
            $name = $_SESSION['mem_name'];
            echo '<li><a>'.$name.'님</a></li>';
            echo '<li><a href="/member/logout">로그아웃</a></li>';
        }
        ?>
        </div>
        <?php } ?>
        <header>
            <h1><?=$title?></h1>
        </header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <ul class="nav nav-pills">
                <?php
                if($bool){
                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="/">홈</a></li>';
                    if($state == 1){
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">책</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('책', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">종류</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('종류', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">도서관</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('도서관', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">자료</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('자료', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/member/list">회원</a></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">대출 및 반납</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('대출', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">상호대차</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('상호대차', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">기타</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('기타', $menus);
                        echo $script;
                        echo '</ul></li>';
                    }
                    else{
                        echo '<li class="nav-item"><a class="nav-link" href="/mat/list">자료 검색</a></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">내서재</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('내서재', $menus);
                        echo $script;
                        echo '</ul></li>';
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">마이페이지</a>';
                        echo '<ul class="dropdown-menu">';
                        $script = makehtml('마이페이지', $menus);
                        echo $script;
                        echo '</ul></li>';
                    }
                }
                ?>
            </ul>
        </nav>
        <?php
        if($state != 1){
            if($title != '자료 현황' && $title != '도서관 관리'){
                if($bool){
                    echo "<aside>";
                    echo "<li><a><h3>$menu</h3></a>";
                    $script = makehtml($menu, $menus);
                    echo $script;    
                    echo "</li>";
                    echo "</aside>";
                }
            }
        }
        else{
            if($title != '회원 현황' && $title != '도서관 관리'){
                if($bool){
                    echo "<aside>";
                    echo "<li><a><h3>$menu</h3></a>";
                    $script = makehtml($menu, $menus);
                    echo $script;    
                    echo "</li>";
                    echo "</aside>";
                }
            }
        } 
        ?>
        <main>
            <?= $outString ?>
        </main>
        <footer>
            <h4>청주 도서관 관리</h4>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>