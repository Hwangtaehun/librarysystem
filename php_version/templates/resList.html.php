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

        function checkmem() {
            url = "/len/mempop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function memValue(no, name, state){
            document.getElementById("id_mem").value = no;
            document.getElementById("id_research").value = name;
        }

        <?php
        if($title == '예약 현황'){
            $ispop = false;
            $action = "/res/research";
        }
        else{
            $ispop = true;
            $action = "/res/research?title=$title&pop=true";
        }

        $mem_state = $_SESSION['mem_state'];
        ?>
    </script>
</head>
<body>
    <?php if($mem_state == 1){ ?>
    <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" readonly>
        <input type="button" id="ie_research" value="회원찾기" onclick="checkmem();"></a>
        <input type="hidden" id="id_mem" name="mem_no" value="">
        <input type="submit" value = "검색">
    <?php }else{ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" placeholder="책이름을 입력하세요.">
        <input type="submit" value = "검색"> 
    <?php } ?>
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
        <fieldset id="fieldset_row">
            <div id="div_row">
                <?php $symbol = $row['kind_no'].' '.$row['mat_symbol'].' '.$row['mat_many'].' '.$row['mat_overlap']?>
                <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($symbol,ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['res_date'],ENT_QUOTES,'UTF-8');?>
            </div>
            <?php
                if($ispop){
                    echo '<form>';
                    $mem = "'".$row['mem_no']."'";
                    $id = "'".$row['mem_id']."'";
                    $state = "'".$row['mem_state']."'";
                    $mat = "'".$row['mat_no']."'";
                    $book = "'".$row['book_name']."'";
                    $lib = "'".$row['lib_no']."'";
                    echo '<input type=button value="선택" onclick="opener.parent.resValue('.$mem.', '.$id.','.$state.','.$mat.','.$book.','.$lib.'); window.close();">';
                }
                else{
            ?>
            <form action="/res/delete" method="post">
                    <input type="hidden" name="res_no" value="<?=$row['res_no']?>">
                    <input type="submit" value="삭제">
            <?php } ?>
            </form>
            </fieldset>
        </fieldset>
    <?php endforeach; }?>
</body>