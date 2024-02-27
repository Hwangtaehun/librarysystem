<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/form-home.css">
        <script defer>
            var cnt = 1;
            <?php
            if($close == ''){
                echo "let rest = 7;";
            }else{
                echo "let rest = $close;";
            }
            ?>
        </script>
        <script defer src="../js/calendar.js"></script>
    </head>
    <?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Assistance.php';
    $assist = new Assistance();
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", true);
    $lib = $lib_man->result_call();
    $mem_state = 3;
    if(isset($_SESSION['mem_state'])){
        $mem_state = $_SESSION['mem_state'];
    }

    if(isset($_SESSION['mem_no'])){
        $mem_no = $_SESSION['mem_no'];
    }
    ?>
    <body>
        <!-- 검색창 -->
<?php if($mem_state != 1){ ?>
        <form action="/mat/research" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <select id = "s1" name = "lib_research">
                    <?php
                    for($z = 0; $z < sizeof($lib); $z++){
                        $no[$z] = $lib[$z][0]; 
                        if($lib[$z][1] == '없음'){
                            $name[$z] = '전체';
                        }else{
                            $name[$z] = $lib[$z][1];
                        }
                    }
                    for($z = 0;$z < sizeof($lib); $z++){
                        echo "<option  value = $no[$z] > $name[$z] </option>";
                    }
                    ?>
                </select>
                <input type="text" name="user_research" id="id_research" value = "" placeholder="도서 이름을 입력해주세요.">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        </form>
<?php }else{ ?>
        <div class="quickmenu">
            <div class="quick" id="menu1">
                <a href="/not/list">
                    <img src="../img/icon/icon3.png" alt="">
                </a>
                <h6>공지사항관리</h6>
            </div>
            <div class="quick" id="menu2">
                <a href="/not/addupdate">
                    <img src="../img/icon/icon11.png" alt="">
                </a>
                <h6>공지사항추가</h6>
            </div>
            <div class="quick" id="menu3">
                <a href="/len/addupdate">
                    <img src="../img/icon/icon4.png" alt="">
                </a>
                <h6>대출추가</h6>
            </div>
            <div class="quick" id="menu4">
                <a href="/len/returnLent">
                    <img src="../img/icon/icon7.png" alt="">
                </a>
                <h6>반납추가</h6>
            </div>
            <div class="quick" id="menu5">
                <a href="/etc/plalist">
                    <img src="../img/icon/icon8.png" alt="">
                </a>
                <h6>대출장소관리</h6>
            </div>
        </div>
        <div class="quickmenu">
            <div class="quick" id="menu6">
                <a href="/del/aprelist">
                    <img src="../img/icon/icon2.png" alt="">
                </a>
                <div class="long"><h6>상호대차승인거절</h6></div>
            </div>
            <div class="quick" id="menu7">
                <a href="/del/addlist">
                    <img src="../img/icon/icon9.png" alt="">
                </a>
                <div class="long"><h6>상호대차도착일추가</h6></div>
            </div>
            <div class="quick" id="menu8">
                <a href="/mat/addupdate">
                    <img src="../img/icon/icon1.png" alt="">
                </a>
                <h6>자료추가</h6>
            </div>
            <div class="quick" id="menu9">
                <a href="/etc/duelist">
                    <img src="../img/icon/icon12.png" alt="">
                </a>
                <h6>연체관리</h6>
            </div>
            <div class="quick" id="menu10">
                <a href="/member/list">
                    <img src="../img/icon/icon5.png" alt="">
                </a>
                <h6>회원관리</h6>
            </div>
        </div>
        <div class="blank"></div>
<?php } ?>
        <!-- 메인 내용 -->
        <div class="main_context">
            <!-- 슬라이드 배너 -->
            <div class="slide slide_wrap">
            <?php if(isset($result)){foreach($result as $row): ?>
                <div><a href="/not/addupdate?not_no=<?=$row['not_no']?>">
                    <img src="<?php if(isset($row)){echo '.'.$row['not_ban_url'];}?>" alt="" style="width:100%;">
                </a></div>
            <?php endforeach; }?>
                <div class="slide_tool">
                    <div class="slide_prev_button slide_button"></div>
                    <div class="slide_next_button slide_button"></div>
                </div>
                <ul class="slide_pagination"></ul>
            </div>
            <!-- 게시판 내용 -->
            <div class="board">
                <h3>공지사항</h3>
                <fieldset id="fieldset_row">
                <?php if(isset($result1)){foreach($result1 as $row): ?>
                    <div id="div_row">
                        <a class="http" href="/not/addupdate?not_no=<?=$row['not_no']?>">
                            <script>
                                document.write(cnt+"번째 ");
                                cnt++;
                            </script>
                            <?=htmlspecialchars($row['not_name'],ENT_QUOTES,'UTF-8');?>
                            <?=htmlspecialchars($row['not_op_date'],ENT_QUOTES,'UTF-8');?>
                        </a>
                    </div>
                <?php endforeach; }?>
                </fieldset>
            </div>
        </div>
