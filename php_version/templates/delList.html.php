<head>
    <?php
    // 웹페이지 맞는 css설정
    if($title == '상호대차찾기'){
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/del/research?title=$title&pop=true";
    }
    else if($title == '상호대차 도착일 추가'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/del/addresearch";
    }
    else if($title == '상호대차 승인 거절'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/del/apreresearch";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/del/research";
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

        //검색 선택 함수
        function changeSelect(){
            var value = document.querySelector("#s1").value;
            const mem = document.querySelector("#ie_research");
            const mat = document.querySelector("#ia_research");
            //1은 회원, 2는 자료, 이외에는 회원와 자료 검색
            if(value == '1'){
                document.querySelector("#id_research").value = "";
                document.querySelector("#id_mat").value = "";
                mem.disabled=false;
                mat.disabled=true;   
            }
            else if(value == '2'){
                document.querySelector("#id_research").value = "";
                document.querySelector("#id_mem").value = "";
                mem.disabled=true;
                mat.disabled=false;
            }
            else{
                mem.disabled=false;
                mat.disabled=false;
            }
        }

        //회원 팝업창 띄우는 함수
        function checkmem() {
            url = "/member/list?title=회원찾기&pop=true";
            window.open(url,"chkbk","width=310,height=445");
        }

        //자료 팝업창 띄우는 함수 
        function checkmat() {
            url = "/mat/poplist?title=자료찾기&pop=true";
            window.open(url,"chkbk","width=500,height=445");
        }

        //회원 팝업창에 받아온 내용 가져오기
        function memValue(no, name, state){
            document.querySelector("#id_mem").value = no;
            memid = name;
            document.querySelector("#id_research").value = memid+' '+bookname;
        }

        //자료 팝업창에 받아온 내용 가져오기
        function matValue(no, name){
            document.querySelector("#id_mat").value = no;
            bookname = name;
            document.querySelector("#id_research").value = memid+' '+bookname;
        }

        function radioInput(myform) {
            var bool = true;
            
            if(myform.id_de.value.length <= 0){
                bool = false;
            }

            if(!bool){
                if(myform.id_ap.value.length <= 0){
                    bool = false;
                }else{
                    bool = true;
                }
            }

            if(!bool){
                alert("승인 또는 거절을 선택해주세요.");
                myform.id_ap.focus();
            }

            return bool;
        }

        function checkInput(myform) {
            if(myform.il_date.value.length <= 0){
                alert("날짜를 입력해주세요.");
                myform.il_date.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Assistance.php';
    $assist = new Assistance();
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", true);
    $lib = $lib_man->result_call();
    $mem_state = $_SESSION['mem_state'];
    $lib_array = $assist->libraryarray($pdo);
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
        <?php }else if($title == '상호대차 도착일 추가'){ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <label for="s1" id="black">수신도서관</label>
                <select class = "re" id = "s1" name = "lib_research">
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
                </select><br>
                <input type="button" id="ia_research" class="srbt" value="자료찾기" onclick="checkmat();">
                <input type="text" name="user_research" id="id_research" value = "" readonly>
                <input type="hidden" id="id_mem" name="mem_no" value="">
                <input type="hidden" id="id_mat" name="mat_no" value="">
                <input type="hidden" id="id_lib" name="lib_no_arr" value="">
                <input type="hidden" id="id_title" name="title" value= "<?=$title?>">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        <?php }else if($title == '상호대차 승인 거절'){ ?>
        <form action="<?php echo $action; ?>" method="post">
            <div class="search">
                <label for="s1" id="black">소장도서관</label>
                <select class = "re" id = "s1" name = "lib_research">
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
                <input type="hidden" id="id_lib" name="lib_no" value="">
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
                <input type="hidden" id="id_mem" name="mem_no" value="">
                <input type="hidden" id="id_mat" name="mat_no" value="">
                <input type="hidden" id="id_title" name="title" value= "<?=$title?>">
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
                <div class="card" style="width: 16rem; height: 250px;">
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

                    $del_app = '대기';

                    if(isset($row['del_app'])){
                        if($row['del_app'] == 0){
                            $del_app = '거부';
                        }
                        else if($row['del_app'] == 1){
                            $del_app = '승인';
                        }
                        else if($row['del_app'] == 2){
                            $del_app = '반송';
                        }
                    }
                    
                    if($title != '상호대차 도착일 추가'){ ?>
                        회원 아이디 <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?><br>
                        <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                    <?php }?>
                    도서 <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?><br>
                    <?php if(!$ispop){ ?>
                    청구 번호 <?=htmlspecialchars($book,ENT_QUOTES,'UTF-8');?><br>
                    <?php } ?> 
                    소장 도서관 <?=htmlspecialchars($lib_array[$row['lib_no']],ENT_QUOTES,'UTF-8');?><br>
                    수신 도서관 <?=htmlspecialchars($lib_array[$row['lib_no_arr']],ENT_QUOTES,'UTF-8');?> <br>
                    <?php if(!$ispop && $title != '상호대차 승인 거절'){ ?>
                        승인 상태-<?=htmlspecialchars($del_app,ENT_QUOTES,'UTF-8');?><br>
                        <?php if($title != '상호대차 도착일 추가'){ if(isset($row['del_arr_date'])){ ?>
                            도착일 <?=htmlspecialchars($row['del_arr_date'],ENT_QUOTES,'UTF-8');?><br>
                        <?php } } ?>
                    <?php } ?>
                <?php if($ispop){
                        echo '<form>';
                        $mem = "'".$row['mem_no']."'";
                        $id = "'".$row['mem_id']."'";
                        $state = "'".$row['mem_state']."'";
                        $mat = "'".$row['mat_no']."'";
                        $book = "'".$row['book_name']."'";
                        $lib = "'".$row['lib_no_arr']."'";
                        $del = "'".$row['del_no']."'";
                        if($row['del_app'] == 1){
                            echo '<input type=button value="선택" onclick="opener.parent.delValue('.$mem.','.$id.','.$state.','.$mat.','.$book.','.$lib.','.$del.'); window.close();">';
                        }
                    } 
                    else{
                        if ($mem_state == 1) {
                            if($title == '상호대차 현황'){ ?>
                                <form action="/del/delete" method="post">
                                    <input type="hidden" name="del_no" value="<?=$row['del_no']?>">
                                    <input type="submit" value="삭제">
                                    <a href="/del/addupdate?del_no=<?=$row['del_no']?>"><input type="button" value="수정"></a>
                    <?php   }
                            else if($title == '상호대차 도착일 추가'){ ?>
                                <form action="/del/arrive" method="post" onSubmit="return checkInput(this)">
                                    <label for ="del_arr_date">도착일</label>
                                    <input type="date" name="del_arr_date" id="il_date" value="">
                                    <input type="hidden" name="del_no" value="<?=$row['del_no']?>">
                                    <input type="submit" value="도착일추가">
                    <?php   }
                            else if($title == '상호대차 승인 거절'){ ?>
                                <form action="/del/arrive" method="post" onSubmit="return radioInput(this)">
                                    <label for ="del_app">승인여부</label>
                                    <input type="radio" name="del_app" id="id_de" value="0"> 거절
                                    <input type="radio" name="del_app" id="id_ap" value="1"> 승인
                                    <input type="hidden" name="del_no" value="<?=$row['del_no']?>">
                                    <input type="submit" value="변경">
                    <?php   }
                            else{ ?>
                                <form action="/del/pagelent" method="post">
                                    <input type="hidden" name="len_no" value="<?=$row['len_no']?>">
                                    <input type="submit" value="이동">
                    <?php   }
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
    <script>
        const date = document.querySelector('#il_date');
        date.value = new Date().toISOString().substring(0, 10);
    </script>
</body>