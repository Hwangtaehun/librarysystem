<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("제목을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_detail.length <= 0){
                alert("내용을 입력하세요.");
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
<?php
$state = 2;
$today = date("Y-m-d");

if(isset($_SESSION['mem_state'])){
    $state = $_SESSION['mem_state'];
}
?>
<body>
    <form action="/book/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for  = "not_name">제목</label>
                <input class="input" type= "text" name="not_name" id="id_name" value="<?php if(isset($row)){echo $row['not_name'];}?>"><br>
                <label for  = "not_open">시작일시</label>
                <input type="date" name="not_op_date" id="id_op_date" value="<?php if(isset($row)){echo $row['not_op_date'];}else{$today;}?>"><br>
                <label for  = "not_close">종료일시</label>
                <input type="date" name="not_op_date" id="id_op_date" value="<?php if(isset($row)){echo $row['not_cl_date'];}?>"><br>
                <label for  = "not_detail">내용</label><br>
                <input class="input" type= "text" name="not_detail" id="id_detail" value="<?php if(isset($row)){echo $row['not_detail'];}?>"><br>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckBan">
                    <label class="form-check-label" for="flexCheckBan">
                        배너
                    </label>
                </div>
                <label for  = "not_ban_url">배너이미지</label>
                <input class="input" type= "file" name="not_ban_url" id="id_ban" value="<?php if(isset($row)){echo $row['not_ban_url'];}?>" disabled><br>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckPop">
                    <label class="form-check-label" for="flexCheckPop">
                        팝업
                    </label>
                </div>
                <label for  = "not_pop_url">팝업이미지</label>
                <input class="input" type= "file" name="not_pop_url" id="id_pop" value="<?php if(isset($row)){echo $row['not_pop_url'];}?>" disabled><br>
                <label for  = "not_pop_x">팝업 좌측 위치</label>
                <input class="input" type= "number" name="not_pop_x" id="id_pop_x" value="<?php if(isset($row)){echo $row['not_pop_x'];}?>" disabled><br>
                <label for  = "not_pop_y">팝업 상단 위치</label>
                <input class="input" type= "number" name="not_pop_y" id="id_pop_y" value="<?php if(isset($row)){echo $row['not_pop_y'];}?>" disabled><br>
                <label for  = "not_pop_wid">팝업 넓이</label>
                <input class="input" type= "number" name="not_pop_wid" id="id_pop_wid" value="<?php if(isset($row)){echo $row['not_pop_wid'];}?>" disabled><br>
                <label for  = "not_pop_hei">팝업 높이</label>
                <input class="input" type= "number" name="not_pop_hei" id="id_pop_hei" value="<?php if(isset($row)){echo $row['not_pop_hei'];}?>" disabled><br>
                <input type="hidden" name="not_no" value="<?php if(isset($row)){echo $row['not_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
    <script>
        const cb_id = document.getElementById('flexCheckBan');
        const cp_id = document.getElementById('flexCheckPop');
        const bu_id = document.getElementById('id_ban');
        const pu_id = document.getElementById('id_pop');
        const px_id = document.getElementById('id_pop_x');
        const py_id = document.getElementById('id_pop_y');
        const pw_id = document.getElementById('id_pop_wid');
        const ph_id = document.getElementById('id_pop_hei');

    <?php
        $ban = false;
        $pop = false;
        if(isset($row)){
            if(isset($row['not_ban_url'])){
                $ban = true;
            }
            if(isset($row['not_pop_url'])){
                $pop = true;
            }
        }

        if($ban){
    ?>
            cb_id.checked = true;
            bu_id.disabled = false;
    <?php
        }

        if($pop){
    ?>
            cp_id.checked = true;
            pu_id.disabled = false;
            px_id.disabled = false;
            py_id.disabled = false;
            pw_id.disabled = false;
            ph_id.disabled = false;
    <?php        
        }
    ?>

        function ban_box(checkbox) {
            bu_id.disabled = checkbox.checked ? false : true;

            if(bu_id.disabled) {
                bu_id.value = null;
            }else{
                bu_id.focus();
            }
        }

        function pop_box(checkbox) {
            pu_id.disabled = checkbox.checked ? false : true;
            px_id.disabled = checkbox.checked ? false : true;
            py_id.disabled = checkbox.checked ? false : true;
            pw_id.disabled = checkbox.checked ? false : true;
            ph_id.disabled = checkbox.checked ? false : true;

            if(pu_id.disabled) {
                pu_id.value = null;
                px_id.value = null;
                py_id.value = null;
                pw_id.value = null;
                ph_id.value = null;
            }else{
                pu_id.focus();
            }
        }
    </script>
</body>
</html>