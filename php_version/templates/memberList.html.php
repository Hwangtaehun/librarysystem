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
    </script>
</head>
<form action="/member/research" method="post" onsubmit="return checkResearch(this)">
    <input type="text" name="user_research" id="id_research" value = "" placeholder="검색할 회원 이름을 입력해주세요.">
    <input type="submit" value = "검색">
</form>
<?php foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['mem_name'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_pw'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_add'],ENT_QUOTES,'UTF-8');?>
        </div>
        <form action="memberDelete.php" method="post">
                <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                <input type="submit" value="삭제">
                <a href="member.php?mem_no=<?=$row['mem_no']?>"><input type="button" value="수정"></a>
        </form>
        </fieldset>
    </fieldset>
<?php endforeach; ?>