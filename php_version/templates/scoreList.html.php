<?php foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <div id="div_row">
            <?=htmlspecialchars($row['sc_no'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['stu_name'],ENT_QUOTES,'UTF-8');?>
            <?=$row['sc_cpp']?>
            <?=$row['sc_java']?>
            <?=$row['sc_av']?>
            <?=$row['sc_grade']?>
        </div>
        <form action="/score/delete" method="post">
                <input type="hidden" name="sc_id" value="<?=$row['sc_id']?>">
                <input type="submit" value="삭제">
                <a href="/score/addupdate?id=<?=$row['sc_id']?>"><input type="button" value="수정"></a>
        </form>
        </fieldset>
    </fieldset>
<?php endforeach; ?>