<?php if($mem_state != 1){ ?>
        <div class="quickmenu">
            <div id="context">
                <h2>자주찾는 메뉴</h2>
                <h5>필요한 정보를<br>
                    빠르게 찾아보세요.</h5>
            </div>
            <div class="quick" id="menu1">
                <a href="/not/list">
                    <img src="../img/icon/icon3.png" alt="">
                </a>
                <h6>공지사항</h6>
            </div>
            <div class="quick" id="menu2">
                <a href="/lib/list">
                    <img src="../img/icon/icon10.png" alt="">
                </a>
                <h6>도서관</h6>
            </div>
            <div class="quick" id="menu3">
                <a href="/len/memLent">
                    <img src="../img/icon/icon6.png" alt="">
                </a>
                <h6>대출중도서</h6>
            </div>
            <div class="quick" id="menu4">
                <a href="/res/list">
                    <img src="../img/icon/icon4.png" alt="">
                </a>
                <h6>예약내역</h6>
            </div>
            <div class="quick" id="menu5">
                <a href="/del/list">
                    <img src="../img/icon/icon9.png" alt="">
                </a>
                <h6>상호대차내역</h6>
            </div>
        </div>
<?php } ?>
        <div class="calender">
            <div class="header">
              <div class="select">
                <select id = "s2" name = "lib_select" onchange = "if(this.value) location.href=(this.value);">
                <?php
                    for($z = 1; $z < sizeof($lib); $z++){
                        $no[$z] = $lib[$z][0]; 
                        $name[$z] = $lib[$z][1];
                    }

                    $lib_no = 1;
                    if(isset($_GET['lib_no'])){
                        $lib_no = $_GET['lib_no'];
                    }

                    for($z = 1;$z < sizeof($lib); $z++){
                        if($lib_no == $z){
                            echo "<option  value='/member/home?lib_no=$no[$z]' selected> $name[$z] </option>";
                        }else{
                            echo "<option  value='/member/home?lib_no=$no[$z]' > $name[$z] </option>";
                        }
                    }
                ?>               
                </select>
              </div>
              <button class="prevBtn" onclick="prevCal()"></button>
              <div class="title">
                <div class="yearTitle"></div>
                <div>년</div>
                <div class="monthTitle"></div>
                <div>월</div>
              </div>
              <button class="nextBtn" onclick="nextCal()"></button>
            </div>
            <div class="main">
              <div class="days">
                <div class="day">Sun</div>
                <div class="day">Mon</div>
                <div class="day">Tue</div>
                <div class="day">Wed</div>
                <div class="day">Thu</div>
                <div class="day">Fri</div>
                <div class="day">Sat</div>
              </div>
              <div class="dates"></div>
              <div class="image"></div>
            </div>
        </div>
        <script src="../js/slider.js"></script>
    </body>
</html>