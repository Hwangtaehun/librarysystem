<!DOCTYPE html>
<html>
<head>
    <script>
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("책이름을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_author.length <= 0){
                alert("저자를 입력하세요.");
                myform.id_author.focus();
                return false;
            }
            if(myform.id_publish.value.length <= 0){
                alert("출판사를 입력하세요.");
                myform.id_publish.focus();
                return false;
            }
            if(myform.id_year.value.length <= 0){
                alert("출판년도를 입력하세요.");
                myform.id_year.focus();
                return false;
            }
            if(myform.id_price.value.length <= 0){
                alert("가격을 입력하세요.");
                myform.id_price.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <form action="/book/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for  = "book_name">책이름</label>
                <input class="input" type= "text" name="book_name" id="id_name" value="<?php if(isset($row)){echo $row['book_name'];}?>"><br>
                <label for  = "book_author">저자</label>
                <input class="input" type= "text" name="book_author" id="id_author" value="<?php if(isset($row)){echo $row['book_author'];}?>"><br>
                <label for  = "book_publish">출판사</label>
                <input class="input" type= "text" name="book_publish" id="id_publish" value="<?php if(isset($row)){echo $row['book_publish'];}?>"><br>
                <label for  = "book_year">출판년도</label>
                <input class="input" type= "text" name="book_year" id="id_year" value="<?php if(isset($row)){echo $row['book_year'];}?>"><br>
                <label for  = "book_price">가격</label>
                <input class="input" type= "text" name="book_price" id="id_price" value="<?php if(isset($row)){echo $row['book_price'];}?>"><br>
                <input type="hidden" name="book_no" value="<?php if(isset($row)){echo $row['book_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
</body>
</html>