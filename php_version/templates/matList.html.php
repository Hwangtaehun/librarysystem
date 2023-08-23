<head>
    <script>
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function checkRes(myform){
            if(myform.id_state.value != '예약가능'){
                alert("예약이 불가능합니다.");
                return false;
            }
            return true;
        }

        <?php
        $date = date("Y-m-d");

        if($title == '자료 현황'){
            $ispop = false;
            $action = "/mat/research";
        }
        else{
            $ispop = true;
            $action = "/mat/research?title=$title&pop=true";
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
?>
<body>
    <form action="/mat/research" method="post" onsubmit="return checkResearch(this)">
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
                else if($title == '상세검색' ||  $title == '자료찾기'){
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
                <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?>
                <? if(isset($row['kind_no'])){ ?>
                    <?=htmlspecialchars($row['kind_no'],ENT_QUOTES,'UTF-8');?>
                <?}?>
                <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['book_author'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['book_publish'],ENT_QUOTES,'UTF-8');?>
                <?php if(isset($mat_many)){ ?>
                    <?=htmlspecialchars($mat_many,ENT_QUOTES,'UTF-8');?>
                    <?=htmlspecialchars($mat_overlap,ENT_QUOTES,'UTF-8');?>
                <?php } 
                if(isset($lent_re_state)){ ?>
                    <?=htmlspecialchars($lent_re_state,ENT_QUOTES,'UTF-8');?>
                    <?=htmlspecialchars($res_state,ENT_QUOTES,'UTF-8');?>
                <?php }?> 
            </div>
            <?php
                if($ispop){
                    echo '<form>';
                    $name = "'".$row['book_name']."'";
                    $no = "'".$row['mat_no']."'";
                    echo '<input type=button value="선택" onclick="opener.parent.matValue('.$name.', '.$no.'); window.close();">';
                }
                else{
                    if($state == 1){
            ?>
            <form action="/mat/delete" method="post">
                    <input type="hidden" name="mat_no" value="<?=$row['mat_no']?>">
                    <input type="submit" value="삭제">
                    <a href="/mat/addupdate?mat_no=<?=$row['mat_no']?>"><input type="button" value="수정"></a>
            <?php }else{ ?>
            <form action="/res/addupdate" method="post" onsubmit="return checkRes(this)">
                    <input type="hidden" name="mat_no" value="<?=$row['mat_no']?>">
                    <input type="hidden" name="mem_no" value="<?=$_SESSION['mem_no']?>">
                    <input type="hidden" name="res_date" value="<?=$date?>">
                    <input type="hidden" id="id_state" value="<?=$res_state?>">
                    <input type="submit" value="예약">
                    <a href="/mat/delpop?mat_no=<?=$row['mat_no']?>"><input type="button" value="상호대차"></a>
            <?php } ?>
            <?php } ?>
            </form>
            </fieldset>
        </fieldset>
    <?php endforeach; }?>
</body>