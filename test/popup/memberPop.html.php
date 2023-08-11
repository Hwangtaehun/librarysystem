<head>
    <script>
        var url = document.referrer;
        document.wirte(url+"<br>");

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
<form action="check.php" method="post" onsubmit="return checkResearch(this)">
    <input type="text" name="user_research" id="id_research" value = "" placeholder="검색할 회원 이름을 입력해주세요.">
    <input type="submit" value = "검색">
</form>
<?php if(isset($result)){foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['mem_name'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_pw'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['mem_add'],ENT_QUOTES,'UTF-8');?>
        </div>
        <form>
            <?php
            $name = "'".$row['mem_id']."'";
            $no = "'".$row['mem_no']."'";
            echo '<input type=button value="선택" onclick="opener.parent.memValue('.$name.', '.$no.'); window.close();">';
            ?>
        </form>
        </fieldset>
    </fieldset>
<?php endforeach; }?>