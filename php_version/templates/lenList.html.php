<head>
    <script>
        var bookname = "";
        var memid = "";
        
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function changeSelect(){
            var value = document.getElementById("s1").value;
            const mem = document.getElementById("ie_research");
            const mat = document.getElementById("ia_research");
            if(value == '1'){
                document.getElementById("id_research").value = "";
                document.getElementById("id_mat").value = "";
                mem.disabled=false;
                mat.disabled=true;   
            }
            else if(value == '2'){
                document.getElementById("id_research").value = "";
                document.getElementById("id_mem").value = "";
                mem.disabled=true;
                mat.disabled=false;
            }
            else{
                mem.disabled=false;
                mat.disabled=false;
            }
        }

        function checkmem() {
            url = "/len/mempop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function checkmat() {
            url = "/len/matpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function changeDate(){
            document.getElementById("il_date").value = date("Y-m-d");
        }

        function matValue(no, name){
            document.getElementById("id_mat").value = no;
            bookname = name;
            document.getElementById("id_research").value = memid+' '+bookname;
        }

        function memValue(no, name, state){
            document.getElementById("id_mem").value = no;
            memid = name;
            document.getElementById("id_research").value = memid+' '+bookname;
        }

        <?php
        if($title == '대출 현황'){
            $ispop = false;
            $action = "/len/research";
        }
        else if($title == '대출찾기'){
            $ispop = true;
            $action = "/len/research?title=$title&pop=true";
        }
        else{
            $ispop = false;
            $action = "/len/research?title=$title";
        }
        ?>
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Assistance.php';
    $assist = new Assistance();
    $mem_state = $_SESSION['mem_state'];
?>
<body>
    <?php if($mem_state != 1){ ?>
    <form action="/len/research" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" placeholder="책제목을 입력해주세요.">
        <input type="hidden" id="id_title" name="title" value= "<?=$title?>">
        <input type="submit" value = "검색">
    <?php }else{ ?>
    <form action="/len/research" method="post" onsubmit="return checkResearch(this)">
        <select id = "s1" name = "opt_type" onchange="changeSelect()">
            <option value=0>전체</option>
            <option value=1>회원id</option>
            <option value=2>자료이름</option>
        </select>
        <input type="button" id="ie_research" value="회원찾기" onclick="checkmem();"></a>
        <input type="button" id="ia_research" value="자료찾기" onclick="checkmat();"></a>
        <input type="text" name="user_research" id="id_research" value = "" readonly>
        <input type="hidden" id="id_mem" name="mem_no" value="">
        <input type="hidden" id="id_mat" name="mat_no" value="">
        <input type="hidden" id="id_title" name="title" value= "<?=$title?>">
        <input type="submit" value = "검색">
    <?php } ?>
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
        <fieldset id="fieldset_row">
            <div id="div_row">
                <?php
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
    
                    $extend = '연장 X';
                    if($row['len_ex'] == 7){
                        $extend = '연장 O';
                    }

                if($title == '대출 현황' || $title == '대출찾기'){ ?>
                    <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?>
                    <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                <?php }?>
                <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['len_date'],ENT_QUOTES,'UTF-8');?>
                <?php if(isset($reDate)){ ?>
                    <?=htmlspecialchars($reDate,ENT_QUOTES,'UTF-8');?>
                <?php } ?>
                <?php if(!empty($row['len_re_date'])){ ?>
                    <?=htmlspecialchars($row['len_re_date'],ENT_QUOTES,'UTF-8');?>
                <?php } 
                if($title == '모든대출내역'){ ?>
                    <?=htmlspecialchars($len_re_st,ENT_QUOTES,'UTF-8');?>
                <?php }
                else if($title == '대출 현황' || $title == '대출찾기'){ ?>
                    <?=htmlspecialchars($len_re_st,ENT_QUOTES,'UTF-8');?>
                    <?=htmlspecialchars($extend,ENT_QUOTES,'UTF-8');?>
                <?php if(!empty($row['len_memo'])){ ?>
                    <?=htmlspecialchars($row['len_memo'],ENT_QUOTES,'UTF-8');?>
                <?php } ?>
                <?php } ?> 
            </div>
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
                                </select>
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
        </fieldset>
    <?php endforeach; }?>
</body>