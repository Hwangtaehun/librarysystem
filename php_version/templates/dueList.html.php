<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function checkdue() {
            url = "/etc/mempop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function memValue(no, name, state){
            document.querySelector("#id_mem").value = no;
            document.querySelector("#id_research").value = name;
        }
    </script>
</head>
<?php
include_once __DIR__.'/../includes/Assistance.php';
$assist = new Assistance();
$lib_array = $assist->libraryarray($pdo);
?>
<body>
    <form action="/etc/dueresearch" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" readonly>
        <input type="button" id="ie_research" value="회원찾기" onclick="checkdue();"></a>
        <input type="hidden" id="id_mem" name="mem_no" value="">
        <input type="submit" value = "검색">
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
        <fieldset id="fieldset_row">
            <div id="div_row">
                <?php
                $kind = $row['kind_no'];
                $symbol = $row['mat_symbol'];
                $many = $row['mat_many'];
                $overlap = $row['mat_overlap'];
                $book = $kind.' '.$symbol.' '.$many.' '.$overlap;

                if($row['len_re_date'] == ''){
                    $len_re_date = '없음';
                }
                else{
                    $len_re_date = $row['len_re_date'];
                }
                if($row['due_exp'] == ''){
                    $due_exp = '';
                }
                else{
                    $due_exp = $row['due_exp'];
                }
                ?>

                <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($lib_array[$row['lib_no']],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($book,ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['len_date'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($len_re_date,ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($due_exp,ENT_QUOTES,'UTF-8');?>
            </div>
            <?php if($row['due_exp'] != ''){ ?>
            <form action="/etc/delete" method="post">
                <input type="hidden" name="due_no" value="<?=$row['due_no']?>">
                <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                <input type="submit" value="삭제">
                <a href="/etc/addupdate?due_no=<?=$row['due_no']?>"><input type="button" value="수정"></a>
            </form>
            <?php } ?>
            </fieldset>
        </fieldset>
    <?php endforeach; } ?>
</body>