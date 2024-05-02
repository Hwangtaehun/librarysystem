<head>
    <?php
    //css 확인 함수
    if($title == '대출 현황'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/len/research";
    }
    else if($title == '대출찾기'){
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/len/research?title=$title&pop=true";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/len/research?title=$title";
    }
    ?>
    <script>
        var bookname = "";
        var memid = "";
        
        //검색 확인 함수
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        //선택한 검색별 선택하면 변화하는 함수
        function changeSelect(){
            var value = document.querySelector("#s1").value;
            const mem = document.querySelector("#ie_research");
            const mat = document.querySelector("#ia_research");
            if(value == '1'){
                //회원만 검색
                document.querySelector("#id_research").value = "";
                document.querySelector("#id_mat").value = "";
                mem.disabled=false;
                mat.disabled=true;   
            }
            else if(value == '2'){
                //자료만 검색
                document.querySelector("#id_research").value = "";
                document.querySelector("#id_mem").value = "";
                mem.disabled=true;
                mat.disabled=false;
            }
            else{
                //회원+자료 검색
                mem.disabled=false;
                mat.disabled=false;
            }
        }

        //회원 검색 팝업창
        function checkmem() {
            url = "/member/list?title=회원찾기&pop=true";
            window.open(url,"chkbk","width=310,height=445");
        }

        //자료 검색 팝업창
        function checkmat() {
            url = "/mat/poplist?title=상세 검색&pop=true";
            window.open(url,"chkbk","width=500,height=445");
        }

        //현재날짜변경
        function changeDate(){
            document.querySelector("#il_date").value = date("Y-m-d");
        }

        //자료 팝업창에 검색한 내용 입력
        function matValue(no, name){
            document.querySelector("#id_mat").value = no;
            bookname = name;
            document.querySelector("#id_research").value = memid+' '+bookname;
        }

        //회원 팝업창에 검색한 내용 입력
        function memValue(no, name, state){
            document.querySelector("#id_mem").value = no;
            memid = name;
            document.querySelector("#id_research").value = memid+' '+bookname;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Assistance.php';
    $assist = new Assistance();
    $mem_state = $_SESSION['mem_state'];
?>
<body>
<?php if(!$ispop){ ?>
    <div class="dynamic_search">
<?php } ?>
        <?php if($mem_state != 1){ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <input type="text" name="user_research" id="id_research" value = "" placeholder="책제목을 입력해주세요.">
                <input type="hidden" id="id_title" name="title" value= "<?=$title?>">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        <?php }else{ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
            <div class="sel">
                <select id = "s1" name = "opt_type" onchange="changeSelect()">
                    <option value=0>전체</option>
                    <option value=1>회원id</option>
                    <option value=2>자료이름</option>
                </select>
                <input type="button" id="ie_research" value="회원찾기" onclick="checkmem();">
                <input type="button" id="ia_research" value="자료찾기" onclick="checkmat();">
            </div>
            <div class="search">
                <input type="text" name="user_research" id="id_research" value = "" readonly>
                <input type="hidden" id="id_mem"   name="mem_no" value="">
                <input type="hidden" id="id_mat"   name="mat_no" value="">
                <input type="hidden" id="id_title" name="title"  value="<?=$title?>">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        <?php } ?>
        </form>
<?php if(!$ispop){ ?>
    </div>
<?php } ?>
    <div class="container text-center">
        <div class="row row-cols-auto">
    <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 320px;">
                    <div class="card-body">
                    <?php
                    //청구번호 변환
                    $kind = $row['kind_no'];
                    $symbol = $row['mat_symbol'];
                    $many = $row['mat_many'];
                    $overlap = $row['mat_overlap'];

                    $book = $kind.'-'.$symbol;

                    if($many != 0){
                        $book = $book.'='.$many;
                    }

                    if($overlap != 'c.1'){
                        $book = $book.'='.$overlap;
                    }

                    if($title == '대출중자료'){
                        $date = $row['len_date'];
                        $reDate = $assist->estimateReturndate((string)$date, $row['len_ex']);
                    }

                    if(isset($row['len_re_st'])){
                        $len_re_st = '기타';
                        if($row['len_re_st'] == 0){
                            $len_re_st = '대출중';
                        }
                        else if($row['len_re_st'] == 1){
                            $len_re_st = '반납';
                        }
                    }
    
                    $extend = 'X';
                    if($row['len_ex'] == 7){
                        $extend = 'O';
                    }

                    echo'<p class="card-text">';
                if($title == '대출 현황' || $title == '대출찾기'){ ?>
                    회원 아이디 | <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?><br>
                    <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                <?php }?>
                도서 | <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?><br>
                청구번호 | <?=htmlspecialchars($book,ENT_QUOTES,'UTF-8');?><br>
                소장 기관 | <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?><br>
                대출일 | <?=htmlspecialchars($row['len_date'],ENT_QUOTES,'UTF-8');?><br>
                <?php if(isset($reDate)){ ?>
                    반납예정일 | <?=htmlspecialchars($reDate,ENT_QUOTES,'UTF-8');?><br>
                <?php } ?>
                <?php if(!empty($row['len_re_date'])){ ?>
                    반납일 | <?=htmlspecialchars($row['len_re_date'],ENT_QUOTES,'UTF-8');?><br>
                <?php } 
                if($title == '모든대출내역'){ ?>
                    반납 상태 | <?=htmlspecialchars($len_re_st,ENT_QUOTES,'UTF-8');?><br>
                <?php }
                else if($title == '대출 현황' || $title == '대출찾기'){ ?>
                    반납 상태 | <?=htmlspecialchars($len_re_st,ENT_QUOTES,'UTF-8');?><br>
                    연장 여부 | <?=htmlspecialchars($extend,ENT_QUOTES,'UTF-8');?><br>
                    <?php if(!empty($row['len_memo'])){ ?>
                        메모 | <?=htmlspecialchars($row['len_memo'],ENT_QUOTES,'UTF-8');?><br>
                    <?php } ?>
                <?php } ?>
                    </p>
            <?php if($ispop){
                    echo '<form>';
                    $mem = "'".$row['mem_id']."'";
                    $mat = "'".$row['book_name']."'";
                    $no = "'".$row['len_no']."'";
                    $date = "'".$row['len_date']."'";
                    echo '<input type=button value="선택" onclick="opener.parent.lenValue('.$no.','.$mem.','.$mat.','.$date.'); window.close();">';
                } 
                else{
                    if ($mem_state == 1) {
                        if($title != '반납 추가'){ ?>
                            <form action="/len/delete" method="post">
                                <input type="hidden" name="len_no" value="<?=$row['len_no']?>">
                                <input type="submit" value="삭제">
                                <a href="/len/addupdate?len_no=<?=$row['len_no']?>"><input type="button" value="수정"></a>
                  <?php }
                        else{
                            include_once __DIR__.'/../includes/Combobox_Manager.php';

                            $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
                            $lib = $lib_man->result_call(); 
                            ?>
                            <form action="/len/returnadd" method="post">
                                <label for ="lib_name">반납 도서관</label>
                                <select id ="il_no" name="lib_no">
                                    <?php
                                    for($z = 0; $z < sizeof($lib); $z++){
                                        $no[$z] = $lib[$z][0]; 
                                        $name[$z] = $lib[$z][1];
                                    }
                                    for($z = 0;$z < sizeof($lib); $z++){
                                        echo "<option  value = $no[$z] > $name[$z] </option>";
                                    }
                                    ?>
                                </select><br>
                                <label for ="len_re_date">반납일</label>
                                <input type="date" name="len_re_date" id="il_date" value="">
                                <input type="hidden" name="len_no" value="<?=$row['len_no']?>">
                                <input type="hidden" name="mat_no" value="<?=$row['mat_no']?>">
                                <input type="hidden" name="len_re_st" value="1">
                                <input type="submit" value="반납">
                      <?php }
                    } 
                }
            ?>
                            </form>
                    </div>
                </div>
            </div>
    <?php endforeach; }?>
        </div>
    </div>
    <script src="../js/search.js"></script>
</body>