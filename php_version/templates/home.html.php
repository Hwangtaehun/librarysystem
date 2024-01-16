<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/form-home.css">
        <script>
            var cnt = 1;
        </script>
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
        <form action="/mat/research" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <select id = "s1" name = "lib_research">
                    <?php
                    for($z = 0; $z < sizeof($lib); $z++){
                        $no[$z] = $lib[$z][0]; $name[$z] = $lib[$z][1];
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
        <div class="quickmenu">
            <div id="context">
                <h2>자주찾는 메뉴</h2>
                <h5>필요한 정보를<br>
                    빠르게 찾아보세요.</h5>
            </div>
            <div class="quick" id="menu1">
                <a href="<?php echo "/not/list"; ?>">
                    <img src="../img/icon/not.png" alt="">
                </a>
                <h6><?php if($mem_state == 1){echo "공지사항관리";}else{echo "공지사항";} ?></h6>
            </div>
            <div class="quick" id="menu2">
                <a href="<?php if($mem_state == 1){echo "/member/list";}else if($mem_state == 3){echo "/member/logalert";}else{echo "/member/addupdate?mem_no='.$mem_no";} ?>">
                    <img src="../img/icon/mem.png" alt="">
                </a>
                <h6><?php if($mem_state == 1){echo "회원";}else{echo "회원정보수정";} ?></h6>
            </div>
            <div class="quick" id="menu3">
                <a href="<?php if($mem_state == 1){echo "/len/list";}else{echo "/len/memLent";} ?>">
                    <img src="../img/icon/lent.png" alt="">
                </a>
                <h6><?php if($mem_state == 1){echo "대출관리";}else{echo "대출중도서";} ?></h6>
            </div>
            <div class="quick" id="menu4">
                <a href="<?php echo "/res/list"; ?>">
                    <img src="../img/icon/res.png" alt="">
                </a>
                <h6><?php if($mem_state == 1){echo "예약관리";}else{echo "예약내역";} ?></h6>
            </div>
            <div class="quick" id="menu5">
                <a href="<?php echo "/del/list" ?>">
                    <img src="../img/icon/del.png" alt="">
                </a>
                <h6><?php if($mem_state == 1){echo "상호대차관리";}else{echo "상호대차내역";} ?></h6>
            </div>
        </div>
        <script>
            // 슬라이드 배너 사용하는 스크립트
            const slide = document.querySelector(".slide");
            let slideWidth = slide.clientWidth;

            const prevBtn = document.querySelector(".slide_prev_button");
            const nextBtn = document.querySelector(".slide_next_button");

            let slideItems = document.querySelectorAll(".slide_item");
            const maxSlide = slideItems.length;

            let currSlide = 1;

            const pagination = document.querySelector(".slide_pagination");

            for (let i = 0; i < maxSlide; i++) {
                if (i === 0) pagination.innerHTML += `<li class="active">•</li>`;
                else pagination.innerHTML += `<li>•</li>`;
            }

            const paginationItems = document.querySelectorAll(".slide_pagination > li");

            const startSlide = slideItems[0];
            const endSlide = slideItems[slideItems.length - 1];
            const startElem = document.createElement("div");
            const endElem = document.createElement("div");

            endSlide.classList.forEach((c) => endElem.classList.add(c));
            endElem.innerHTML = endSlide.innerHTML;

            startSlide.classList.forEach((c) => startElem.classList.add(c));
            startElem.innerHTML = startSlide.innerHTML;

            slideItems[0].before(endElem);
            slideItems[slideItems.length - 1].after(startElem);

            slideItems = document.querySelectorAll(".slide_item");
            
            let offset = slideWidth + currSlide;
            slideItems.forEach((i) => {
                i.setAttribute("style", `left: ${-offset}px`);
            });

            function nextMove() {
                currSlide++;
                if (currSlide <= maxSlide) {
                    const offset = slideWidth * currSlide;
                    slideItems.forEach((i) => {
                        i.setAttribute("style", `left: ${-offset}px`);
                    });
                    paginationItems.forEach((i) => i.classList.remove("active"));
                    paginationItems[currSlide - 1].classList.add("active");
                } else {
                    currSlide = 0;
                    let offset = slideWidth * currSlide;
                    slideItems.forEach((i) => {
                        i.setAttribute("style", `transition: ${0}s; left: ${-offset}px`);
                    });
                    currSlide++;
                    offset = slideWidth * currSlide;
                    setTimeout(() => {
                        slideItems.forEach((i) => {
                            i.setAttribute("style", `transition: ${0.15}s; left: ${-offset}px`);
                        });
                    }, 0);
                    paginationItems.forEach((i) => i.classList.remove("active"));
                    paginationItems[currSlide - 1].classList.add("active");
                }
            }

            function prevMove() {
                currSlide--;
                if (currSlide > 0) {
                    const offset = slideWidth * currSlide;
                    slideItems.forEach((i) => {
                        i.setAttribute("style", `left: ${-offset}px`);
                    });
                    paginationItems.forEach((i) => i.classList.remove("active"));
                    paginationItems[currSlide - 1].classList.add("active");
                } else {
                    currSlide = maxSlide + 1;
                    let offset = slideWidth * currSlide;
                    slideItems.forEach((i) => {
                        i.setAttribute("style", `transition: ${0}s; left: ${-offset}px`);
                    });
                    currSlide--;
                    offset = slideWidth * currSlide;
                    setTimeout(() => {
                        slideItems.forEach((i) => {
                            i.setAttribute("style", `transition: ${0.15}s; left: ${-offset}px`);
                        });
                    }, 0);
                    paginationItems.forEach((i) => i.classList.remove("active"));
                    paginationItems[currSlide - 1].classList.add("active");
                }
            }

            nextBtn.addEventListener("click", () => {
                nextMove();
            });

            prevBtn.addEventListener("click", () => {
                prevMove();
            });

            window.addEventListener("resize", () => {
                slideWidth = slide.clientWidth;
            });

            for (let i = 0; i < maxSlide; i++) {
                paginationItems[i].addEventListener("click", () => {
                    currSlide = i + 1;
                    const offset = slideWidth * currSlide;
                    slideItems.forEach((i) => {
                    i.setAttribute("style", `left: ${-offset}px`);
                    });
                    paginationItems.forEach((i) => i.classList.remove("active"));
                    paginationItems[currSlide - 1].classList.add("active");
                });
            }

            let startPoint = 0;
            let endPoint = 0;
            
            slide.addEventListener("mousedown", (e) => {
                startPoint = e.pageX;
            });
            slide.addEventListener("mouseup", (e) => {
                endPoint = e.pageX;
                if (startPoint < endPoint) {
                    prevMove();
                } else if (startPoint > endPoint) {
                    nextMove();
                }
            });

            slide.addEventListener("touchstart", (e) => {
                startPoint = e.touches[0].pageX;
            });
            slide.addEventListener("touchend", (e) => {
                endPoint = e.changedTouches[0].pageX;
                if (startPoint < endPoint) {
                    prevMove();
                } else if (startPoint > endPoint) {
                    nextMove();
                }
            });

            let loopInterval = setInterval(() => {
                nextMove();
            }, 3000);

            slide.addEventListener("mouseover", () => {
                clearInterval(loopInterval);
            });

            slide.addEventListener("mouseout", () => {
                loopInterval = setInterval(() => {
                    nextMove();
                }, 3000);
            });
            //참고 사이트: https://devinus.tistory.com/48
        </script>
    </body>
</html>