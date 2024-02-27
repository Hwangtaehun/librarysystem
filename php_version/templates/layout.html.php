<!doctype html>
<html lang = "en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=1.0, user-scalable=no" charset = "utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title><?=$title?></title>
    </head>
    <?php
    //url 주소 만드는 함수
    function makehtml($menu, $menus){
        $m_script = '';
        for ($i=0; $i < sizeof($menus[$menu]) ; $i++) { 
            $m_url = $menus[$menu][$i][1];
            $m_title = $menus[$menu][$i][0];
            $m_script .= "<li><a class='dropdown-item' href='$m_url'>$m_title</a></li>";
        }
        return $m_script;
    }

    //팝업창 인지 확인
    if(isset($_GET['pop'])){
        if($_GET['pop'] == true){
            $not_pop = false;
        }
    }
    else if($title == '책검색'){
        $not_pop = false;
    }
    else{
        $not_pop = true;
        
        //회원 상태 확인
        if(isset($_SESSION['mem_state'])) {
            $state = $_SESSION['mem_state'];
        }
        else{
            $state = 2;
        }

        $menu_arr = explode(' ', $title);
        $menu = $menu_arr[0];        

        if($state != 1){
            if($title ==  '회원 수정'){
                $menu = '마이페이지';
            }
        }else{
            if($menu == '회원'){
                $menu = '기타';
            }
        }

        if($menu == '반납'){
            $menu = '대출';
        }
        else if($menu == '예약' || $menu == '연체'){
            $menu = '기타';
        }
        
        //관리 상태 매뉴 이름 및 url 생성    
        if($state == 1){
            $menus['공지사항'][0][0] = '공지사항관리';
            $menus['공지사항'][0][1] = '/not/list';
            $menus['공지사항'][1][0] = '공지사항추가';
            $menus['공지사항'][1][1] = '/not/addupdate';
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
            $menus['대출'][3][0] = '대출장소관리';
            $menus['대출'][3][1] = '/etc/plalist';
            $menus['상호대차'][0][0] = '상호대차관리';
            $menus['상호대차'][0][1] = '/del/list';
            $menus['상호대차'][1][0] = '상호대차도착일추가';
            $menus['상호대차'][1][1] = '/del/addlist';
            $menus['상호대차'][2][0] = '상호대차완료내역';
            $menus['상호대차'][2][1] = '/del/completelist';
            $menus['상호대차'][3][0] = '상호대차승인거절';
            $menus['상호대차'][3][1] = '/del/aprelist';
            $menus['기타'][0][0] = '회원관리';
            $menus['기타'][0][1] = '/member/list';
            $menus['기타'][1][0] = '예약관리';
            $menus['기타'][1][1] = '/res/list';
            $menus['기타'][2][0] = '연체관리';
            $menus['기타'][2][1] = '/etc/duelist';
        }
        else{
        //관리자 상태를 제외 모든 상태 이름과 url생성
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
        <header>
            <?php if($not_pop){ ?>
            <a href="/">
                <img src="../img/header.gif" alt="">
            </a>
            <div class="link">
            <?php
            if(!isset($_SESSION['mem_state'])){
                echo '<a href="/member/login">로그인</a>';
                echo '<a href="/member/addupdate">회원가입</a>';
            }
            else{
                $name = $_SESSION['mem_name'];
                echo '<a>'.$name.'님 환영합니다.</a>';
                echo '<a href="/member/logout">로그아웃</a>';
            }
            ?>
            </div>
            <?php }else{
                echo"<h1>$title</h1>";
            }?>
        </header>
        <?php
        if($not_pop){
        echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">';
            echo '<div class="container-fluid">';
                echo '<a class="navbar-brand" href="#">메뉴</a>';
                echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">';
                    echo '<span class="navbar-toggler-icon"></span>';
                echo '</button>';
                echo '<div class="collapse navbar-collapse" id="navbarNavDropdown">';
                    echo '<ul class="navbar-nav">';
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="/">홈</a></li>';
                        if($state == 1){
                            echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">공지사항</a>';
                            echo '<ul class="dropdown-menu">';
                            $script = makehtml('공지사항', $menus);
                            echo $script;
                            echo '</ul></li>';
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
                            echo '<li class="nav-item"><a class="nav-link" href="/not/list">공지사항</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="/lib/list">도서관</a></li>';
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
                    echo '</ul>';
                echo '</div>';
            echo '</div>';
        echo '</nav>';
        }
        if($not_pop){
            if($state != 1){
                if($title != '자료 현황' && $title != '도서관 관리' && $title != '로그인' && 
                   $title != '회원가입' && $title != '공지사항 현황' && $title != '공지사항 수정' && $title != '도서관 정보'){

                    if($menu != '마이페이지'){
                        $menu = '내서재';
                    }

                    echo "<aside><menu><li><h3>$menu</h3></li>";
                    $script = makehtml($menu, $menus);
                    echo $script;    
                    echo "</menu></aside>";
                }
            }
            else{
                if($title != '도서관 관리'){
                    echo "";
                    echo "<aside><menu><li><h3>$menu</h3></li>";
                    $script = makehtml($menu, $menus);
                    echo $script;    
                    echo "</menu></aside>";
                }
            }
        } 
        ?>
        <main>
            <?= $outString  ?>
            <?php if(isset($page['pagi'])){echo $page['pagi'];}?>
        </main>
        <footer>
            <img src="../img/footer.gif" alt="">
            <?php
            if($not_pop){
                echo "<div class='table_menu'><table>";
                if($state == 1){
                    echo "<tr><th>공지사항</th> <th>책</th> <th>종류</th> <th>도서관</th> <th>자료</th> <th>대출</th> <th>상호대차</th> <th>기타</th></tr>";
                    $num = 0;
                    echo '<tr><td><a href="'.$menus['공지사항'][$num][1].'">'.$menus['공지사항'][$num][0].'</a></td><td><a href="'.$menus['책'][$num][1].'">'.$menus['책'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['종류'][$num][1].'">'.$menus['종류'][$num][0].'</a></td><td><a href="'.$menus['도서관'][$num][1].'">'.$menus['도서관'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['자료'][$num][1].'">'.$menus['자료'][$num][0].'</a></td><td><a href="'.$menus['대출'][$num][1].'">'.$menus['대출'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['상호대차'][$num][1].'">'.$menus['상호대차'][$num][0].'</a></td><td><a href="'.$menus['기타'][$num][1].'">'.$menus['기타'][$num][0].'</a></td></tr>';
                    $num = 1;
                    echo '<tr><td><a href="'.$menus['공지사항'][$num][1].'">'.$menus['공지사항'][$num][0].'</a></td><td><a href="'.$menus['책'][$num][1].'">'.$menus['책'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['종류'][$num][1].'">'.$menus['종류'][$num][0].'</a></td><td><a href="'.$menus['도서관'][$num][1].'">'.$menus['도서관'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['자료'][$num][1].'">'.$menus['자료'][$num][0].'</a></td><td><a href="'.$menus['대출'][$num][1].'">'.$menus['대출'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['상호대차'][$num][1].'">'.$menus['상호대차'][$num][0].'</a></td><td><a href="'.$menus['기타'][$num][1].'">'.$menus['기타'][$num][0].'</a></td></tr>';
                    $num = 2;
                    echo '<tr><td></td><td></td><td></td><td></td><td></td><td><a href="'.$menus['대출'][$num][1].'">'.$menus['대출'][$num][0].'</a></td>';
                    echo '<td><a href="'.$menus['상호대차'][$num][1].'">'.$menus['상호대차'][$num][0].'</a></td><td><a href="'.$menus['기타'][$num][1].'">'.$menus['기타'][$num][0].'</a></td></tr>';
                    $num = 3;
                    echo '<tr><td></td><td></td><td></td><td></td><td></td><td><a href="'.$menus['대출'][$num][1].'">'.$menus['대출'][$num][0].'</a></td><td><a href="'.$menus['상호대차'][$num][1].'">'.$menus['상호대차'][$num][0].'</a></td>';
                }else{
                    echo "<tr><th>공지사항</th> <th>도서관</th> <th>자료 검색</th> <th>내서재</th> <th>마이페이지</th></tr>";
                    echo '<tr><td><a href="/not/list">공지사항</a></td><td><a href="/lib/list">도서관</a></td><td><a href="/mat/list">자료검색</a></td><td><a href="'.$menus['내서재'][0][1].'">'.$menus['내서재'][0][0].'</a></td><td><a href="'.$menus['마이페이지'][0][1].'">'.$menus['마이페이지'][0][0].'</a></td></tr>';
                    echo '<tr><td></td><td></td><td><a href="'.$menus['내서재'][1][1].'">'.$menus['내서재'][1][0].'</a></td><td><a href="'.$menus['마이페이지'][1][1].'">'.$menus['마이페이지'][1][0].'</a></td></tr>';
                    echo '<tr><td></td><td></td><td><a href="'.$menus['내서재'][2][1].'">'.$menus['내서재'][2][0].'</a></td><td></td></tr>';
                    echo '<tr><td></td><td></td><td><a href="'.$menus['내서재'][3][1].'">'.$menus['내서재'][3][0].'</a></td><td></td></tr>';
                }
                echo "</table></div>";
            }
            ?>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>