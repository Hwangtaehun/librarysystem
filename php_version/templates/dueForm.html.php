<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/form-base.css">
    </head>
    <body>
        <form action="/etc/addupdate" method="post" onSubmit="return checkInput(this)">
            <fieldset id = form_fieldset>
            <h2><?=$title?></h2>
                <div class="form_text">
                    <ul>
                        <li><label for  = "id_id">회원아이디</label><br>
                            <input class="input" type= "text" name="due_id" id="id_id" value="<?php if(isset($row)){echo $row['mem_id'];}?>" disabled></li>
                        <li><label for  = "id_name">책이름</label><br>
                            <input class="input" type= "text" name="due_name" id="id_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" disabled></li>
                        <li><label for = "id_date">대출날짜</label><br>
                            <input type= "date" name="due_date" id="id_date" value="<?php if(isset($row)){echo $row['len_date'];}?>" disabled></li>
                        <li><label for = "id_re_date">반납날짜</label><br>
                            <input type= "date" name="due_re_date" id="id_re_date" value="<?php if(isset($row)){echo $row['len_re_date'];}?>" disabled></li>
                        <li><label for = "id_exp">해제날짜</label><br>
                            <input type= "date" name="due_exp" id="id_exp" value="<?php if(isset($row)){echo $row['due_exp'];}?>"></li>
                        <input type="hidden" name="due_no" value="<?php if(isset($row)){echo $row['due_no'];}?>">
                        <div class="form_bt">
                            <input type= "submit" value="<?=$title2 ?>">
                            <input type= "reset" value='지우기'>
                        </div>
                    </ul>
                </div>
            </fieldset>
        </form>
    </body>
</html>