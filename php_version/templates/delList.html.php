<head>
    <script>
        var bookname = "";
        var memid = "";
        
        function checkResearch(myform) {
            if(myform.user_research.value.delgth <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function changeDate(){
            document.getElementById("il_date").value = date("Y-m-d");
        }

        <?php
        if($title == '상호대차'){
            $ispop = true;
            $action = "/del/research?title=$title&pop=true";
        }
        else{
            $ispop = false;
            $action = "/del/research";
        }
        ?>
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    include_once __DIR__.'/../includes/Assistance.php';
    $assist = new Assistance();
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", true);
    $lib = $lib_man->result_call();
    $mem_state = $_SESSION['mem_state'];
    $lib_array = $DelController->libraryarray();
?>
<body>
<form action="/del/research" method="post" onsubmit="return checkResearch(this)">
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
        <input type="text" name="user_research" id="id_research" value = "" placeholder="책제목을 입력해주세요.">
        <input type="submit" value = "검색">
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
        <fieldset id="fieldset_row">
            <div id="div_row">
                <?php
                    if(isset($row['del_app'])){
                        $del_app = '반송';
                        if($row['del_app'] == 0){
                            $del_app = '거부';
                        }
                        else if($row['del_app'] == 1){
                            $del_app = '승인';
                        }
                    }
                    
                if($mem_state == 1){ ?>
                    <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?>
                    <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                <?php }?>
                <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['mat_many'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['mat_overlap'],ENT_QUOTES,'UTF-8');?>
                <?php if($mem_state == 1){ ?>
                <?=htmlspecialchars($lib_array[$row['lib_no']],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($lib_array[$row['lib_no_arr']],ENT_QUOTES,'UTF-8');?>
                <?php } ?>
                <?php if(isset($reDate)){ ?>
                    <?=htmlspecialchars($reDate,ENT_QUOTES,'UTF-8');?>
                <?php } ?>
                <?php if(!empty($row['del_re_date'])){ ?>
                    <?=htmlspecialchars($row['del_re_date'],ENT_QUOTES,'UTF-8');?>
                <?php } 
                if($title == '모든대출내역'){ ?>
                    <?=htmlspecialchars($del_re_st,ENT_QUOTES,'UTF-8');?>
                <?php }
                else if($title == '대출 현황'){ ?>
                    <?=htmlspecialchars($del_re_st,ENT_QUOTES,'UTF-8');?>
                    <?=htmlspecialchars($extend,ENT_QUOTES,'UTF-8');?>
                <?php if(!empty($row['del_memo'])){ ?>
                    <?=htmlspecialchars($row['del_memo'],ENT_QUOTES,'UTF-8');?>
                <?php } ?>
                <?php } ?> 
            </div>
            <?php if($ispop){
                    echo '<form>';
                    $mem = "'".$row['mem_no']."'";
                    $id = "'".$row['mem_id']."'";
                    $mat = "'".$row['mat_no']."'";
                    $book = "'".$row['book_name']."'";
                    $del = "'".$row['del_no']."'";
                    echo '<input type=button value="선택" onclick="opener.parent.delValue('.$mem.','.$id.','.$mat.','.$book.','.$del.'); window.close();">';
                } 
                else{
                    if ($mem_state == 1) {
                        if($title != '반납추가'){ ?>
                            <form action="/del/delete" method="post">
                                <input type="hidden" name="del_no" value="<?=$row['del_no']?>">
                                <input type="submit" value="삭제">
                                <a href="/del/addupdate?del_no=<?=$row['del_no']?>"><input type="button" value="수정"></a>
                  <?php }
                        else{ ?>
                            <form action="/del/returndelt()" method="post">
                                <label for ="delt_re_date">반납일</label>
                                <input type="date" name="delt_re_date" id="il_date" value="">
                                <input type="button" name="today" value="오늘" onclick="changeDate()"><br>
                                <input type="hidden" name="del_no" value="<?=$row['del_no']?>">
                                <input type="hidden" name="del_re_st" value="1">
                                <input type="submit" value="반납">
                  <?php }
                    } 
                }
            ?>
            </form>
        </fieldset>
    <?php endforeach; }?>
</body>