<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        //필수 입력했는지 확인 하는 함수
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("도서를 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_author.value.length <= 0){
                alert("저자를 입력하세요.");
                myform.id_author.focus();
                return false;
            }
            if(myform.id_author.value.includes('(')){
                alert("저자 부분에 ()를 지워주세요.");
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

        function isbnValue(no, name, aut, pub, year, price, url){
            document.querySelector("#id_id").value = no;
            document.querySelector("#id_name").value = name;
            document.querySelector("#id_author").value = aut;
            document.querySelector("#id_publish").value = pub;
            document.querySelector("#id_year").value = year;
            document.querySelector("#id_price").value = price;
            document.querySelector("#id_url").value = url;
            document.querySelector("#id_img").src = url;
        }

        function checkbook() {
            const url = "/book/isbn";
            window.open(url,"chkbk","width=550,height=620");
        }
    </script>
</head>
<body>
    <form action="/book/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
            <div class="form_text">
                <ul>
                    <li>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">직접입력</label>
                    </div>
                    <input type = "button" name="book_check" id="id_check" value="책검색" onclick="checkbook();">
                    </li>
                    <li><label for  = "id_id">ISBN</label><br>
                        <input class="input" type= "text" name="book_no" id="id_id" value="<?php if(isset($row)){echo $row['book_no'];}?>" readonly></li>
                    <li><label for  = "id_name">책이름</label><br>
                        <input class="input" type= "text" name="book_name" id="id_name" value="<?php if(isset($row)){echo $row['book_name'];}?>" readonly></li>
                    <li><label for  = "id_author">저자</label><br>
                        <input class="input" type= "text" name="book_author" id="id_author" value="<?php if(isset($row)){echo $row['book_author'];}?>" readonly></li>
                    <li><label for  = "id_publish">출판사</label><br>
                        <input class="input" type= "text" name="book_publish" id="id_publish" value="<?php if(isset($row)){echo $row['book_publish'];}?>" readonly></li>
                    <li><label for  = "id_year">출판년도</label><br>
                        <input class="input" type= "text" name="book_year" id="id_year" value="<?php if(isset($row)){echo $row['book_year'];}?>" readonly></li>
                    <li><label for  = "id_price">가격</label><br>
                        <input class="input" type= "text" name="book_price" id="id_price" value="<?php if(isset($row)){echo $row['book_price'];}?>" readonly></li>
                    <li><label for  = "id_img">이미지</label><br>
                        <img id="id_img" src="<?php if(isset($row)){echo $row['book_url'];}?>" alt="">
                        <input class="input" type= "hidden" name="book_url" id="id_url" value="<?php if(isset($row)){echo $row['book_url'];}?>" readonly></li>
                        <input type="hidden" name="bk_no" value="<?php if(isset($row)){echo $row['book_no'];}?>">
                    <div class="form_bt">
                        <input type= "submit" value="<?=$title2 ?>">
                        <input type= "reset" value='지우기'>
                    </div>
                </ul>
            </div>
        </fieldset>
    </form>
    <script>
        const no = document.querySelector("#id_id");
        const ne = document.querySelector("#id_name");
        const author = document.querySelector("#id_author");
        const publish = document.querySelector("#id_publish");
        const year = document.querySelector("#id_year");
        const price = document.querySelector("#id_price");
        const url = document.querySelector("#id_url");
        const img = document.querySelector("#id_img");
        const res = document.querySelector("#id_check");

        document.querySelector("#flexSwitchCheckDefault").addEventListener("change", function (e) {
            e.preventDefault();

            if(this.checked == true){
                res.disabled = true;
                no.readOnly = false;
                ne.readOnly = false;
                author.readOnly = false;
                publish.readOnly = false;
                year.readOnly = false;
                price.readOnly = false;
                url.readOnly = false;
                img.readOnly = false;
            }else{
                res.disabled = false;
                no.readOnly = true;
                ne.readOnly = true;
                author.readOnly = true;
                publish.readOnly = true;
                year.readOnly = true;
                price.readOnly = true;
                url.readOnly = true;
                img.readOnly = true;
            }
        });
    </script>
</body>
</html>