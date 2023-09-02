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

        function checklen() {
            url = "/etc/lenpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function lenValue(no, mem, mat, date){
            document.getElementById("id_len").value = no;
            document.getElementById("id_research").value = mem + ' ' + mat + ' ' + date;
        }
    </script>
</head>
<?php
include_once __DIR__.'/../includes/Assistance.php';
$assist = new Assistance();
$lib_array = $assist->libraryarray($pdo);
?>
<body>
    <form action="/etc/plaresearch" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" readonly>
        <input type="button" id="ie_research" value="대출찾기" onclick="checklen();"></a>
        <input type="hidden" id="id_len" name="len_no" value="">
        <input type="submit" value = "검색">
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
        <fieldset id="fieldset_row">
            <div id="div_row">
                <?=htmlspecialchars($_COOKIE['mem_id'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($_COOKIE['book_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($_COOKIE['len_date'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($lib_array[$row['lib_no_len']],ENT_QUOTES,'UTF-8');?>
                <?php $lib_no_re = $row['lib_no_re']; if($lib_no_re == ''){$lib_name = "없음";}else{$lib_name = $lib_array[$row['lib_no_re']];}?>
                <?=htmlspecialchars($lib_name,ENT_QUOTES,'UTF-8');?>
            </div>
            <form>
                <a href="/etc/addupdate?pla_no=<?=$row['pla_no']?>"><input type="button" value="수정"></a>
            </form>
            </fieldset>
        </fieldset>
    <?php endforeach; }else{ ?>
        <hr>
        검색을 통해서 필요한 대출 장소 내역을 출력해주세요.
        <hr>
    <?php } ?>
</body>