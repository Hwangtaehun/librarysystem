<!DOCTYPE html>
<html>
<head>
    <?php
    $state = 2;

    if(isset($_SESSION['mem_state'])){
        $state = $_SESSION['mem_state'];
    }

    if($state == 1){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
    }else{
        $title = '공지사항 내용';
        echo '<link rel="stylesheet" href="../css/form-noaside.css">';
    }
    ?>
    <script>
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("제목을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_detail.length <= 0){
                alert("내용을 입력하세요.");
                myform.id_detail.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <form action="/not/addupdate" method="post" onSubmit="return checkInput(this)" enctype="multipart/form-data">
        <fieldset id = form_fieldset>
        <?php if($state == 1){ ?>
        <h2><?=$title?></h2>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for  = "not_name">제목</label>
                <input class="input" type= "text" name="not_name" id="id_name" value="<?php if(isset($row)){echo $row['not_name'];}?>"><br>
                <label for  = "not_open">시작일시</label>
                <input type="date" name="not_op_date" id="id_op_date" value="<?php if(isset($row)){echo $row['not_op_date'];}?>">
                <label for  = "not_close">종료일시</label>
                <input type="date" name="not_cl_date" id="id_cl_date" value="<?php if(isset($row)){echo $row['not_cl_date'];}?>"><br>
                <label for  = "not_detail">내용</label><br>
                <textarea class="context" name="not_detail" id="id_context" cols="30" rows="10"><?php if(isset($row)){echo $row['not_detail'];}?></textarea><br>
                <label for  = "not_det_url">내용 이미지</label>
                <input class="input" type= "file" name="not_det_url" id="id_det" value="">
                <input type="hidden" name="not_det_url" value="<?php if(isset($row)){echo $row['not_det_url'];}?>"><br>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckBan" onclick="ban_box(this)">
                    <label class="form-check-label" for="flexCheckBan">
                        배너
                    </label>
                </div>
                <label for  = "not_ban_url">배너이미지</label>
                <input class="input" type= "file" name="not_ban_url" id="id_ban" value="" disabled>
                <input type="hidden" name="not_ban_url" value="<?php if(isset($row)){echo $row['not_ban_url'];}?>"><br>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckPop" onclick="pop_box(this)">
                    <label class="form-check-label" for="flexCheckPop">
                        팝업
                    </label>
                </div>
                <label for  = "not_pop_url">팝업이미지</label>
                <input class="input" type= "file" name="not_pop_url" id="id_pop" value="" disabled>
                <input type="hidden" name="not_pop_url" value="<?php if(isset($row)){echo $row['not_pop_url'];}?>"><br>
                <label for  = "not_pop_x">팝업 좌측 위치</label>
                <input class="input" type= "number" name="not_pop_x" id="id_pop_x" value="<?php if(isset($row)){echo $row['not_pop_x'];}?>" disabled>
                <label for  = "not_pop_y">팝업 상단 위치</label>
                <input class="input" type= "number" name="not_pop_y" id="id_pop_y" value="<?php if(isset($row)){echo $row['not_pop_y'];}?>" disabled><br>
                <label for  = "not_pop_wid">팝업 넓이</label>
                <input class="input" type= "number" name="not_pop_wid" id="id_pop_wid" value="<?php if(isset($row)){echo $row['not_pop_wid'];}?>" disabled>
                <label for  = "not_pop_hei">팝업 높이</label>
                <input class="input" type= "number" name="not_pop_hei" id="id_pop_hei" value="<?php if(isset($row)){echo $row['not_pop_hei'];}?>" disabled><br>
                <input type="hidden" name="not_no" value="<?php if(isset($row)){echo $row['not_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        <?php }else{?>
            <h2><?=$title?></h2>
            <ul><label for  = "not_name">제목</label>
                <input class="input" type= "text" name="not_name" id="id_name" value="<?php if(isset($row)){echo $row['not_name'];}?>" readonly><br>
                <label for  = "not_detail">내용</label><br>
                <a href="<?php if(isset($row)){echo '.'.$row['not_det_url'];}?>">
                    <img src="<?php if(isset($row)){echo '.'.$row['not_det_url'];}?>" width="75%">
                </a><br>
                <textarea class="context" name="not_detail" id="id_context" cols="30" rows="10" readonly>
<?php if(isset($row)){echo $row['not_detail'];}?>
                </textarea><br>
            </ul>
            <div class="form_class">
                <input type="button" value="이전" onclick="javascript:history.back()">
                <a href="/not/list"><input type="button" value="목록"></a>
            </div>
        <?php } ?>
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