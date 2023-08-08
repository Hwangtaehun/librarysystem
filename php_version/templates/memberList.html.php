<header></header>
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