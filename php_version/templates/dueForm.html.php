<!DOCTYPE html>
<html>
    <body>
        <form action="/etc/addupdate" method="post" onSubmit="return checkInput(this)">
            <fieldset id = form_fieldset>
            <h2><?=$title?></h2>
            <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
                <ul><label for  = "due_id">회원아이디</label>
                    <input class="input" type= "text" name="due_id" id="id_id" value="<?php if(isset($row)){echo $row['mem_id'];}?>" disabled><br>
                    <label for  = "due_name">책이름</label>
                    <input class="input" type= "text" name="due_name" id="id_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" disabled><br>
                    <label for = "due_date">대출날짜</label>
                    <input type= "date" name="due_date" id="id_date" value="<?php if(isset($row)){echo $row['len_date'];}?>" disabled><br>
                    <label for = "due_date">반납날짜</label>
                    <input type= "date" name="due_re_date" id="id_re_date" value="<?php if(isset($row)){echo $row['len_re_date'];}?>" disabled><br>
                    <label for = "due_date">해제날짜</label>
                    <input type= "date" name="due_exp" id="id_exp" value="<?php if(isset($row)){echo $row['due_exp'];}?>"><br>
                    <input type="hidden" name="due_no" value="<?php if(isset($row)){echo $row['due_no'];}?>">
                </ul>
                <div class="form_class">
                    <input type= "submit" value="<?=$title2 ?>">
                    <input type= "reset" value='지우기'>
                </div>
            </fieldset>
        </form>
    </body>
</html>