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

        <?php
        if($title == '도서관 현황'){
            $ispop = false;
            $action = "/lib/research";
        }
        else{
            $ispop = true;
            $action = "/lib/research?title=$title";
        }
        ?>
    </script>
</head>
<form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
    <input type="text" name="user_research" id="id_research" value = "" placeholder="도서관이름을 입력하세요.">
    <input type="submit" value = "검색">
</form>
<?php if(isset($result)){foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['lib_date'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['lib_add'],ENT_QUOTES,'UTF-8');?>
        </div>
        <?php
            if($ispop){
                echo '<form>';
                $name = "'".$row['lib_name']."'";
                $no = "'".$row['lib_no']."'";
                echo '<input type=button value="선택" onclick="opener.parent.libValue('.$name.', '.$no.'); window.close();">';
            }
            else{
        ?>
        <form action="/lib/delete" method="post">
                <input type="hidden" name="mem_no" value="<?=$row['lib_no']?>">
                <input type="submit" value="삭제">
                <a href="/lib/addupdate?lib_no=<?=$row['lib_no']?>"><input type="button" value="수정"></a>
        <?php } ?>
        </form>
        </fieldset>
    </fieldset>
<?php endforeach; }?>