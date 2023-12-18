<head>
    <?php
    //오늘날짜 변수
    $date = date("Y-m-d");
    //회원 상태
    $mem_state = 3;
    if(isset($_SESSION['mem_state'])){
        $mem_state = $_SESSION['mem_state'];
    }

    //css 조정
    if($title == '자료 현황'){
        if($mem_state == 1){
            echo '<link rel="stylesheet" href="../css/form-base.css">';
            
        }
        else{
            echo '<link rel="stylesheet" href="../css/form-noaside.css">';
        }
        $ispop = false;
        $action = "/mat/research";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/mat/research?title=$title&pop=true";
    }
    ?>
    <script>
        //검색 내용 확인 함수
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        //예약가능 확인 함수
        function checkRes(myform){
            if(myform.id_state.value != '예약가능'){
                alert("예약이 불가능합니다.");
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
?>
<body>
    <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
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
            <input class="lib" type="text" name="user_research" id="id_research" value = "" placeholder="검색어를 입력해주세요.">
            <button type="submit" class="btn btn-outline-secondary" id="inbt">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
    </form>
    <div class="container text-center">
    <?php if($ispop){ ?>
        <div class="row">
    <?php }else{ ?>
        <div class="row row-cols-3">
    <?php }?>
    <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 300px;">
                    <div class="card-body">
                            <?php
                            if($title = '자료 현황'){
                                if($mem_state != 1){
                                    $state = $row['len_re_st'];
                                    $res = $row['res_no'];
                
                                    if(empty($state) || $state == "1" ) {
                                        $lent_re_state = "대출가능";
                                    }
                                    else if($state = "2" ) {
                                        $lent_re_state = "대출불가";
                                    }
                                    else {
                                        $lent_re_state = "대출중";
                                    }
                                    
                                    $res_state = "예약불가";
                                    if(!empty($state)) {
                                        if($state = "0") {
                                            if(empty($res)) {
                                                $res_state = "예약가능";
                                            }
                                            else {
                                                $res_state = "예약있음";
                                            }
                                        }
                                    }
                                }
                                else{
                                    $mat_many = $row['mat_many'];
                                    $mat_overlap = $row['mat_overlap'];
                                }
                            }
                            else if($title == '상세 검색' ||  $title == '자료 찾기'){
                                $o_many = $row['mat_many'];
                                $o_overlap = $row['mat_overlap'];
                                if((string)$o_many == '0'){
                                    $mat_many = '없음';
                                }
                                else{
                                    $mat_many = $o_many;
                                }
                                $mat_overlap = $assist->removeSymbol($o_overlap);
                            }
                            ?>
                            <p class="card-text">
                            도서관 이름: <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?><br>
                            <? if(isset($row['kind_no'])){ ?>
                                종류번호: <?=htmlspecialchars($row['kind_no'],ENT_QUOTES,'UTF-8');?><br>
                            <?}?>
                            책이름: <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?><br>
                            작가: <?=htmlspecialchars($row['book_author'],ENT_QUOTES,'UTF-8');?><br>
                            출판사: <?=htmlspecialchars($row['book_publish'],ENT_QUOTES,'UTF-8');?><br>
                            <?php if(isset($mat_many)){ ?>
                                권차: <?=htmlspecialchars($mat_many,ENT_QUOTES,'UTF-8');?><br>
                                복권: <?=htmlspecialchars($mat_overlap,ENT_QUOTES,'UTF-8');?><br>
                            <?php } 
                            if(isset($lent_re_state)){ ?>
                                <?=htmlspecialchars($lent_re_state,ENT_QUOTES,'UTF-8');?><br>
                                <?=htmlspecialchars($res_state,ENT_QUOTES,'UTF-8');?><br>
                            <?php }?> 
                            </p>
                        <?php
                            //팝업창 실행
                            if($ispop){
                                echo '<form>';
                                $name = "'".$row['book_name']."'";
                                $no = "'".$row['mat_no']."'";
                                echo '<input type=button value="선택" onclick="opener.parent.matValue('.$no.','.$name.'); window.close();">';
                            }
                            else{
                                if($mem_state == 1){
                        ?>
                                <form action="/mat/delete" method="post">
                                        <input type="hidden" name="mat_no" value="<?=$row['mat_no']?>">
                                        <input type="submit" value="삭제">
                                        <a href="/mat/addupdate?mat_no=<?=$row['mat_no']?>"><input type="button" value="수정"></a>
                                <?php }else if($mem_state == 3){}else{ ?>
                                <form action="/res/addupdate" method="post" onsubmit="return checkRes(this)">
                                        <input type="hidden" name="mat_no" value="<?=$row['12']?>">
                                        <input type="hidden" name="mem_no" value="<?=$_SESSION['mem_no']?>">
                                        <input type="hidden" name="res_date" value="<?=$date?>">
                                        <input type="hidden" id="id_state" value="<?=$res_state?>">
                                        <input type="submit" value="예약">
                                        <a href="/mat/delpop?mat_no=<?=$row['12']?>"><input type="button" value="상호대차"></a>
                                <?php } ?>
                        <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
    <?php endforeach; }?>
        </div>
    </div>
</body>